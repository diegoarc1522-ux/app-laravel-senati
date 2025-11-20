<script setup lang="ts">
import { ref } from 'vue'; // Importamos ref para crear variables reactivas

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// Este componente no es estrictamente necesario para el contador, pero lo mantenemos si lo usas en otras partes:
import PlaceholderPattern from '../components/PlaceholderPattern.vue'; 

// 1. Lógica del Contador
// Definimos la variable reactiva inicializada en 0.
const count = ref(0);

// Función para incrementar el contador.
const increment = () => {
    // Para cambiar el valor de una ref, usamos .value
    count.value++; 
};

// Mantenemos tus breadcrumbs originales:
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col items-center justify-center space-y-6 p-8 bg-gray-50 dark:bg-gray-800 rounded-lg">
            
            <h2 class="text-xl font-medium text-gray-600 dark:text-gray-300">Valor Actual del Contador:</h2>

            <h1 class="text-amber-600 text-9xl font-extrabold tracking-tight">
                {{ count }}
            </h1>

            <button 
                @click="increment" 
                class="px-8 py-4 bg-green-600 text-white text-lg font-semibold rounded-xl shadow-lg hover:bg-green-700 active:bg-green-800 transition duration-150 transform hover:scale-105"
            >
                ➕ Incrementar Contador
            </button>
            
        </div>
        </AppLayout>
</template>