<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
      <!-- Logo -->
      <div class="text-center mb-8">
        <img src="/imagenes/admin.png" alt="INIF 48" class="w-20 h-20 mx-auto mb-4 rounded-full shadow-lg object-cover" />
        <h1 class="text-2xl font-bold text-blue-700 dark:text-cyan-400">
          INIF N° 48
        </h1>
        <p class="text-gray-600 dark:text-gray-300">Iniciar Sesión - Estudiante</p>
      </div>

      <!-- Formulario -->
      <form @submit.prevent="handleLogin">
        <div class="space-y-4">
          <!-- Email -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
              Correo Electrónico
            </label>
            <input
              v-model="form.email"
              type="email"
              required
              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
              placeholder="tu@email.com"
            />
            <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
          </div>

          <!-- Password -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
              Contraseña
            </label>
            <input
              v-model="form.password"
              type="password"
              required
              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
              placeholder="••••••••"
            />
            <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="loading">Iniciando sesión...</span>
            <span v-else>Iniciar Sesión</span>
          </button>
        </div>
      </form>

      <!-- Enlaces -->
      <div class="mt-6 text-center space-y-2">
        <p class="text-sm text-gray-600 dark:text-gray-400">
          ¿No tienes cuenta?
          <a href="/student/register" class="text-blue-600 hover:text-blue-700 font-medium">
            Regístrate aquí
          </a>
        </p>
        <a href="/" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400">
          ← Volver al inicio
        </a>
      </div>

      <!-- Mensaje de éxito -->
      <div v-if="successMessage" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-sm text-green-600">{{ successMessage }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

// Estado del formulario
const form = ref({
  email: '',
  password: ''
});

const errors = ref<Record<string, string>>({});
const loading = ref(false);
const successMessage = ref('');

const handleLogin = async () => {
  loading.value = true;
  errors.value = {};
  successMessage.value = '';

  try {
    const response = await fetch('/student/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify(form.value)
    });

    const data = await response.json();

    if (response.ok) {
      successMessage.value = '¡Inicio de sesión exitoso! Redirigiendo...';
      setTimeout(() => {
        window.location.href = '/student/dashboard';
      }, 1500);
    } else {
      if (data.errors) {
        errors.value = data.errors;
      } else if (data.message) {
        errors.value = { general: data.message };
      } else {
        errors.value = { general: 'Error al iniciar sesión. Verifica tus credenciales.' };
      }
    }
  } catch (error) {
    console.error('Error:', error);
    errors.value = { general: 'Error de conexión. Inténtalo nuevamente.' };
  } finally {
    loading.value = false;
  }
};
</script>
