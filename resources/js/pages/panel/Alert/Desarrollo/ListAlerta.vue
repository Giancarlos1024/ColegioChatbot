<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Tag from 'primevue/tag';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import axios from 'axios';
import { debounce } from 'lodash';
import DeleteAlerta from './DeleteAlerta.vue';
import UpdateAlerta from './UpdateAlerta.vue';
import { useToast } from 'primevue/usetoast';
import Calendar from 'primevue/calendar';

// 🔹 Ya no usamos ViewAlerta ni movimientos
// import ViewAlerta from './ViewAlerta.vue';

// Tipos
interface Alerta {
    id: number;
    titulo: string | null;
    descripcion: string | null;
    fecha: string;
    creacion: string;
    actualizacion: string;
}

interface Pagination {
    currentPage: number;
    perPage: number;
    total: number;
}

// Props
const props = defineProps<{ refresh: number }>();

// Toast
const toast = useToast();

// Refs
const dt = ref<any>(null);
const alertas = ref<Alerta[]>([]);
const selectedAlertas = ref<Alerta[]>([]);
const selectedDate = ref<Date | null>(null);
const loading = ref(false);
const globalFilterValue = ref('');
const deleteAlertaDialog = ref(false);
const updateAlertaDialog = ref(false);
const alerta = ref<Alerta | null>(null);
const selectedAlertaId = ref<number | null>(null);
const currentPage = ref(1);
const pagination = ref<Pagination>({
    currentPage: 1,
    perPage: 15,
    total: 0
});

// Watchers
watch(
    () => props.refresh,
    () => loadAlertas()
);

watch(
    () => selectedDate.value,
    () => {
        currentPage.value = 1;
        loadAlertas();
    }
);

// Funciones
function editAlerta(a: Alerta) {
    selectedAlertaId.value = a.id;
    updateAlertaDialog.value = true;
}

function confirmDeleteAlerta(a: Alerta) {
    alerta.value = a;
    deleteAlertaDialog.value = true;
}

function handleAlertaDeleted() {
    loadAlertas();
}

function handleAlertaUpdated() {
    loadAlertas();
}

const loadAlertas = async (): Promise<void> => {
    loading.value = true;
    try {
        const params: any = {
            page: pagination.value.currentPage,
            per_page: pagination.value.perPage,
            search: globalFilterValue.value,
            // tipo: ya no se usa
            fecha: selectedDate.value
                ? selectedDate.value.toISOString().slice(0, 10)
                : ''
        };

        const response = await axios.get('/alerta', { params });

        alertas.value = response.data.data;
        pagination.value.currentPage = response.data.meta.current_page;
        pagination.value.total = response.data.meta.total;
    } catch (error) {
        console.error('Error al cargar alertas:', error);
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'No se pudieron cargar las alertas',
            life: 3000
        });
    } finally {
        loading.value = false;
    }
};

// Paginado
const onPage = (event: { page: number; rows: number }) => {
    pagination.value.currentPage = event.page + 1;
    pagination.value.perPage = event.rows;
    loadAlertas();
};

// Búsqueda global
const onGlobalSearch = debounce(() => {
    pagination.value.currentPage = 1;
    loadAlertas();
}, 500);

onMounted(() => loadAlertas());
</script>

<template>
    <DataTable
        ref="dt"
        v-model:selection="selectedAlertas"
        :value="alertas"
        dataKey="id"
        :paginator="true"
        :rows="pagination.perPage"
        :totalRecords="pagination.total"
        :loading="loading"
        :lazy="true"
        @page="onPage"
        :rowsPerPageOptions="[15, 20, 25]"
        scrollable
        scrollHeight="574px"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} alertas"
        class="w-full"
    >
        <template #header>
            <div
                class="flex flex-col md:flex-row flex-wrap gap-2 items-start md:items-center justify-between"
            >
                <h4 class="m-0">ALERTAS</h4>

                <!-- Contenedor derecho -->
                <div class="flex flex-col items-end gap-2 w-full md:w-auto">
                    <!-- FILTRO FECHA -->
                    <div class="flex flex-row gap-2">
                        <Calendar
                            v-model="selectedDate"
                            dateFormat="yy-mm-dd"
                            placeholder="Filtrar por fecha"
                            class="w-full md:w-auto"
                        />
                        <Button
                            icon="pi pi-times"
                            outlined
                            rounded
                            class="w-full md:w-auto"
                            @click="selectedDate = null"
                        />
                    </div>

                    <!-- BUSCADOR GLOBAL -->
                    <div class="flex flex-row gap-2">
                        <IconField class="w-full md:w-auto">
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText
                                v-model="globalFilterValue"
                                @input="onGlobalSearch"
                                placeholder="Buscar por título o descripción..."
                                class="w-full md:w-80"
                            />
                        </IconField>

                        <Button
                            icon="pi pi-refresh"
                            outlined
                            rounded
                            class="w-full md:w-auto"
                            @click="loadAlertas"
                        />
                    </div>
                </div>
            </div>
        </template>

        <Column selectionMode="multiple" style="width: 1rem" />

        <!-- 🔹 Nueva columna: TÍTULO -->
        <Column field="titulo" header="Título" sortable style="min-width: 12rem">
            <template #body="{ data }">
                {{ data.titulo || '-' }}
            </template>
        </Column>

        <Column
            field="descripcion"
            header="Descripción"
            sortable
            style="min-width: 12rem"
        />
        <Column
            field="fecha"
            header="Fecha"
            sortable
            style="min-width: 10rem"
        />
        <Column
            field="creacion"
            header="Creación"
            sortable
            style="min-width: 13rem"
        />
        <Column
            field="actualizacion"
            header="Actualización"
            sortable
            style="min-width: 13rem"
        />

        <Column
            field="acciones"
            header="Acciones"
            :exportable="false"
            style="min-width: 10rem"
        >
            <template #body="{ data }">
                <!-- Ya no hay botón de ver movimientos (pi-eye) -->
                <Button
                    icon="pi pi-pencil"
                    outlined
                    rounded
                    class="mr-2 mb-2 md:mb-0"
                    @click="editAlerta(data)"
                />
                <Button
                    icon="pi pi-trash"
                    outlined
                    rounded
                    severity="danger"
                    class="mb-2 md:mb-0"
                    @click="confirmDeleteAlerta(data)"
                />
            </template>
        </Column>
    </DataTable>

    <DeleteAlerta
        v-model:visible="deleteAlertaDialog"
        :alerta="alerta"
        @deleted="handleAlertaDeleted"
    />
    <UpdateAlerta
        v-model:visible="updateAlertaDialog"
        :alertaId="selectedAlertaId"
        @updated="handleAlertaUpdated"
    />
</template>
