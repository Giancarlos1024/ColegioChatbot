<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center p-4">
    <div class="max-w-lg w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
      <!-- Logo -->
      <div class="text-center mb-8">
        <img src="/imagenes/admin.png" alt="INIF 48" class="w-20 h-20 mx-auto mb-4 rounded-full shadow-lg object-cover" />
        <h1 class="text-2xl font-bold text-blue-700 dark:text-cyan-400">
          INIF N° 48
        </h1>
        <p class="text-gray-600 dark:text-gray-300">Registro - Estudiante</p>
      </div>

      <!-- Formulario con Inertia -->
      <form @submit.prevent="submit" class="space-y-4">
        <!-- Nombre y Apellidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
              Nombre
            </label>
            <input
              v-model="form.name"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
              placeholder="María"
            />
            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
              Apellidos
            </label>
            <input
              v-model="form.apellidos"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
              placeholder="García López"
            />
            <p v-if="form.errors.apellidos" class="mt-1 text-sm text-red-600">{{ form.errors.apellidos }}</p>
          </div>
        </div>

        <!-- DNI -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            DNI
          </label>
          <input
            v-model="form.dni"
            type="text"
            required
            maxlength="8"
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
            placeholder="12345678"
          />
          <p v-if="form.errors.dni" class="mt-1 text-sm text-red-600">{{ form.errors.dni }}</p>
        </div>

        <!-- Fecha de Nacimiento -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Fecha de Nacimiento
          </label>
          <input
            v-model="form.nacimiento"
            type="date"
            required
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
          />
          <p v-if="form.errors.nacimiento" class="mt-1 text-sm text-red-600">{{ form.errors.nacimiento }}</p>
        </div>

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
          <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
        </div>

        <!-- Username -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Nombre de Usuario
          </label>
          <input
            v-model="form.username"
            type="text"
            required
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
            placeholder="maria.garcia"
          />
          <p v-if="form.errors.username" class="mt-1 text-sm text-red-600">{{ form.errors.username }}</p>
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
          <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
        </div>

        <!-- Confirm Password -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Confirmar Contraseña
          </label>
          <input
            v-model="form.password_confirmation"
            type="password"
            required
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
            placeholder="••••••••"
          />
          <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="form.processing"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="form.processing">Registrando...</span>
          <span v-else>Registrarse</span>
        </button>
      </form>

      <!-- Enlaces -->
      <div class="mt-6 text-center space-y-2">
        <p class="text-sm text-gray-600 dark:text-gray-400">
          ¿Ya tienes cuenta?
          <a href="/student/login" class="text-blue-600 hover:text-blue-700 font-medium">
            Inicia sesión aquí
          </a>
        </p>
        <a href="/" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400">
          ← Volver al inicio
        </a>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

// Formulario usando Inertia
const form = useForm({
  name: '',
  apellidos: '',
  dni: '',
  nacimiento: '',
  email: '',
  username: '',
  password: '',
  password_confirmation: '',
});

// Función para enviar el formulario
const submit = () => {
  form.post('/student/register');
};
</script>