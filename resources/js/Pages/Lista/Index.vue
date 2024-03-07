<script>
import { Link, useForm } from '@inertiajs/vue3';
import Swal from "sweetalert2";
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import {
    mdiMonitorCellphone,
    mdiTableBorder,
    mdiTableOff,
    mdiGithub,
    mdiApplicationEdit, mdiTrashCan
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";



export default {
    props: {
        titulo: { type: String, required: true },
        recursamiento: { type: Object, required: true },
      
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true }
    },
    components: {
        Link,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        NotificationBar
    },
    setup() {
        const form = useForm({
            pregunta: '',
            formato: '',
        });
        const eliminar = (id) => {
            Swal.fire({
                title: "¿Esta seguro?",
                text: "Esta acción no se puede revertir",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, eliminar registro!",
            }).then((res) => {
                if (res.isConfirmed) {
                    form.delete(route("pregunta.destroy", id));
                }
            });
        };

        return {
            form, eliminar, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan,
        }
    }

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiTableBorder" :title="titulo" main>
            <a :href="route(`${routeName}create`)"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path
                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
            </a>
        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="recursamientos < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-3">
                <div v-for="item in recursamiento" :key="item.id"
                    class="max-w-full bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ item.materia }}

                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            Periodo: {{ item.periodo }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            Profesor: {{ item.profesor }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            Horarios: {{ item.horarios }}
                        </p>
                    </div>
                    <div class="flex justify-end items-end p-4">
                        <a class="text-sm text-gray-500 dark:text-gray-300" >
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>

                                <a :href="route('lista.assign-lista.view', item.id)"> <button
                                        class="bg-transparent dark:text-white dark:border-white hover:bgeve-blue-500 dark:hover:text-yellow-700 text-yellow-700 font-semibold hover:text-black py-2 px-4 border border-yellow-500  dark:hover:border-transparent hover:border-transparent rounded">
                                        Agregarse a la lista
                                    </button>
                                </a>
                            </BaseButtons>
                        </a>

                    </div>
                </div>
            </div>
        </CardBox>
    </LayoutMain>
</template>
