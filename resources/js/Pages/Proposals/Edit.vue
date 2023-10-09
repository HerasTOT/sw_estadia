<script>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import {
    mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, mdiTrashCan, mdiEye, mdiArchiveArrowDown
} from "@mdi/js";
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
import FormFilePicker from "@/components/FormFilePicker.vue";
import axios from 'axios';
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import Swal from "sweetalert2";
import { computed, ref } from "vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        convocatoria: { type: Object, required: true },
        proposal: { type: Object, required: true },
        criterias: { type: Object, required: true },
        state: { type: Object, required: true },
    },
    components: {
        LayoutMain,
        FormField,
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
        FormFilePicker,
        FormValidationErrors,
        NotificationBarInCard,

    },
    methods: {
        onchange(e) {
            const name = e.target.name
            const fileA = e.target.files[0]
            this.file.push({ name: name, file: fileA })
            console.log(this.file)
        },
        getPdf(filename) {
            axios({
                url: '/download-pdf/' + (filename + '.pdf') + '/' + this.proposal.user_id + '/' + this.proposal.id,
                method: 'GET',
                responseType: 'blob', // This is important
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', filename + '.pdf');
                document.body.appendChild(link);
                link.click();
            });
        },
        viewPdf(filename) {
            axios({
                url: '/view-pdf/' + (filename + '.pdf') + '/' + this.proposal.user_id + '/' + this.proposal.id,
                method: 'GET',
                responseType: 'blob',
            }).then(response => {
                const blob = new Blob([response.data], { type: 'application/pdf' });
                this.documentUrl = URL.createObjectURL(blob);
                this.pdfTitle = filename
            });
        }
    },
    setup(props) {
        const submit = () => {
            if (file.length <= 0) {
                Swal.fire({
                    title: "No se actualizaron los documentos",
                    text: "Se conservaran los" + props.convocatoria.documents_supporting.length + " documentos anteriomente subidos, ¿Esta seguro?",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok!",
                }).then((res) => {
                    if (res.isConfirmed) {
                        form.put(route('proposals.update', props.proposal.id))

                    }
                });
            }
            else {
                const config = {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }


                const formData = new FormData();

                for (let index = 0; index < file.length; index++) {
                    formData.append('myFiles[' + index + ']', file[index].file, file[index].name + ".pdf")
                }

                formData.append("_method", "put");


                Object.entries(form.data()).forEach(([key, value]) => {
                    formData.append(key, value)
                })

                axios.post(route('proposals.update', props.proposal.id),
                    formData, config
                )
                    .then((response) => {
                        window.location = route('proposals.index')
                    })
                    .catch(function (error) {
                        if (error.response) {

                            Object.entries(error.response.data.errors).forEach(([key, value]) => {
                                errors.value.push(value[0])
                            })

                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {

                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                        console.log(error.config);
                    });
            }

        };

        const documentUrl = ref(null);


        const n_criterias = ref([]);

        const file = []

        const form = useForm({
            ...props.proposal
        })

        const linea = ['Linea 1', 'Linea 2', 'Linea 3']

        const errors = ref([]);


        const hasErrors = computed(() => errors.value.length > 0);

        return {
            n_criterias, submit, form, mdiTrashCan, mdiBallotOutline, mdiEye, documentUrl,
            mdiArchiveArrowDown, mdiAccount, mdiMail, mdiGithub, linea, file, hasErrors, errors, file
        }
    },
    mounted() {
        this.form.state_id = this.state.id
        let checkedArray = this.convocatoria.assesstment_criterias
        const isClientName = row => client => row.assessment_criteria_id === client.id
        const remove = (arr, cb) => arr.filter(item => !cb(item))

        for (let index = 0; index < this.criterias.length; index++) {
            const isNameChecked = isClientName(this.criterias[index]);
            checkedArray = remove(checkedArray, isNameChecked);
            console.log(checkedArray)
        }

        this.n_criterias.value = checkedArray

    }

}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <a :href="route(`${routeName}index`)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg></a>
        </SectionTitleLineWithButton>

        <CardBox>
            <NotificationBarInCard v-if="hasErrors" color="danger">
                <b>Whoops! Algo salio mal!.</b>
                <span v-for="(error, key) in errors" :key="key">{{ error }}</span>
            </NotificationBarInCard>

            <div v-if="documentUrl">
                <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="pdfTitle" main>
                    <button class="flex flex-row " @click="documentUrl = null"><svg xmlns="http://www.w3.org/2000/svg"
                            width="32" height="32" fill="crimson" class="bi bi-x" viewBox="0 0 16 16">
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg> <b class="leading-7 text-lg ">Cerrar</b></button>
                </SectionTitleLineWithButton>
                <iframe :src="documentUrl" class="w-full aspect-video" allowfullscreen></iframe>
            </div>
            <Tabs>
                <Tab title="Gestion de documentacion" :criteria="false">
                    <table>
                        <thead>
                            <tr>
                                <th>PDF</th>
                                <th>Nombre</th>
                                <th>Subir</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in convocatoria.documents_supporting" :key="index">
                                <td class="border-b-0 lg:w-6 before:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z" />
                                    </svg>
                                </td>
                                <td data-label="Name">
                                    {{ item.name }}
                                </td>
                                <td class="flex flex-row ">
                                    <input type="file" :name="item.name" id="file-input" @change="onchange"
                                        accept="application/pdf"
                                        class="block mx-2 w-full border border-gray-200 shadow-sm rounded-md text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 file:bg-transparent file:border-0 file:bg-gray-100 file:mr-4 file:py-3 file:px-4 dark:file:bg-gray-700 dark:file:text-gray-400">
                                </td>

                                <td class="before:hidden lg:w-1  whitespace-nowrap">
                                    <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                        <BaseButton color="info" :icon="mdiEye" small @click="viewPdf(item.name)" />
                                        <BaseButton color="success" :icon="mdiArchiveArrowDown" small
                                            @click="getPdf(item.name)" />
                                    </BaseButtons>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <base-divider></base-divider>
                    <BaseButtons>
                        <BaseButton @click="submit" type="submit" color="info" label="Subir" />
                        <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                            label="Cancelar" />
                    </BaseButtons>
                </Tab>

                <Tab title="Gestion de propuestas" :criteria="false">

                    <FormField label="Titulo de la propuestas" help="Max 255 caracteres">
                        <FormControl v-model="form.title" type="tel"
                            placeholder="Asigne el nombre de identificacion para el proyecto" />
                    </FormField>

                    <FormField label="Linea de investigacion" help="Seleccione una linea de investigacion">
                        <FormControl v-model="form.line_research" :options="linea" />
                    </FormField>

                    <FormField label="Resumen"
                        help="Descripcion general de la convocatoria. Min 1000 caracteres. Max 4000 caracteres">
                        <FormControl v-model="form.abstract" type="textarea"
                            placeholder="Explica brevemente la Propuesta" />
                    </FormField>

                    <FormField label="Planteamiento del problema"
                        help="Describle la problematica que se abordara. Min 500 caracteres. Max 3000 caracteres">
                        <FormControl v-model="form.problem_statement" type="textarea"
                            placeholder="Explica una o mas problematicas" />
                    </FormField>

                    <FormField label="Justificacion"
                        help="Justifica la realizacion del proyecto. Min 500 caracteres. Max 3000 caracteres">
                        <FormControl v-model="form.justification" type="textarea"
                            placeholder="Describe las dimensiones, necesidades y oportunidades de la Propuesta" />
                    </FormField>

                    <FormField label="Antecedentes de la propuestas"
                        help="Si la propuesta es la continuacion de una investigacion previamente apoyada, favor de mencionarlo. Min 500 caracteres. Max 3000 caracteres">
                        <FormControl v-model="form.background" type="textarea"
                            placeholder="Describe los estudios previos, vacios del conocimiento, resultados contradictorios en otras investigaciones" />
                    </FormField>
                    <FormField label="Experiencia de los responsables" help="Min 500 caracteres. Max 4000 caracteres">
                        <FormControl v-model="form.technical_manager_experience" type="textarea"
                            placeholder="Describe la experienca similar en proyectos previos del responsable tecnico y el personal clabe de la Propuesta" />
                    </FormField>


                    <FormField label="Capacidades de los responsables" help="Min 500 caracteres. Max 4000 caracteres">
                        <FormControl v-model="form.capcities" type="textarea"
                            placeholder="Describe las capacidades con las que cuenta para desarrollar el proyecto de investigacion" />
                    </FormField>

                    <FormField label="Objetivo general" help="Min 100 caracteres. Max 1000 caracteres">
                        <FormControl v-model="form.general_objective" type="textarea"
                            placeholder="Describe claro y preciso, la finalidad de la investigación, qué se " />
                    </FormField>

                    <FormField label="Objetivos específicos" help="Min 100 caracteres. Max 2000 caracteres">
                        <FormControl v-model="form.specific_objective" type="textarea"
                            placeholder="Describe las metas, medibles y alcanzables durante el desarrollo del proyecto, deben ser presentadas de manera clara, concreta y concisa." />
                    </FormField>

                    <FormField label="Revisión de la literatura" help="Min 1000 caracteres. Max 4000 caracteres">
                        <FormControl type="textarea"
                            placeholder="Describe los resultados obtenidos de otros estudios similares previos" />
                    </FormField>

                    <FormField label="Grado de novedad científica" help="Min 500 caracteres. Max 4000 caracteres">
                        <FormControl v-model="form.differentiators" type="textarea"
                            placeholder="Enumera los puntos modulares que evidencien el grado de novedad científica, contenido innovador, originalidad y relevancia científica" />
                    </FormField>

                    <FormField label="Beneficios de la propuesta" help="Min 500 caracteres. Max 3000 caracteres">
                        <FormControl v-model="form.benefits" type="textarea"
                            placeholder="Describe al menos uno de los elementos que se beneficiarán con la implementación del proyecto de innovación" />
                    </FormField>

                    <FormField label="Principales resultados esperados" help="Min 500 caracteres. Max 3000 caracteres">
                        <FormControl v-model="form.expected_results" type="textarea"
                            placeholder="Describe el conocimiento de frontero esperado, Indicar los resultados novedosos" />
                    </FormField>

                    <FormField label="Entregables comprometidos" help="Min 100 caracteres. Max 2000 caracteres">
                        <FormControl type="textarea" v-model="form.expected_results_review"
                            placeholder="Especifica cuales son los entregables comprometidos como resultado del proyecto de investigación" />
                    </FormField>

                    <FormField label="Producto que se compromete a entregar">
                        <FormControl :options="linea" />
                    </FormField>

                    <FormField label="Propiedad intelectual" help="Min 500 caracteres. Max 4000 caracteres">
                        <FormControl v-model="form.ownership_proposal" type="textarea"
                            placeholder="Descripción de los porcentajes de Uularidad de lo propiedad intelectual y de la propuesto de explotación de los derechos en caso de existir" />
                    </FormField>

                    <FormField label="Referencias" help="Min 500 caracteres. Max 4000 caracteres">
                        <FormControl v-model="form.products_generated" type="textarea" placeholder="Referencias..." />
                    </FormField>

                    <base-divider></base-divider>

                    <BaseButtons>
                        <BaseButton @click="submit" type="submit" color="info" label="Subir" />
                        <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                            label="Cancelar" />
                    </BaseButtons>

                </Tab>
                <Tab :criteria="(proposal.state_id == 2 || proposal.state_id == 1)" title="Criterios Evaluados">

                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Evaluación de su propuesta con
                        respecto a los criterios de la convocatoria:</h2>
                    <h3 class="mb-2 text-md font-semibold text-gray-900 dark:text-white">Aprobados</h3>

                    <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                        <li v-for="item in n_criterias.value" :key="item.id" class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ item.name }}
                        </li>
                    </ul>
                    <h3 class="pt-6 mb-2 text-md font-semibold text-gray-900 dark:text-white">Rechazados</h3>
                    <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                        <li v-for="item in criterias" :key="item.id" class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ item.assesstment_criterias.name }}
                            <h3 class="p-2 text-md font-semibold text-gray-900 dark:text-white">observaciones:</h3>
                            {{ item.observations }}
                        </li>
                    </ul>

                </Tab>

            </Tabs>

        </CardBox>
    </LayoutMain>
</template>
