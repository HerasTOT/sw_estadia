<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, mdiEye, mdiTrashCan } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Tabs from '@/components/Tabs.vue';
import Tab from '@/components/Tab.vue';
import ToggleSwitch from '@/components/ToggleSwitch.vue';
import TodoList from '@/components/TodoList.vue';
import DocList from '@/components/DocList.vue';
import { ref, computed, reactive } from 'vue';
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import FormValidationErrors from '@/components/FormValidationErrors.vue'
import NotificationBar from "@/components/NotificationBar.vue";
import axios from 'axios';
import Swal from "sweetalert2";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { useStyleStore } from "@/stores/style.js";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';


export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        institutions: { type: Object, required: true },
        assesstments: { type: Object, required: true },
        documents: { type: Object, required: true },
        events: { type: Object, required: true }

    },
    components: {
        LayoutMain,
        FormField,
        Loading,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton,
        Tabs,
        Tab,
        ToggleSwitch,
        TodoList,
        TableCheckboxCell,
        DocList,
        FormValidationErrors,
        NotificationBar,
        VueDatePicker
    },
    methods: {
        todo: function (data) {
            if (this.assesstments.some(e => e.name === data[0].name)) {
                this.again = true
                this.errors = 'No puede incluir un criterio con el mismo titulo!'
            }
            else {
                this.assesstments.push(data[0]);
            }
        },
        docs: function (data) {
            if (this.documents.some(e => e.name === data[0].name)) {
                this.again = true
                this.errors = 'No puede incluir un documentos con el mismo titulo!'
            }
            else {
                this.documents.push(data[0]);
            }
        },
        onchange(e) {
            if (this.file.some(val => val.name === e.target.name)) {
                const i = this.file.findIndex(val => val.name === e.target.name)
                const name = e.target.name
                const fileA = e.target.files[0]
                this.file[i] = { name: name, file: fileA }
                console.log(this.file)
            }
            else {
                const name = e.target.name
                const fileA = e.target.files[0]
                this.file.push({ name: name, file: fileA })
                console.log(this.file)
            }
        },
        dateChange(e, name, operation) {
            if (operation) {
                if (this.date.some(val => val.name === name)) {
                    const i = this.date.findIndex(val => val.name === name)
                    if (e.target.value >= this.date[i].date_start) {
                        Swal.fire({
                            title: "La fecha de final es menor a la fecha inicial!",
                            text: "Seleccione una  fecha final posterior a la fecha inicial para el evento " + name,
                            icon: "warning",
                            timer: 10000,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Ok!",
                        });
                        e.target.value = null
                    }
                    else {
                        this.date[i].date_start = e.target.value
                    }
                }
                else {
                    this.date.push({ name: name, date_start: e.target.value, date_end: null })
                }
                console.log(this.date)
            }
            else if (this.date.some(val => val.name === name)) {
                const i = this.date.findIndex(val => val.name === name)

                if (e.target.value <= this.date[i].date_start) {
                    Swal.fire({
                        title: "La fecha de final es menor a la fecha inicial!",
                        text: "Seleccione una  fecha final posterior a la fecha inicial para el evento " + name,
                        icon: "warning",
                        timer: 10000,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Ok!",
                    });
                    e.target.value = null
                }
                else {
                    this.date[i].date_end = e.target.value
                }
            }
            else {
                Swal.fire({
                    title: "Seleccione primero la fecha de inicio!",
                    text: "Luego de seleccionar la fecha de inicio de '" + name + "' podra seleccionar la fecha final!",
                    icon: "warning",
                    timer: 10000,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok!",
                });
                e.target.value = null
            }
        },

    },
    setup(props) {


        const isLoading = ref(false);
        const fullPage = true;

        const date = [];


        const submit = () => {
            if (file.length < 1) {
                Swal.fire({
                    title: "PDF de publicidad obligatorio!",
                    text: "Es necesario el documento de publicidad!",
                    icon: "warning",
                    timer: 10000,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok!",
                });
            } else if (date.length < props.events.length) {
                Swal.fire({
                    title: "Seleccione las fechas para todos los eventos!",
                    text: "Es necesario establecer la fecha de los " + props.events.lenght + " eventos",
                    icon: "warning",
                    timer: 10000,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok!",
                });
            }
            else {

                isLoading.value = true

                const config = {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }

                const formData = new FormData();

                for (let index = 0; index < file.length; index++) {
                    formData.append('myFiles[' + index + ']', file[index].file, file[index].name + ".pdf")
                }

                date.forEach((object, index) => {
                    formData.append('dates[' + index + '][name]', object.name)
                    formData.append('dates[' + index + '][date_start]', object.date_start)
                    formData.append('dates[' + index + '][date_end]', object.date_end)
                    formData.append('dates[' + index + '][date_end]', object.date_end)
                })

                Object.entries(form.data()).forEach(([key, value]) => {
                    formData.append(key, value)
                })

                checkedRows.value.forEach((object, index) => {
                    if (object.id) {
                        formData.append('assesstments[' + index + '][id]', object.id)
                    }
                    formData.append('assesstments[' + index + '][name]', object.name)
                    formData.append('assesstments[' + index + '][value]', object.value)
                })

                checkedDocs.value.forEach((object, index) => {
                    if (object.id) {
                        formData.append('documents[' + index + '][id]', object.id)

                    }
                    formData.append('documents[' + index + '][name]', object.name)
                })


                axios.post(route('announcements.store'), formData, config).then((response) => {
                    window.location = route('announcements.index')/* .with('success', 'Su Convocatoria ha sido guardada con éxito!') */
                })
                    .catch(function (error) {
                        if (error.response) {
                            isLoading.value = false

                            Object.entries(error.response.data.errors).forEach(([key, value]) => {
                                errors.value.push(value[0])
                            })

                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                        console.log(error.config);
                    });



            }

/*             form.post(route('announcements.store'));
 */        }

        const showTable = computed(() => {
            return props.assesstments.length > 0 ? true : false
        })


        const form = useForm({
            name: '',
            description: '',
            num_announcement: '1',
            status: 1,
            y_announcement: '2023',
            institutions_id: '',
            assesstments: [],
            documents: []
        });

        const file = []
        const checkedRows = ref([]);
        const checkedDocs = ref([]);

        const remove = (arr, cb) => arr.filter(item => !cb(item));

        const isClientName = row => client => row.name === client.name;

        const checked = (isChecked, client, type) => {
            let checkedArray = type ? checkedRows.value : checkedDocs.value;
            const isNameChecked = isClientName(client);

            if (isChecked) {
                checkedArray.push(client);
            } else {
                checkedArray = remove(checkedArray, isNameChecked);
            }

            if (type) {
                checkedRows.value = checkedArray;
            } else {
                checkedDocs.value = checkedArray;
            }
        };

        const eliminar = (id, type) => {
            if (type) {
                props.assesstments = remove(props.assesstments, (row) => row.id === id)
            }
            else {
                props.documents = remove(props.documents, (row) => row.id === id)
            }
        }

        const dateTransform = (dateRefer) => {
            var date = new Date();
            date = dateRefer;
            date = date.getUTCFullYear() + '-' +
                ('00' + (date.getUTCMonth() + 1)).slice(-2) + '-' +
                ('00' + date.getUTCDate()).slice(-2) + ' ' +
                ('00' + date.getUTCHours()).slice(-2) + ':' +
                ('00' + date.getUTCMinutes()).slice(-2) + ':' +
                ('00' + date.getUTCSeconds()).slice(-2);
            return date;
        }


        const again = ref(false);

        const styleStore = useStyleStore();
        const isDark = computed(() => styleStore.isDark())

        const errors = ref([]);

        const hasErrors = computed(() => errors.value.length > 0);

        return { isLoading, fullPage, again, date, isDark, errors, file, hasErrors, submit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, checked, checkedRows, mdiEye, mdiTrashCan, showTable, eliminar, checkedDocs }
    },
}
</script>

<template>
    <LayoutMain :title="titulo">

        <div class="vl-parent">
            <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="fullPage" />
        </div>

        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <a :href="route(`${routeName}index`)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg></a>
        </SectionTitleLineWithButton>



        <CardBox form @submit.prevent="submit">
            <FormValidationErrors />

            <NotificationBar v-if="hasErrors" color="danger" :again="again" :icon="mdiInformation" :outline="false">
                {{ errors }}
            </NotificationBar>

            <Tabs>
                <Tab title="General">
                    <div class="p-4 rounded-lg" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h1 class="text-2xl font-bold mb-4">Informacion general de la convocatoria</h1>
                        <FormField label="Titulo">
                            <FormControl v-model="form.name" type="text" placeholder="Titulo de la convocatoria" />
                        </FormField>

                        <FormField label="Instituciones">
                            <FormControl v-model="form.institutions_id" :options="institutions" />
                        </FormField>

                        <FormField label="Descripcion" help="Descripcion general de la convocatoria. Max 255 caracteres">
                            <FormControl v-model="form.description" type="textarea"
                                placeholder="Explica brevemente la convocatoria" />
                        </FormField>

                        <label for="dropzone-file" class="block font-bold mb-2">Publicidad</label>
                        <div class="flex items-center justify-center w-full">
                            <input type="file" name="advertising" id="file-input" @change="onchange"
                                accept="application/pdf"
                                class="block w-full border border-gray-200 shadow-sm rounded-md text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 file:bg-transparent file:border-0
                                                                                                                              file:bg-gray-100 file:mr-4 file:py-3 file:px-4 dark:file:bg-gray-700 dark:file:text-gray-400">
                        </div>

                    </div>
                </Tab>
                <Tab title="Calendario">
                    <div class="p-4 rounded-lg">
                        <h1 class="text-2xl font-bold mb-4">Seleccione las fechas de los eventos de la convocatoria</h1>

                        <div class="my-10 divide-y" v-for="item in events" :key="item.id">
                            <FormField :label="'Fecha de inicio y final del evento -' + item.name + '-'">

                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input type="date" @change="dateChange($event, item.name, true)"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Select date">
                                </div>

                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input type="date" @change="dateChange($event, item.name, false)"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Select date">
                                </div>

                            </FormField>

                        </div>
                    </div>
                </Tab>
                <Tab title="Criterios de Evaluacion">
                    <div class="p-4 rounded-lg" id="profile">
                        <todo-list @tasks="todo" ref="TodoListRef"></todo-list>

                        <div v-if="assesstments.length > 0">
                            <SectionTitleLineWithButton class="pt-6" :icon="mdiBallotOutline" title="Criterios" main>
                                <a :href="route('announcements.index')"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg></a>
                            </SectionTitleLineWithButton>

                            <BaseDivider />

                            <div v-if="checkedRows.length" class="p-3 bg-gray-100/50 dark:bg-slate-800">
                                <span v-for="checkedRow in checkedRows" :key="checkedRow.id"
                                    class="inline-block px-2 py-1 rounded-sm mr-2 text-sm bg-gray-100 dark:bg-slate-700">
                                    {{ checkedRow.name }}
                                </span>
                            </div>

                            <table class="border-gray-200 dark:border-gray-700">
                                <thead>
                                    <tr>
                                        <th v-if="true" />
                                        <th>Nombre</th>
                                        <th>Peso</th>
                                        <th />
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="client in assesstments" :key="client.id">
                                        <TableCheckboxCell @checked="checked($event, client, true)" />

                                        <td data-label="Name">
                                            {{ client.name }}
                                        </td>

                                        <td data-label="Progress" class="lg:w-32">
                                            <progress class="flex w-2/5 self-center lg:w-full" max="100"
                                                :value="client.value">
                                                {{ client.value }}
                                            </progress>
                                        </td>
                                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                                <BaseButton color="info" :icon="mdiEye" small />
                                                <BaseButton @click="eliminar(client.id, true)" color="danger"
                                                    :icon="mdiTrashCan" small />
                                            </BaseButtons>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </Tab>
                <Tab title="Documentos">
                    <div class="p-4 rounded-lg" id="profile">
                        <doc-list @docs="docs"></doc-list>
                        <div v-if="documents.length > 0">
                            <SectionTitleLineWithButton class="pt-6" :icon="mdiBallotOutline" title="Documentos" main>
                                <a :href="route('announcements.index')"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg></a>
                            </SectionTitleLineWithButton>

                            <BaseDivider />

                            <div v-if="checkedDocs.length" class="p-3 bg-gray-100/50 dark:bg-slate-800">
                                <span v-for="checkedDoc in checkedDocs" :key="checkedDoc.id"
                                    class="inline-block px-2 py-1 rounded-sm mr-2 text-sm bg-gray-100 dark:bg-slate-700">
                                    {{ checkedDoc.name }}
                                </span>
                            </div>
                            <table class="border-gray-200 dark:border-gray-700">
                                <thead>
                                    <tr>
                                        <th v-if="true" />
                                        <th>Nombre</th>
                                        <th />
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="document in documents" :key="document.id">
                                        <TableCheckboxCell v-if="true" @checked="checked($event, document, false)" />

                                        <td data-label="Name">
                                            {{ document.name }}
                                        </td>
                                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                                <BaseButton color="info" :icon="mdiEye" small />
                                                <BaseButton @click="eliminar(document.id, false)" color="danger"
                                                    :icon="mdiTrashCan" small />
                                            </BaseButtons>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <base-divider></base-divider>
                        <BaseButtons>
                            <BaseButton @click="submit" type="submit" color="info" label="Subir" />
                            <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                                label="Cancelar" />
                        </BaseButtons>
                    </div>
                </Tab>
            </Tabs>

        </CardBox>
    </LayoutMain>
</template>
