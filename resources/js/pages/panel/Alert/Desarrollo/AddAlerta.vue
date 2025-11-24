<template>
    <Toolbar class="mb-6">
        <template #start>
            <Button
                label="Nueva Alerta"
                icon="pi pi-plus"
                severity="secondary"
                class="mr-2"
                @click="openNew"
            />
        </template>

        <template #end>
            <AddCAlert />
        </template>
    </Toolbar>

    <Dialog
        v-model:visible="alertaDialog"
        :modal="true"
        :style="{ width: '95vw', maxWidth: '600px' }"
        header="Registro de Alerta"
        class="w-full max-w-full sm:max-w-lg"
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
                        placeholder="Ingrese título de la alerta"
                        class="w-full"
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
                        placeholder="Ingrese descripción"
                        class="w-full"
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
                @click="hideDialog"
            />
            <Button
                label="Guardar"
                icon="pi pi-check"
                @click="guardarAlerta"
            />
        </template>
    </Dialog>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios, { AxiosError } from 'axios';
import Dialog from 'primevue/dialog';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { useToast } from 'primevue/usetoast';
import AddCAlert from './AddCAlert.vue';

interface Alerta {
    titulo: string;
    descripcion: string;
    fecha: string;
}

// Refs y estado
const toast = useToast();
const submitted = ref(false);
const alertaDialog = ref(false);
const serverErrors = ref<Record<string, string[]>>({});

const emit = defineEmits<{
    (e: 'alerta-agregada'): void;
}>();

const alerta = ref<Alerta>({
    titulo: '',
    descripcion: '',
    fecha: '',
});

// Abrir modal
function openNew() {
    resetAlerta();
    alertaDialog.value = true;
}

// Cerrar modal
function hideDialog() {
    alertaDialog.value = false;
    resetAlerta();
}

// Reset
function resetAlerta() {
    alerta.value = {
        titulo: '',
        descripcion: '',
        fecha: '',
    };
    serverErrors.value = {};
    submitted.value = false;
}

// Guardar alerta
function guardarAlerta() {
    submitted.value = true;
    serverErrors.value = {};

    // Validación mínima en front
    if (!alerta.value.titulo || !alerta.value.fecha) return;

    console.log('Payload enviado:', alerta.value);

    axios
        .post('/alerta', alerta.value)
        .then(() => {
            toast.add({
                severity: 'success',
                summary: 'Éxito',
                detail: 'Alerta registrada',
                life: 3000,
            });
            hideDialog();
            emit('alerta-agregada');
        })
        .catch((error: AxiosError<{ errors?: Record<string, string[]> }>) => {
            console.log('Respuesta error /alerta:', error.response?.data);

            if (error.response && error.response.status === 422) {
                serverErrors.value = error.response.data.errors || {};
            } else {
                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: 'No se pudo registrar la alerta',
                    life: 3000,
                });
            }
        });

}
</script>
