<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { BookX, Pencil, Save, SquarePlus, Trash2 } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';
//import { SourceTextModule } from 'vm';

const categorias = ref([]);
const miNombre = ref('');
const mostrarModal = ref(false);
const mostrarModalEditar = ref(false);

//Formulario
const formulario = ref({
    nombre_categoria: '',
    descripcion: '',
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categoria',
        href: dashboard().url,
    },
];

const listarCategoria = async () => {
    try {
        const respuesta = await axios.get('/categorias-data');
        console.log(respuesta);
        if (respuesta.data.success) {
            categorias.value = respuesta.data.data;
            miNombre.value = respuesta.data.nombre;
        }
    } catch (error: any) {}
};

//Funciones para manipular el modal Registrar
const abrirModal = () => {
    mostrarModal.value = true;
};
const cerrarModal = () => {
    mostrarModal.value = false;
};

//Funciones para manipular el modal editar
const abrirModalEditar = ( dataCategoria : any ) => {
    mostrarModalEditar.value = true;

    console.log(dataCategoria);

    formulario.value.nombre_categoria = dataCategoria.nombre_categoria,
    formulario.value.descripcion = dataCategoria.descripcion
    
};
const cerrarModalEditar = () => {
    mostrarModalEditar.value = false;
};

const enviarFormulario = async () => {
    console.log('Diego Sanchez');
    console.log(formulario.value);

    const respuesta = await axios.post('/categorias-data', formulario.value);
    if (respuesta.data.success) {
        Swal.fire({
            title: 'Recurso Creado',
            text: 'Categoria Creada',
            icon: 'success',
        });
        mostrarModal.value = false;
        listarCategoria();
    } else {
        Swal.fire({
            title: 'Error',
            text: 'No se pudo crear la categoria.',
            icon: 'error',
        });
    }

    console.log(respuesta);
};

const actualizarFormulario = async () => {
    console.log('Diego Sanchez');
    console.log(formulario.value);

    const respuesta = await axios.put('/categorias-data', formulario.value);
    if (respuesta.data.success) {
        Swal.fire({
            title: 'Recurso Actualizado',
            text: 'Categoria Actualizada',
            icon: 'success',
        });
        mostrarModal.value = false;
        listarCategoria();
    } else {
        Swal.fire({
            title: 'Error',
            text: 'No se pudo actualizar la categoria.',
            icon: 'error',
        });
    }

    console.log(respuesta);
};

const eliminarCategoria = async (id: number) => {
    Swal.fire({
        title: '¿Estas seguro?',
        text: 'Esta acción no se puede revertir',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'Cancelar',
    }).then(async (resultado) => {
        if (resultado.isConfirmed) {
            try {
                const respuesta = await axios.delete(`/categorias-data/${id}`);

                Swal.fire({
                    title: 'Eliminado!',
                    text: 'La categoria fue eliminada correctamente.',
                    icon: 'success',
                });

                listarCategoria();
            } catch (error) {
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo eliminar la categoria.',
                    icon: 'error',
                });
            }
        }
    });
};

//     const confirmacion = (id: number) =>{
//         Swal.fire({
//         title: "Are you sure?",
//         text: "You won't be able to revert this!",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, delete it!"
//         }).then((result) => {
//         if (result.isConfirmed) {
//             eliminarCategoria(id);
//         }
//         });
//     }

//     const eliminarCategoria = async (id : number) =>{
//       const respuesta = await axios.delete(`/categorias-data/${id}`);
//       console.log(respuesta);
//      if(respuesta.data.success){
//          Swal.fire({
//                      title: "Error",
//                      text: "No se pudo eliminar la categoria.",
//                      icon: "error"
//                  });
//      }
//       listarCategoria();
// }

onMounted(listarCategoria);
</script>

<template>
    <Head title="Categoria 🎶🎶" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col items-center justify-center">
            <div class="mt-4">
                <p class="text-2xl text-amber-600">Gestión Categoria🎶</p>
                <small
                    class="flex flex-col items-center justify-center text-blue-500"
                    >{{ miNombre }}</small
                >
            </div>
            <div>
                <!-- <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr class="*:font-medium *:text-gray-900 dark:*:text-amber-600">
                                <th class="px-3 py-2 whitespace-nowrap">Nombre</th>
                                <th class="px-3 py-2 whitespace-nowrap">Descripcion</th>
                                <th class="px-3 py-2 whitespace-nowrap">Estado</th>
                                <th class="px-3 py-2 whitespace-nowrap">Opciones</th>
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-gray-200 *:even:bg-gray-50 dark:divide-gray-700 dark:*:even:bg-gray-800">
                            <tr v-for="item in categorias" :key="item.id"
                                class="*:text-gray-900 *:first:font-medium dark:*:text-white">
                                <td class="px-3 py-2 whitespace-nowrap">{{ item.nombre_categoria }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ item.descripcion }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ item.estado }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">

                                    <div class="flex flex-row gap-4">
                                        <a class="inline-block rounded-sm border border-current px-8 py-3 text-sm font-medium text-indigo-600 transition hover:scale-110 hover:rotate-2"
                                            href="#" @click="">
                                             Editar
                                            <Pencil />
                                        </a>
                                        <a class="inline-block rounded-sm border border-current px-8 py-3 text-sm font-medium text-rose-400 transition hover:scale-110 hover:rotate-2"
                                            href="#" @click="eliminarCategoria(item.id)">
                                             Eliminar 
                                            <Trash2 /> 
                                        </a>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->

                <!-- Modal Registro Categoria  -->
                <div
                    class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="modalTitle"
                    v-if="mostrarModal"
                >
                    <div
                        class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900"
                    >
                        <h2
                            id="modalTitle"
                            class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white"
                        >
                            Registro Categoria 🎶
                        </h2>

                        <form class="mt-4" @submit.prevent="enviarFormulario">
                            <div class="mb-3">
                                <label for="nombre_categoria">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Nombre
                                    </span>
                                    <input
                                        type="text"
                                        id="nombre_categoria"
                                        v-model="formulario.nombre_categoria"
                                        class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                    />
                                </label>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Descripcion
                                    </span>
                                    <textarea
                                        id="descripcion"
                                        v-model="formulario.descripcion"
                                        class="mt-0.5 w-full resize-none rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                        rows="4"
                                    ></textarea>
                                </label>
                                <label for="descripcion">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Descripcion
                                    </span>
                                    <input
                                        type="text"
                                        id="descripcion"
                                        v-model="formulario.descripcion"
                                        class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                    />
                                </label>
                            </div>

                            <footer class="mt-6 flex justify-end gap-2">
                                <button
                                    type="button"
                                    class="flex items-center justify-center gap-2 rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                                    @click="cerrarModal"
                                >
                                    <BookX /> Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="flex items-center justify-center gap-2 rounded bg-blue-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                                >
                                    <Save /> Guardar
                                </button>
                            </footer>
                        </form>
                    </div>
                </div>

                <!-- Modal Editar Categoria  -->
                <div
                    class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="modalTitle"
                    v-if="mostrarModalEditar"
                >
                    <div
                        class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900"
                    >
                        <h2
                            id="modalTitle"
                            class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white"
                        >
                            Editar Categoria 🎶
                        </h2>

                        <form class="mt-4" @submit.prevent="enviarFormulario">
                            <div class="mb-3">
                                <label for="nombre_categoria">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Nombre
                                    </span>
                                    <input
                                        type="text"
                                        id="nombre_categoria"
                                        v-model="formulario.nombre_categoria"
                                        class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                    />
                                </label>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Descripcion
                                    </span>
                                    <textarea
                                        id="descripcion"
                                        v-model="formulario.descripcion"
                                        class="mt-0.5 w-full resize-none rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                        rows="4"
                                    ></textarea>
                                </label>
                               <!-- <label for="descripcion">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Descripcion
                                     </span>
                                    <input
                                        type="text"
                                        id="descripcion"
                                        v-model="formulario.descripcion"
                                        class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                    />
                                </label> -->
                            </div>

                            <footer class="mt-6 flex justify-end gap-2">
                                <button
                                    type="button"
                                    class="flex items-center justify-center gap-2 rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                                    @click="cerrarModalEditar"
                                >
                                    <BookX /> Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="flex items-center justify-center gap-2 rounded bg-blue-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                                >
                                    <Save /> Guardar
                                </button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-2 md:mx-10 lg:mx-20">
            <div>
                <a
                    class="group relative inline-flex items-center overflow-hidden rounded-sm border border-current px-8 py-3 text-indigo-600 dark:text-emerald-600"
                    href="#"
                    @click="abrirModal"
                >
                    <span
                        class="absolute -start-full transition-all group-hover:start-4"
                    >
                        <!-- <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg> -->
                        <SquarePlus />
                    </span>

                    <span
                        class="text-sm font-medium transition-all group-hover:ms-4"
                        >Crear</span
                    >
                </a>
            </div>

            <div
                class="bg-neutral-primary-soft rounded-base border-default relative overflow-x-auto border shadow-xs"
            >
                <table
                    class="text-body w-full text-left text-sm rtl:text-right"
                >
                    <thead
                        class="text-body bg-neutral-secondary-soft rounded-base border-default border-b text-sm"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Descripcion
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in categorias"
                            :key="item.id"
                            class="bg-neutral-primary border-default border-b"
                        >
                            <th
                                scope="row"
                                class="text-heading px-6 py-4 font-medium whitespace-nowrap"
                            >
                                {{ item.nombre_categoria }}
                            </th>
                            <td class="px-6 py-4">
                                {{ item.descripcion }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.estado }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-row gap-4">
                                    <a
                                        class="inline-block rounded-sm border border-current px-8 py-3 text-sm font-medium text-indigo-600 transition hover:scale-110 hover:rotate-2"
                                        href="#"
                                        @click="abrirModalEditar(item)"
                                    >
                                        <!-- Editar -->
                                        <Pencil />
                                    </a>
                                    <a
                                        class="inline-block rounded-sm border border-current px-8 py-3 text-sm font-medium text-rose-400 transition hover:scale-110 hover:rotate-2"
                                        href="#"
                                        @click="eliminarCategoria(item.id)"
                                    >
                                        <!-- Eliminar -->
                                        <Trash2 />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900"
            >
                <h2
                    id="modalTitle"
                    class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white"
                >
                    Registro Categoria 🎶
                </h2>

                <form class="mt-4" @submit.prevent="enviarFormulario">
                    <div class="mb-3">
                        <label for="nombre_categoria">
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-200"
                            >
                                Nombre
                            </span>
                            <input
                                type="text"
                                id="nombre_categoria"
                                v-model="formulario.nombre_categoria"
                                class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                            />
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion">
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-200"
                            >
                                Descripcion
                            </span>
                            <textarea
                                id="descripcion"
                                v-model="formulario.descripcion"
                                class="mt-0.5 w-full resize-none rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                rows="4"
                            ></textarea>
                        </label>
                        <!-- <label for="descripcion">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200"> Descripcion </span>
                                    <input type="text" id="descripcion" v-model="formulario.descripcion" class="p-2 mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                                </label> -->
                    </div>

                    <footer class="mt-6 flex justify-end gap-2">
                        <button
                            type="button"
                            class="flex items-center justify-center gap-2 rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                            @click="cerrarModal"
                        >
                            <BookX /> Cancel
                        </button>

                        <button
                            type="submit"
                            class="flex items-center justify-center gap-2 rounded bg-blue-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                        >
                            <Save /> Guardar
                        </button>
                    </footer>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
