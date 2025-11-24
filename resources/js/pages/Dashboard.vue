<script setup lang="ts">
import AppLayout from '@/layout/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import Message from 'primevue/message';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Password from './settings/Password.vue';
import { router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const page = usePage();
const mustReset = (page.props as any).mustReset;
const user = ref((page.props as any).auth.user || {});
const stats = ref({});

// Función para determinar el saludo
const getGreeting = () => {
  const hours = new Date().getHours();
  if (hours < 12) {
    return 'Buenos días';
  } else if (hours < 18) {
    return 'Buenas tardes';
  } else {
    return 'Buenas noches';
  }
};

// Mensajes motivacionales
const motivationalMessages = [
  "¡Estás haciendo un gran trabajo, sigue así!",
  "¡Hoy es un buen día para alcanzar tus metas!",
  "¡La perseverancia te lleva lejos, nunca pares!",
  "¡Cada paso te acerca más a tu éxito!"
];

const getMotivationalMessage = () => {
  const randomIndex = Math.floor(Math.random() * motivationalMessages.length);
  return motivationalMessages[randomIndex];
};

// Función para redirigir a registro de admin
const goToAdminRegister = () => {
  router.get('/admin/register');
};

// Función para cargar datos del dashboard
const loadDashboardData = async () => {
  try {
    const response = await fetch('/datos/dashboard');
    const data = await response.json();
    
    stats.value = data.stats || {};
    user.value = data.user || user.value;
  } catch (error) {
    console.error('Error cargando datos del dashboard:', error);
  }
};

onMounted(() => {
  loadDashboardData();
});
</script>

<template>
    <Head title="Dashboard" />
    <div v-if="mustReset">
        <Password />
    </div>
    <AppLayout v-else>
        <div class="p-6">
            <!-- Saludo -->
            <div class="card mb-6">
                <div class="text-center p-4">
                    <h1 class="text-3xl font-bold mb-2">{{ getGreeting() }}, {{ user?.name }}!</h1>
                    <Message severity="info" class="mt-4">
                        {{ getMotivationalMessage() }}
                    </Message>
                </div>
            </div>

            <!-- Dashboard principal -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Estadísticas -->
                <Card>
                    <template #title>Estadísticas del Sistema</template>
                    <template #content>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span>Total Usuarios:</span>
                                <span class="font-bold">{{ stats.totalUsers || 0 }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Estudiantes:</span>
                                <span class="font-bold">{{ stats.totalStudents || 0 }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Talleres:</span>
                                <span class="font-bold">{{ stats.totalTalleres || 0 }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Alertas:</span>
                                <span class="font-bold">{{ stats.totalAlerts || 0 }}</span>
                            </div>
                        </div>
                    </template>
                </Card>

                <!-- Acciones Rápidas -->
                <Card>
                    <template #title>Acciones Rápidas</template>
                    <template #content>
                        <div class="space-y-3">
                            <Button 
                                v-if="user?.role === 'administrador'" 
                                label="Registrar Administrador" 
                                icon="pi pi-user-plus" 
                                class="p-button-outlined p-button-danger w-full"
                                @click="goToAdminRegister"
                            />
                            <Button 
                                label="Ver Talleres" 
                                icon="pi pi-briefcase" 
                                class="p-button-outlined p-button-info w-full"
                                @click="router.get('/talleres')"
                            />
                            <Button 
                                label="Gestionar Usuarios" 
                                icon="pi pi-users" 
                                class="p-button-outlined p-button-success w-full"
                                @click="router.get('/usuario')"
                            />
                        </div>
                    </template>
                </Card>

                <!-- Información del Usuario -->
                <Card>
                    <template #title>Mi Información</template>
                    <template #content>
                        <div class="space-y-3">
                            <div>
                                <strong>Nombre:</strong> {{ user?.name || 'No definido' }}
                            </div>
                            <div>
                                <strong>Email:</strong> {{ user?.email || 'N/A' }}
                            </div>
                            <div>
                                <strong>Username:</strong> {{ user?.username || 'N/A' }}
                            </div>
                            <div>
                                <strong>DNI:</strong> {{ user?.dni || 'N/A' }}
                            </div>
                            <div>
                                <strong>Estado:</strong> 
                                <span :class="user?.status ? 'text-green-600 font-bold' : 'text-red-600 font-bold'">
                                    {{ user?.status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                            <div>
                                <strong>Fecha de Registro:</strong> 
                                <span>{{ user?.created_at ? new Date(user.created_at).toLocaleDateString() : 'N/A' }}</span>
                            </div>
                        </div>
                    </template>
                </Card>
            </div>

            <!-- Botones de navegación -->
            <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                <Button label="Horarios" icon="pi pi-clock" @click="router.get('/horarios')" />
                <Button label="Alertas" icon="pi pi-bell" @click="router.get('/alertas')" />
                <Button label="Talleres" icon="pi pi-briefcase" @click="router.get('/talleres')" />
                <Button label="Roles" icon="pi pi-shield" @click="router.get('/roles')" />
            </div>

            <!-- Información de la Institución -->
            <div class="mt-8 card">
                <div class="text-center p-6 bg-blue-50 dark:bg-blue-900 rounded-lg">
                    <h2 class="text-2xl font-bold mb-4 text-blue-800 dark:text-blue-200">
                        INSTITUCIÓN EDUCATIVA INIF N° 48 "EDUCANDO PARA LA VIDA"
                    </h2>
                    
                    <!-- Reseña Histórica -->
                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-left space-y-4">
                        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Reseña Histórica</h3>
                        <p>
                            La Institución Educativa INIF Nº 48, fue creada por Ley Nº 14115 del 15 de Junio de 1962, 
                            como integrante de la Gran Unidad Escolar de Mujeres "Las Capullanas", iniciando sus labores el 1º de Marzo de 1965, 
                            con una sección de 65 alumnas matriculadas en el 1er.Gdo. de Educación Secundaria, siendo su primera Directora la Sra. Iluminada Jaramillo de Mendoza.
                        </p>
                        <p>
                            La Institución Educativa INIF Nº 48 a lo largo de su trayectoria educativa, ha sido dirigida por personal idóneo, 
                            destacando por su infalible lucha por el bienestar del alumnado, quienes al frente de la Dirección fueron construyendo 
                            el progreso, prestigio y sitial del que hoy goza nuestra Institución Educativa.
                        </p>
                        <p>
                            En 1995, INFES, remodeló la infraestructura acorde a nuestra era moderna, cuenta con 24 aulas, talleres de Áreas Técnicas, 
                            Laboratorio de Ciencias, Laboratorio de Innovaciones Pedagógicas (Aula Huascarán).
                        </p>
                        <p>
                            Como Institución Educativa Estatal brinda servicio educativo en Áreas Técnicas, Ciencias y Humanidades a nuestras alumnas 
                            a través de una educación de calidad basada en la práctica de valores como: <strong>responsabilidad, trabajo, fe, equidad, tolerancia y flexibilidad</strong>.
                        </p>
                        <p>
                            En el presente año a Institución Educativa INIF Nº 48 se encuentra bajo la dirección de la Sra. Directora <strong>Alicia Purizaca Furlong</strong>, 
                            teniendo como Sub – Director de Formación General al Profesor <strong>Felix Atoche Núnjar</strong>, la Profesora <strong>Carmen Girón Jaramillo</strong> como Jefa de Talleres 
                            y al Profesor <strong>Darwin Gutiérrez Chuyes</strong> como coordinador de la Sala de Innovación Pedagógica cuenta con <strong>44 Docentes, 09 Administrativos, 03 Auxiliares de Educación</strong>, 
                            para atender a <strong>1122 alumnas distribuidas en 24 secciones del 1º al 5º de Secundaria</strong>.
                     <p>
                        <strong> Actualmente es dirigido por Director Percy Távara Armestar, en la modalidad Jornada Escolar Completa, brindando servicio educativo de calidad y práctica de valores Justicia, Respeto, Responsabilidad, Honestidad,</strong>
                     </p>
                        </p>
                    </div>

                    <!-- Imágenes de la institución -->
                    <div class="mt-10 flex justify-center space-x-4">
                        <img src="/imagenes/admin.png" alt="Insignia de la Institución" class="w-24 h-24 rounded-full shadow-lg object-cover"/>
                        <img src="/imagenes/inif.jpg" alt="INIF N° 48" class="w-32 h-24 rounded-lg shadow-lg object-cover"/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
body {
    overflow-x: hidden;
}
.p-datatable-table {
    table-layout: fixed;
    width: 100%;
}
</style>
