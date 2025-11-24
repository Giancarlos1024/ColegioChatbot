<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center space-x-3">
            <img src="/imagenes/admin.png" alt="INIF 48" class="w-10 h-10 rounded-full object-cover" />
            <div>
              <h1 class="text-xl font-semibold text-gray-900 dark:text-white">INIF N° 48</h1>
              <p class="text-sm text-gray-600 dark:text-gray-400">Dashboard - Estudiante</p>
            </div>
          </div>
          
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700 dark:text-gray-300">Hola, {{ user?.name }}</span>
            <form action="/student/logout" method="POST" class="inline">
              <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                Cerrar Sesión
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Información del Usuario -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Mi Perfil</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ user?.name }} {{ user?.apellidos }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">DNI</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ user?.dni }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ user?.email }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ user?.username }}</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Mis Inscripciones -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Mis Talleres ({{ misTalleres.length }})
          </h2>
          
          <div v-if="misTalleres.length === 0" class="text-center py-8">
            <p class="text-gray-500 dark:text-gray-400">No estás inscrita en ningún taller</p>
            <p class="text-sm text-gray-400 mt-2">Explora los talleres disponibles para inscribirte</p>
          </div>
          
          <div v-else class="space-y-3">
            <div 
              v-for="taller in misTalleres" 
              :key="taller.id"
              class="border border-gray-200 dark:border-gray-700 rounded-lg p-4"
            >
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="font-medium text-gray-900 dark:text-white">{{ taller.nombre }}</h3>
                  <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ taller.descripcion }}</p>
                  <div class="mt-2 space-y-1 text-sm text-gray-500">
                    <p><strong>Horario:</strong> {{ taller.hora_inicio }} - {{ taller.hora_fin }}</p>
                    <p><strong>Sede:</strong> {{ taller.sede }}</p>
                  </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                  Inscrita
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Talleres Disponibles -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Talleres Disponibles
          </h2>
          
          <div class="space-y-4">
            <div 
              v-for="taller in talleresDisponibles" 
              :key="taller.id"
              class="border border-gray-200 dark:border-gray-700 rounded-lg p-4"
            >
              <div class="flex justify-between items-start">
                <div class="flex-1">
                  <h3 class="font-medium text-gray-900 dark:text-white">{{ taller.nombre }}</h3>
                  <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ taller.descripcion }}</p>
                  <div class="mt-2 space-y-1 text-sm text-gray-500">
                    <p><strong>Capacidad:</strong> {{ taller.capacidad_alumnos }} estudiantes</p>
                    <p><strong>Horario:</strong> {{ taller.hora_inicio }} - {{ taller.hora_fin }}</p>
                    <p><strong>Sede:</strong> {{ taller.sede }}</p>
                  </div>
                </div>
                
                <div class="ml-4 flex flex-col items-end">
                  <span 
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-2"
                    :class="{
                      'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300': taller.estado === 'lleno',
                      'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': taller.estado === 'disponible'
                    }"
                  >
                    {{ taller.estado === 'lleno' ? 'Lleno' : 'Disponible' }}
                  </span>
                  
                  <button
                    v-if="taller.estado === 'disponible' && !isInscrita(taller.id)"
                    @click="inscribirse(taller.id)"
                    :disabled="inscribing"
                    class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded disabled:opacity-50"
                  >
                    {{ inscribing ? 'Inscribiendo...' : 'Inscribirme' }}
                  </button>
                  
                  <button
                    v-if="isInscrita(taller.id)"
                    @click="desinscribirse(taller.id)"
                    :disabled="desinscribiendo"
                    class="text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded disabled:opacity-50"
                  >
                    {{ desinscribiendo ? 'Desinscribiendo...' : 'Desinscribirme' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mensajes -->
      <div v-if="successMessage" class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-sm text-green-600">{{ successMessage }}</p>
      </div>
      
      <div v-if="errorMessage" class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <p class="text-sm text-red-600">{{ errorMessage }}</p>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';

// Props (viene del controlador)
const props = defineProps<{
  user: any;
  talleresDisponibles: any[];
  misTalleres: any[];
}>();

// Estado
const inscribing = ref(false);
const desinscribiendo = ref(false);
const successMessage = ref('');
const errorMessage = ref('');

// Verificar si está inscrita en un taller
const isInscrita = (tallerId: number) => {
  return props.misTalleres.some(taller => taller.id === tallerId);
};

// Inscribirse a un taller
const inscribirse = async (tallerId: number) => {
  inscribing.value = true;
  successMessage.value = '';
  errorMessage.value = '';

  try {
    const response = await fetch(`/student/inscribirse/${tallerId}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      }
    });

    const data = await response.json();

    if (response.ok) {
      successMessage.value = data.message || '¡Te has inscrito exitosamente!';
      // Recargar la página para actualizar los datos
      setTimeout(() => {
        window.location.reload();
      }, 1500);
    } else {
      errorMessage.value = data.message || 'Error al inscribirse en el taller.';
    }
  } catch (error) {
    console.error('Error:', error);
    errorMessage.value = 'Error de conexión. Inténtalo nuevamente.';
  } finally {
    inscribing.value = false;
  }
};

// Desinscribirse de un taller
const desinscribirse = async (tallerId: number) => {
  if (!confirm('¿Estás segura de que quieres desinscribirte de este taller?')) {
    return;
  }

  desinscribiendo.value = true;
  successMessage.value = '';
  errorMessage.value = '';

  try {
    const response = await fetch(`/student/desinscribirse/${tallerId}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      }
    });

    const data = await response.json();

    if (response.ok) {
      successMessage.value = data.message || 'Te has desinscrito exitosamente.';
      // Recargar la página para actualizar los datos
      setTimeout(() => {
        window.location.reload();
      }, 1500);
    } else {
      errorMessage.value = data.message || 'Error al desinscribirse del taller.';
    }
  } catch (error) {
    console.error('Error:', error);
    errorMessage.value = 'Error de conexión. Inténtalo nuevamente.';
  } finally {
    desinscribiendo.value = false;
  }
};

// Limpiar mensajes después de 5 segundos
const cleanupMessages = () => {
  setTimeout(() => {
    successMessage.value = '';
    errorMessage.value = '';
  }, 5000);
};

// Ejecutar cleanup cuando cambien los mensajes
watch([successMessage, errorMessage], () => {
  if (successMessage.value || errorMessage.value) {
    cleanupMessages();
  }
});
</script>
