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
        Recursamiento: { type: Object, required: true },
        materia: { type: Object, required: true },
        
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
            materia: '',
            periodo: '',
            profesor: '',
            horarios:'',
            cupo:'',
           
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
                    form.delete(route("recursamiento.destroy", id));
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
            <BaseButton :href="'recursamiento/create'" color="warning" label="Agregar recursamiento" />
        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="Recursamiento.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>
                    <tr>
                        <th />
                        <th>Materia</th>
                        <th>Periodo</th>
                        <th>Profesor</th>
                        <th>Horarios</th>
                        <th>Cupo maximo de estuidiantes</th>
                        <th></th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="recursa in Recursamiento.data" :key="recursa.id">
                        <td class="align-items-center">
                           
                        </td>
                        <td >
                            {{ recursa.materia_nombre }}
                        </td>
                        <td >
                            {{ recursa.periodo_periodo }} {{ recursa.periodo_año }}
                        </td>
                        <td>
                            {{ recursa.profesor_name }}
                        </td>
                        <td data-label="tipo">
                            {{ recursa.horarios }}
                        </td>
                        <td data-label="tipo">
                            {{ recursa.cupo }}
                        </td>
                       

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiApplicationEdit" small
                                    :href="route(`${routeName}edit`, recursa.id)" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(recursa.id)" />
                            </BaseButtons>
                        </td>

                    </tr>
                </tbody>
            </table>



            <Pagination :currentPage="Recursamiento.current_page" :links="Recursamiento.links"
                :total="Recursamiento.links.length - 2"></Pagination>
        </CardBox>

    </LayoutMain>
</template>
