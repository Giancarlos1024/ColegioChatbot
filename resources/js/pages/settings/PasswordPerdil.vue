<script setup lang="ts">
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

// PrimeVue components
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import Message from 'primevue/message'
import Card from 'primevue/card'

// Estado de edición
const isEditing = ref(false)

// Formulario de contraseña
const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

// Referencias a los inputs
const currentPasswordInput = ref<HTMLInputElement | null>(null)
const passwordInput = ref<HTMLInputElement | null>(null)

// Inicializar campos al entrar en modo edición
const startEditing = () => {
    form.reset()
    isEditing.value = true
    
    // Enfocar primer campo
    setTimeout(() => {
        currentPasswordInput.value?.focus()
    }, 100)
}

// Cancelar edición
const cancelEditing = () => {
    form.reset()
    isEditing.value = false
}

// Actualizar contraseña
const updatePassword = () => {
    form.put(route('password.updateProfile'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            isEditing.value = false
        },
        onError: (errors: any) => {
            if (errors.password) {
                form.reset('password', 'password_confirmation')
                passwordInput.value?.focus()
            }

            if (errors.current_password) {
                form.reset('current_password')
                currentPasswordInput.value?.focus()
            }
        },
    })
}
</script>

<template>
  <div class="space-y-6">
    <Card>
      <template #title>
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <div>
              <h2 class="text-xl font-bold">Seguridad de Cuenta</h2>
              <p class="text-sm text-gray-600">Gestiona tu contraseña</p>
            </div>
          </div>
          
          <!-- Botones de acción -->
          <div v-if="!isEditing" class="flex gap-2">
            <Button 
              label="Editar Contraseña" 
              icon="pi pi-pencil"
              @click="startEditing"
              severity="primary"
            />
          </div>
          <div v-else class="flex gap-2">
            <Button 
              label="Cancelar" 
              icon="pi pi-times"
              @click="cancelEditing"
              severity="secondary"
              outlined
            />
            <Button 
              label="Actualizar" 
              icon="pi pi-check"
              @click="updatePassword"
              :loading="form.processing"
              severity="success"
            />
          </div>
        </div>
      </template>
      
      <template #content>
        <form @submit.prevent="updatePassword" class="space-y-6">
          <!-- Estado de seguridad actual -->
          <div v-if="!isEditing" class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <div>
                <h3 class="font-medium text-green-800">Contraseña Configurada</h3>
                <p class="text-sm text-green-700">Tu cuenta está protegida con una contraseña segura</p>
              </div>
            </div>
            <div class="mt-3 pt-3 border-t border-green-200">
              <p class="text-sm text-green-700">
                <strong>Recomendaciones de seguridad:</strong>
              </p>
              <ul class="text-sm text-green-600 mt-2 space-y-1">
                <li>• Usa al menos 8 caracteres</li>
                <li>• Combina letras, números y símbolos</li>
                <li>• No uses información personal</li>
              </ul>
            </div>
          </div>

          <!-- Formulario de edición -->
          <div v-if="isEditing" class="space-y-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <h3 class="font-medium text-yellow-800">Actualizar Contraseña</h3>
              </div>
              <p class="text-sm text-yellow-700 mt-1">
                Ingresa tu contraseña actual y define una nueva contraseña segura
              </p>
            </div>

            <!-- Contraseña actual -->
            <div class="field">
              <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                Contraseña Actual *
              </label>
              <InputText
                id="current_password"
                ref="currentPasswordInput"
                v-model="form.current_password"
                type="password"
                autocomplete="current-password"
                placeholder="Ingresa tu contraseña actual"
                class="w-full"
                required
              />
              <Message v-if="form.errors.current_password" severity="error" class="mt-1">
                {{ form.errors.current_password }}
              </Message>
            </div>

            <!-- Nueva contraseña -->
            <div class="field">
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                Nueva Contraseña *
              </label>
              <InputText
                id="password"
                ref="passwordInput"
                v-model="form.password"
                type="password"
                autocomplete="new-password"
                placeholder="Ingresa una nueva contraseña"
                class="w-full"
                required
              />
              <Message v-if="form.errors.password" severity="error" class="mt-1">
                {{ form.errors.password }}
              </Message>
            </div>

            <!-- Confirmar contraseña -->
            <div class="field">
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Confirmar Nueva Contraseña *
              </label>
              <InputText
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                autocomplete="new-password"
                placeholder="Repite la nueva contraseña"
                class="w-full"
                required
              />
              <Message v-if="form.errors.password_confirmation" severity="error" class="mt-1">
                {{ form.errors.password_confirmation }}
              </Message>
            </div>

            <!-- Validación de coincidencia -->
            <div v-if="form.password && form.password_confirmation" class="p-3 rounded-md">
              <div v-if="form.password === form.password_confirmation" class="text-green-700 bg-green-50 border border-green-200 rounded-md p-2 text-sm">
                ✓ Las contraseñas coinciden
              </div>
              <div v-else class="text-red-700 bg-red-50 border border-red-200 rounded-md p-2 text-sm">
                ⚠ Las contraseñas no coinciden
              </div>
            </div>
          </div>

          <!-- Mensaje de éxito -->
          <Transition
            enter-active-class="transition-opacity duration-300"
            enter-from-class="opacity-0"
            leave-active-class="transition-opacity duration-300"
            leave-to-class="opacity-0"
          >
            <div v-if="form.recentlySuccessful" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md">
              <p class="text-green-800 font-medium">
                ✓ Contraseña actualizada exitosamente
              </p>
            </div>
          </Transition>
        </form>
      </template>
    </Card>
  </div>
</template>

<style scoped>
.field {
  margin-bottom: 1rem;
}
</style>
