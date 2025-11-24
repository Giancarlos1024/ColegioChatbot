<script lang="ts" setup>
import { computed, watchEffect } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AppMenuItem from './AppMenuItem.vue';

// Tipos para usuario y permisos/roles
interface User {
    permissions?: string[];
    roles?: string[];
}

interface Auth {
    user?: User | null;
}

interface PageProps {
    auth?: Auth | null;
}

// Obtenemos los props de la página
const page = usePage<PageProps>();

// 🔍 LOG PRINCIPAL: ver qué llega desde Laravel/Inertia
console.log('👉 AppMenu · page.props.auth:', page.props.auth);

// Computed para permisos y roles del usuario
const permissions = computed<string[]>(() => page.props.auth?.user?.permissions ?? []);
const roles = computed<string[]>(() => page.props.auth?.user?.roles ?? []);

// 🔍 LOG cada vez que cambien roles/permisos
watchEffect(() => {
    console.log('👉 AppMenu · roles:', roles.value);
    console.log('👉 AppMenu · permissions:', permissions.value);
});

// Función para verificar permisos
const hasPermission = (perm: string): boolean => {
    // Si el usuario tiene el rol administrador, ve todo
    if (roles.value.includes('administrador')) {
        console.log('✅ Es administrador, acceso permitido a:', perm);
        return true;
    }

    const can = permissions.value.includes(perm);
    console.log(`🔎 Checando permiso "${perm}" ->`, can);
    return can;
};

// Tipos del menú
interface MenuItem {
    label: string;
    icon?: string;
    to?: string;
    items?: MenuItem[];
}

// Modelo del menú
const model = computed<MenuItem[]>(() => [
    {
        label: 'Home',
        items: [
            { label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/dashboard' }
        ]
    },
    {
        label: 'Gestion de Trabajo',
        items: [
            hasPermission('ver talleres') && { label: 'Gestion de talleres', icon: 'pi pi-fw pi-briefcase', to: '/talleres' },
            hasPermission('ver horarios') && { label: 'Horarios', icon: 'pi pi-fw pi-clock', to: '/horarios' },
        ].filter(Boolean) as MenuItem[],
    },
    {
        label: 'Usuarios y Seguridad',
        items: [
            hasPermission('ver usuarios') && { label: 'Gestión de Usuarios', icon: 'pi pi-fw pi-user-edit', to: '/usuario' },
            hasPermission('ver roles') && { label: 'Roles', icon: 'pi pi-fw pi-shield', to: '/roles' },
        ].filter(Boolean) as MenuItem[],
    },
    {
        label: 'Gestion de Alertas',
        items: [
            hasPermission('ver alertas') && { label: 'Alertas', icon: 'pi pi-fw pi-bell', to: '/alertas' },
            hasPermission('ver configuraciones de alerta') && { label: 'Configuración de alertas', icon: 'pi pi-fw pi-cog', to: '/config_alertas' },
        ].filter(Boolean) as MenuItem[],
    },
    {
        label: 'Asistente',
        items: [
            { label: 'Asistente IA', icon: 'pi pi-fw pi-home', to: '/asistente' }
        ]
    },
].filter(section => section.items && section.items.length > 0) as MenuItem[]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="i">
            <app-menu-item :item="item" :index="i" />
        </template>
    </ul>
</template>
