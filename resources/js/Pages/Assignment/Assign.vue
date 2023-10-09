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
    mdiEye, mdiTrashCan
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import { useNFmt } from '@/Hooks/useFormato.js';
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import { ref } from 'vue';
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import axios from 'axios';


export default {
    props: {
        titulo: { type: String, required: true },
        records: {
            type: Object,
            required: true
        },
        proposal: {
            type: Object,
            required: true
        },
        routeName: { type: String, required: true },
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
        NotificationBar,
        TableCheckboxCell
    },
    setup(props) {
        const form = useForm({
            reviewrs: [],
            proposal: props.proposal.id
        });

        const guardar = () => {
            if (reviewrs.value.length != 0) {
                for(let i = 0; i < reviewrs.value.length; i++){
                    form.reviewrs.push(reviewrs.value[i].id) 
                }
                console.log(form.reviewrs)
                form.post(route('proposals.sync'))
            }
            else {
                Swal.fire({
                    title: "Debe seleccionar un evaluador!",
                    text: "Si no selecciona un evaluador la propuestas no podra ser revisada",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok!",
                })
            }
        };

        const reviewrs = ref([]);

        const remove = (arr, cb) => arr.filter(item => !cb(item));

        const isClientName = row => client => row.name === client.name;

        const checked = (isChecked, client) => {
            let checkedArray = reviewrs.value;
            const isNameChecked = isClientName(client);

            if (isChecked) {
                checkedArray.push(client);
            } else {
                checkedArray = remove(checkedArray, isNameChecked);
            }

            reviewrs.value = checkedArray
            console.log(reviewrs.value)
        };

        return {
            mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiEye, mdiTrashCan,
            guardar,
            checked
        }
    }

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiTableBorder" :title="titulo" main>
            <a :href="route(`${routeName}index`)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg></a>
        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox form has-table @submit.prevent="guardar">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Fecha Captura</th>
                        <th>Asignar revisores</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Nombre">
                            {{ proposal.title }}
                        </td>
                        <td data-label="Status">
                            Pendiente
                        </td>
                        <td data-label="Fecha Captura">
                            {{ proposal.created_at }}
                        </td>

                        <td>
                            <!--                      <select v-model="form.evaluador_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Selecciona un evaluador</option>
                                <option v-for="item in records" :value="item.id" :key="item.id">{{ item.name }}</option>
                            </select>
 -->
                            <card-box has-table>
                                <table>
                                    <thead>
                                        <tr>
                                            <th v-if="true" />
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in records" :key="item.id">
                                            <TableCheckboxCell @checked="checked($event, item)" />
                                            <td data-label="Nombre">
                                                {{ item.name }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </card-box>

                        </td>

                    </tr>
                </tbody>
            </table>
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" color="info" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>

    </LayoutMain>
</template>
