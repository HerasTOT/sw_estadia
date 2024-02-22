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
        pregunta:{ type: Object, required: true },
        habito: { type: Object, required: true },
        
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
            matricula: '',
            grado: '',
            grupo: '',
            tutor:'',
            periodo:'',
            formato:'',
            pregunta:'',
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
                    form.delete(route("habito.destroy", id));
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

        <CardBox v-if="habito">
            <div>
                <div>
                    <strong>Matrícula:</strong> {{ habito.matricula }}
                </div>
                <div>
                    <strong>Grado:</strong> {{ habito.grado }}
                </div>
                <div>
                    <strong>Grupo:</strong> {{ habito.grupo }}
                </div>
                <div>
                    <strong>Tutor:</strong> {{ habito.tutor }}
                </div>
                <div>
                    <strong>Tutor:</strong> {{ habito.periodo }}
                </div>
                
            </div>

        </CardBox>
        <div class="bg-slate-50 w-1/2 p-14">
            <div class="flex flex-col">
                <div class="px-5 py-3 w-3/4">
                    <h2 class="text-2xl font-bold mb-4">Preguntas</h2>
                    <ul class="list-disc pl-5 text-lg">
                        <!-- Aplicar un filtro para mostrar solo las preguntas con formato igual a 2 -->
                        <li v-for="unaPregunta in pregunta.filter(item => item.formato === 2)" :key="unaPregunta.id" class="mb-2">
                            {{ unaPregunta.pregunta }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </LayoutMain>
</template>
