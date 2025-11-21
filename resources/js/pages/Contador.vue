
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { ref } from 'vue';

const contador = ref(0);

const breadcrumbs: BreadcrumbItem[] = [ 
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

function incrementar(){
    contador.value++;
}

function decrementar(){
    contador.value--;
}

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col items-center justify-center">
            <p class="text-amber-600 text-9xl">Contador</p>

            <div class="flex flex-col items-center justify-center">            
                <small>DIEGO SANCHEZ</small>
            </div>

        </div>
        <div class="flex flex-wrap gap-4 items-center justify-center">
            <p class="text-6xl font-bold">{{ contador }}</p>
        </div>
        <div class="flex flex-wrap gap-4 items-center justify-center">
            <button class="bg-green-600 text-white px-6 py-4 rounded-2xl" @click="incrementar" type="button">➕</button>
            <button class="bg-green-600 text-white px-6 py-4 rounded-2xl" @click="decrementar" type="button">➖</button>
        </div>
    </AppLayout>
</template>






