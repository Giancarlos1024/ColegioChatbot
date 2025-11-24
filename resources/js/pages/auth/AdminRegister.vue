<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    username: '',
    password: '',
    password_confirmation: '',
    dni: '',
    phone: '',
    birth_date: '',
    address: '',
    apellidos: '',
});

const submit = () => {
    form.post(route('admin.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <Head title="Registrar Administrador" />

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-red-600 mb-2">Registrar Nuevo Administrador</h1>
            <p class="text-sm text-gray-600">Solo administradores pueden acceder a esta función</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                    <input
                        id="name"
                        type="text"
                        required
                        v-model="form.name"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="Juan Pérez"
                    />
                    <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">
                        {{ form.errors.name }}
                    </div>
                </div>

                <!-- Apellidos -->
                <div>
                    <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                    <input
                        id="apellidos"
                        type="text"
                        required
                        v-model="form.apellidos"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="García López"
                    />
                    <div v-if="form.errors.apellidos" class="text-sm text-red-600 mt-1">
                        {{ form.errors.apellidos }}
                    </div>
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        required
                        v-model="form.email"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="juan@email.com"
                    />
                    <div v-if="form.errors.email" class="text-sm text-red-600 mt-1">
                        {{ form.errors.email }}
                    </div>
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario</label>
                    <input
                        id="username"
                        type="text"
                        required
                        v-model="form.username"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="jperez"
                    />
                    <div v-if="form.errors.username" class="text-sm text-red-600 mt-1">
                        {{ form.errors.username }}
                    </div>
                </div>

                <!-- DNI -->
                <div>
                    <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                    <input
                        id="dni"
                        type="text"
                        required
                        maxlength="8"
                        v-model="form.dni"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="12345678"
                    />
                    <div v-if="form.errors.dni" class="text-sm text-red-600 mt-1">
                        {{ form.errors.dni }}
                    </div>
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input
                        id="phone"
                        type="text"
                        required
                        v-model="form.phone"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="987654321"
                    />
                    <div v-if="form.errors.phone" class="text-sm text-red-600 mt-1">
                        {{ form.errors.phone }}
                    </div>
                </div>

                <!-- Fecha de nacimiento -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                    <input
                        id="birth_date"
                        type="date"
                        required
                        v-model="form.birth_date"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                    />
                    <div v-if="form.errors.birth_date" class="text-sm text-red-600 mt-1">
                        {{ form.errors.birth_date }}
                    </div>
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input
                        id="password"
                        type="password"
                        required
                        v-model="form.password"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="Mínimo 8 caracteres"
                    />
                    <div v-if="form.errors.password" class="text-sm text-red-600 mt-1">
                        {{ form.errors.password }}
                    </div>
                </div>

                <!-- Confirmar contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        required
                        v-model="form.password_confirmation"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="Repita la contraseña"
                    />
                    <div v-if="form.errors.password_confirmation" class="text-sm text-red-600 mt-1">
                        {{ form.errors.password_confirmation }}
                    </div>
                </div>

                <!-- Dirección -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <textarea
                        id="address"
                        required
                        rows="3"
                        v-model="form.address"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="Av. Principal 123, Lima, Perú"
                    ></textarea>
                    <div v-if="form.errors.address" class="text-sm text-red-600 mt-1">
                        {{ form.errors.address }}
                    </div>
                </div>
            </div>

            <!-- Botón de envío -->
            <button
                type="submit"
                class="w-full bg-red-600 text-white py-3 px-4 rounded-md hover:bg-red-700 disabled:opacity-50"
                :disabled="form.processing"
            >
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin inline mr-2" />
                Crear Administrador
            </button>

            <!-- Enlaces -->
            <div class="text-center text-sm text-gray-600">
                <a :href="route('dashboard')" class="text-blue-600 hover:underline">← Volver al Dashboard</a>
            </div>
        </form>
    </div>
</template>
