<template>
    <Head title="Configuración de Alertas" />
    <AppLayout>
        <div>
            <template v-if="isLoading">
                <Espera/>
            </template>

            <template v-else>
                <div class="card">
                    <AddConfigAlerta @config-alerta-agregada="refrescarListado"/>
                    <ListConfigAlerta :refresh="refreshKey"/>
                </div>
                <!-- Imagen admin centrada debajo de configuración de alertas -->
                <div class="flex justify-center items-center mt-6 mb-6">
                    <img src="/imagenes/admin.png" alt="Admin" class="max-w-xs h-auto rounded-lg shadow-md"/>
                </div>
            </template>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import AppLayout from '@/layout/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Espera from '@/components/Espera.vue';
//import AddConfigAlert from './Desarrollo/AddConfigAlert.vue';
import ListConfigAlerta from './Desarrollo/ListConfigAlerta.vue';
import AddConfigAlerta from './Desarrollo/AddConfigAlerta.vue';

const isLoading = ref(true);
const refreshKey = ref(0);

function refrescarListado() {
    refreshKey.value++;
}

onMounted(() => {
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);
});
</script>
