<template>
    <Dialog
        v-model:visible="dialogVisible"
        header="Editar Alerta"
        :modal="true"
        class="w-full max-w-full sm:max-w-lg"
        :style="{ width: '95vw', maxWidth: '600px' }"
    >
        <div class="flex flex-col gap-6">
            <div class="grid grid-cols-12 gap-4">
                <!-- TÍTULO -->
                <div class="col-span-12">
                    <label class="block font-bold mb-2">
                        Título <span class="text-red-500">*</span>
                    </label>
                    <InputText
                        v-model.trim="alerta.titulo"
                        placeholder="Ingrese el título de la alerta"
                        class="w-full"
                        :class="{ 'p-invalid': submitted && !alerta.titulo || serverErrors.titulo }"
                    />
                    <small
                        v-if="submitted && !alerta.titulo"
                        class="text-red-500"
                    >
                        El título es obligatorio.
                    </small>
                    <small
                        v-if="serverErrors.titulo"
                        class="text-red-500"
                    >
                        {{ serverErrors.titulo[0] }}
                    </small>
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="col-span-12">
                    <label class="block font-bold mb-2">Descripción</label>
                    <InputText
                        v-model.trim="alerta.descripcion"
                        placeholder="Ingrese la descripción de la alerta"
                        class="w-full"
                        :class="{ 'p-invalid': serverErrors.descripcion }"
                    />
                    <small
                        v-if="serverErrors.descripcion"
                        class="text-red-500"
                    >
                        {{ serverErrors.descripcion[0] }}
                    </small>
                </div>

                <!-- FECHA -->
                <div class="col-span-12">
                    <label class="block font-bold mb-2">
                        Fecha <span class="text-red-500">*</span>
                    </label>
                    <InputText
                        type="date"
                        v-model="alerta.fecha"
                        class="w-full"
                        :class="{ 'p-invalid': submitted && !alerta.fecha || serverErrors.fecha }"
                    />
                    <small
                        v-if="submitted && !alerta.fecha"
                        class="text-red-500"
                    >
                        La fecha es obligatoria.
                    </small>
                    <small
                        v-if="serverErrors.fecha"
                        class="text-red-500"
                    >
                        {{ serverErrors.fecha[0] }}
                    </small>
                </div>
            </div>
        </div>

        <template #footer>
            <Button
                label="Cancelar"
                icon="pi pi-times"
                text
                class="mr-2"
                @click="dialogVisible = false"
            />
            <Button
                label="Guardar"
                icon="pi pi-check"
                :loading="loading"
                @click="updateAlerta"
            />
        </template>
    </Dialog>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import axios, { AxiosError } from 'axios';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { useToast } from 'primevue/usetoast';

interface Alerta {
    titulo: string;
    descripcion: string;
    fecha: string; // formato YYYY-MM-DD
}

interface ServerErrors {
    [key: string]: string[];
}

// Props
const props = defineProps<{
    visible: boolean;
    alertaId: number | null;
}>();

// Emit
const emit = defineEmits<{
    (e: 'update:visible', value: boolean): void;
    (e: 'updated'): void;
}>();

// Estado
const dialogVisible = ref<boolean>(props.visible);
const loading = ref<boolean>(false);
const submitted = ref<boolean>(false);
const serverErrors = ref<ServerErrors>({});
const alerta = ref<Alerta>({
    titulo: '',
    descripcion: '',
    fecha: '',
});

// Toast
const toast = useToast();

// Sincronizar prop visible <-> dialogVisible
watch(
    () => props.visible,
    (val) => {
        dialogVisible.value = val;
        if (val && props.alertaId) {
            fetchAlerta();
        }
    }
);
watch(dialogVisible, (val) => emit('update:visible', val));

// Cargar alerta desde el backend
const fetchAlerta = async (): Promise<void> => {
    try {
        loading.value = true;
        serverErrors.value = {};

        const res = await axios.get(`/alerta/${props.alertaId}`);

        if (!res.data || !res.data.alert) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Alerta no encontrada',
                life: 3000,
            });
            return;
        }

        const data = res.data.alert;

        // El AlertResource ya devuelve fecha como 'Y-m-d'
        alerta.value = {
            titulo: data.titulo ?? '',
            descripcion: data.descripcion ?? '',
            fecha: data.fecha ?? '',
        };
    } catch (error) {
        console.error(error);
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'No se pudo cargar la alerta',
            life: 3000,
        });
    } finally {
        loading.value = false;
    }
};

// Actualizar alerta
const updateAlerta = async (): Promise<void> => {
    submitted.value = true;
    serverErrors.value = {};

    // Validación básica en el front
    if (!alerta.value.titulo || !alerta.value.fecha) return;

    try {
        loading.value = true;

        await axios.put(`/alerta/${props.alertaId}`, alerta.value);

        toast.add({
            severity: 'success',
            summary: 'Actualizado',
            detail: 'Alerta actualizada correctamente',
            life: 3000,
        });

        dialogVisible.value = false;
        emit('updated');
    } catch (error) {
        const err = error as AxiosError<{ errors?: ServerErrors }>;

        if (err.response?.status === 422 && err.response.data?.errors) {
            serverErrors.value = err.response.data.errors;
            toast.add({
                severity: 'error',
                summary: 'Error de validación',
                detail: 'Revisa los campos e intenta nuevamente',
                life: 5000,
            });
        } else {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'No se pudo actualizar la alerta',
                life: 3000,
            });
        }

        console.error(error);
    } finally {
        loading.value = false;
    }
};
</script>
