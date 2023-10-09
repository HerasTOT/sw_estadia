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
    mdiEye, mdiTrashCan,
    mdiInformation, mdiArchiveArrowDown, mdiApplicationEdit
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import { useRole } from '@/Hooks/usePermissions';
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import axios from 'axios';



export default {
    props: {
        titulo: { type: String, required: true },
        records: {
            type: Object,
            required: true
        },
        events: {
            type: Object,
            required: true
        },
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
    methods: {
        getPdf(filename, announcement) {
            axios({
                url: '/download-AdPdf/' + (filename + '.pdf') + '/' + announcement,
                method: 'GET',
                responseType: 'blob', // This is important
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                console.log(url)
                link.href = url;
                link.setAttribute('download', filename + '.pdf');
                document.body.appendChild(link);
                link.click();
            });
        },
        viewPdf(filename, announcement) {
            axios({
                url: '/view-AdPdf/' + (filename + '.pdf') + '/' + announcement,
                method: 'GET',
                responseType: 'blob',
            }).then(response => {
                const blob = new Blob([response.data], { type: 'application/pdf' });
                this.documentUrl = URL.createObjectURL(blob);
                this.pdfTitle = filename
            });
        },
        getDate(date_start, date_end) {
            const current = new Date();
            const date = `${current.getFullYear()}-0${current.getMonth() + 1}-30`;

            if (date >= date_start && date <= date_end) {
                return true
            }
            else {
                return false
            }
        }
    },

    setup() {
        const form = useForm({
            name: '',
            status: ''
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
                    form.delete(route("announcements.destroy", id));
                }
            });
        };

        return {
            form, eliminar, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiEye, mdiTrashCan,
            useRole,
            mdiInformation, mdiArchiveArrowDown,
            mdiApplicationEdit
        }
    },
}
</script>

<template>
    <LayoutMain>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>


        <div v-for="calendar in events" :key="calendar.id">
            <SectionTitleLineWithButton :icon="mdiTableBorder" :title="calendar.name" main>
                <a v-if="useRole('Admin') && calendar.id == 1" :href="route(`${routeName}create`)"> <svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                        <path
                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                </a>
            </SectionTitleLineWithButton>


            <div v-if="records">
                <CardBox v-for="item in records" :key="item.id" class="mb-6" has-table>
                    <table
                        v-if="getDate(item.calendars[calendar.id - 1].date_start, item.calendars[calendar.id - 1].date_end)">
                        <thead>
                            <tr>
                                <th />
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-book-half" viewBox="0 0 16 16">
                                        <path
                                            d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                    </svg>
                                </td>
                                <td data-label="Nombre">
                                    {{ item.name }}
                                </td>
                                <td data-label="Descripcion">
                                    {{ item.description }}
                                </td>

                                <td class="before:hidden lg:w-1 whitespace-nowrap">
                                    <BaseButtons v-if="useRole('Admin')" type="justify-start lg:justify-end" no-wrap>
                                        <BaseButton color="info" :icon="mdiApplicationEdit" small
                                            :href="route(`${routeName}edit`, item.id)" />
                                        <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(item.id)" />
                                    </BaseButtons>
                                    <BaseButtons v-else-if="calendar.id == 2" type="justify-start lg:justify-end" no-wrap>
                                        <BaseButton color="info" :icon="mdiApplicationEdit" small
                                            :href="route('proposals.show', item.id)" />
                                        <BaseButton color="success" :icon="mdiArchiveArrowDown" small
                                            @click="getPdf('advertising', item.name)" />
                                    </BaseButtons>
                                  <!--   <BaseButtons v-else type="justify-start lg:justify-end" no-wrap>
                                        <BaseButtons type="justify-start lg:justify-center" no-wrap>
                                            -
                                        </BaseButtons>
                                    </BaseButtons> -->
                                </td>


                            </tr>
                        </tbody>
                    </table>

                    <CardBox v-else>
                        <CardBoxComponentEmpty />
                    </CardBox>
                </CardBox>
            </div>

            <CardBox v-else>
                <CardBoxComponentEmpty />
            </CardBox>
        </div>




    </LayoutMain>
</template>
