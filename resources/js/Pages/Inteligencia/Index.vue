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
        preguntas:{ type: Object, required: true },
        inteligencia: { type: Object, required: true },
        inteligenciaId:{ type: String, required: true },
        respuestas: { type: Object, required: true },
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
                    form.delete(route("inteligencia.destroy", id));
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
            <BaseButton :href="'inteligencia/create' " color="warning" label="Generar formato" />
            <BaseButton :href="`inteligencia/${inteligenciaId}/edit`" color="warning" label="Modificar formato" />

        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="inteligencia">
            <div>
                <div>
                    <strong>Matrícula:</strong> {{ inteligencia.matricula }}
                </div>
                <div>
                    <strong>Grado:</strong> {{ inteligencia.grado }}
                </div>
                <div>
                    <strong>Grupo:</strong> {{ inteligencia.grupo }}
                </div>
                <div>
                    <strong>Tutor:</strong> {{ inteligencia.tutor }}
                </div>
                <div>
                    <strong>Tutor:</strong> {{ inteligencia.periodo }}
                </div>
                <div v-for="pregunta in preguntas" :key="pregunta.id">
                    <strong>{{ pregunta.pregunta }}</strong>
                    <ul>
                        <li v-for="respuesta in respuestas.filter(item => item.pregunta.id === pregunta.id )" :key="respuesta.id">
                            {{ respuesta.respuesta }}
                        </li>
                    </ul>
                    
                </div>
            </div>

        </CardBox>

    </LayoutMain>
</template>
