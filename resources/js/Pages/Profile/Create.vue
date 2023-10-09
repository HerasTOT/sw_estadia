<script >
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref, reactive } from "vue";
import { mdiAccount, mdiEmail, mdiFormTextboxPassword, mdiAsterisk, mdiLogout, mdiBallotOutline } from "@mdi/js";
import LayoutGuest from "@/layouts/LayoutGuest.vue";
import SectionFullScreen from "@/components/SectionFullScreen.vue";
import CardBox from "@/components/CardBox.vue";
import FormCheckRadioGroup from "@/components/FormCheckRadioGroup.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import axios from "axios";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import Swal from "sweetalert2";
import LayoutMain from '@/layouts/LayoutMain.vue';



export default {
    props: {
        roles: { type: Object, required: true },
        workplaces: { type: Object, required: true },
        colonies: { type: Object, required: true },
        titulo: { type: String, required: true }
    },
    components: {
        axios,
        Loading,
        LayoutGuest,
        SectionFullScreen,
        CardBox,
        FormCheckRadioGroup,
        FormField,
        FormControl,
        BaseDivider,
        BaseButtons,
        FormValidationErrors,
        BaseButton, LayoutMain,
        SectionTitleLineWithButton
    },
    setup(props) {

        const form = useForm({
            name: '',
            paternal_surname: '',
            maternal_surname: '',
            email: '',
            password: '',
            password_confirmation: '',
            curp: '',
            role: "",
            colony_id: '',
            workplace_id: '',
        });

        const isLoading = ref(false);
        const fullPage = true;
        const show = ref(true);

        const submit = () => {
            isLoading.value = true;
            form.post(route('register'), {
                onSuccess: (e) => {
                    form.reset()
                    cp.postal_code = {
                        cp: "",
                        township: "",
                        colony: "",
                        state: ""
                    }
                    isLoading.value = false;

                },
                onFinish: () => {
                    isLoading.value = false;
                    form.reset(['password' | 'password_confirmation'])
                }
            });
        };

        const cp = reactive({
            postal_code: {
                cp: "",
                township: "",
                colony: [],
                state: ""
            }
        });

        const getData = () => {
            isLoading.value = true;
            axios
                .get(route("renapo.show", form.curp.toUpperCase()))
                .then((response) => {
                    isLoading.value = false;
                    form.name = response['data']['nombres']
                    form.paternal_surname = response['data']['apellidoPaterno']
                    form.maternal_surname = response['data']['apellidoMaterno']
                })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 500) {
                            isLoading.value = false;
                            Swal.fire({
                                title: "Curp Incorrecta!",
                                text: "La curp ingresada no es valida, intente nuevamente",
                                icon: "warning",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Ok!",
                            });
                        }
                    } else if (error.request) {
                        isLoading.value = false;
                        Swal.fire({
                            title: "Error!",
                            text: "Lo sentimos hubo un error, intente nuevamente",
                            icon: "warning",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Ok!",
                        });
                    } else {
                        isLoading.value = false;
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                })

        };

        const getColony = (e) => {
            isLoading.value = true;
            if (cp.postal_code != '') {
                axios
                    .get(route("colony.index", cp.postal_code))
                    .then((response) => {
                        show.value = false;
                        cp.postal_code.township = response['data'][0]['township']['name'];
                        cp.postal_code.colony.push({ id: response['data'][0]['id'], name: response['data'][0]['name'] });
                        cp.postal_code.state = response['data'][1]['name'];
                        isLoading.value = false;
                        console.log(cp.postal_code.colony[0])
                    })
                    .catch(function (error) {
                        if (error.response) {
                            if (error.response.status == 500) {
                                isLoading.value = false;
                                Swal.fire({
                                    title: "CP Incorrecta!",
                                    text: "El codigo postal ingresado no es valido, intente nuevamente",
                                    icon: "warning",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "Ok!",
                                });
                            }
                        } else if (error.request) {
                            isLoading.value = false;
                            Swal.fire({
                                title: "Error!",
                                text: "Lo sentimos hubo un error, intente nuevamente",
                                icon: "warning",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Ok!",
                            });
                            console.log(error.request);
                        } else {
                            isLoading.value = false;
                            console.log('Error', error.message);
                        }
                        console.log(error.config);
                    })
            }

        };

        return { show, submit, form, mdiBallotOutline, getData, getColony, mdiLogout, mdiAsterisk, cp, isLoading, fullPage, mdiAccount, mdiEmail, mdiFormTextboxPassword };
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <a :href="route(`profile.index`)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg></a>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="submit">
            <FormField label="Busqueda" help="Porfavor introduce tu curp">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" id="default-search"
                        class="block w-full p-4 pl-10 text-sm text-gray-700 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500  dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.curp" required>
                    <button @click="getData"
                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
                </div>
            </FormField>

            <div @submit.prevent="submit">

                <FormField label="Nombre" label-for="name" help="Porfavor introduce tu nombre">
                    <FormControl v-model="form.name" id="name" :icon="mdiAccount" autocomplete="off" type="text" required />
                </FormField>

                <FormField label="Apellido Paterno" label-for="paternal" help="Porfavor introduce tu apellido paterno">
                    <FormControl v-model="form.paternal_surname" id="paternal" :icon="mdiAccount" autocomplete="off"
                        type="text" required />
                </FormField>

                <FormField label="Apellido Materno" label-for="maternal" help="Porfavor introduce tu apellido materno">
                    <FormControl v-model="form.maternal_surname" id="maternal" :icon="mdiAccount" autocomplete="off"
                        type="text" required />
                </FormField>

                <FormField label="Email" label-for="email" help="Porfavor introduce tu correo electronico">
                    <FormControl v-model="form.email" id="email" :icon="mdiEmail" type="text" />
                </FormField>

                <FormField label="Contraseña" label-for="password" help="Porfavor introduce tu contraseña">
                    <FormControl v-model="form.password" :icon="mdiAsterisk" type="password" id="password"
                        autocomplete="current-password" required />
                </FormField>

                <FormField label="Confirma Contraseña" label-for="password_conf" help="Confirma tu contraseña">
                    <FormControl v-model="form.password_confirmation" :icon="mdiAsterisk" type="password" id="password_conf"
                        autocomplete="current-password" required />
                </FormField>

                <FormField label="Rol" label-for="role" help="Porfavor seleccione un rol">
                    <FormControl v-model="form.role" id="role" :options="roles" required />
                </FormField>

                <!--    <FormField label="Codigo postal" label-for="cp" help="Porfavor introduce el codigo postal de tu residencia">
                    <FormControl @change="getColony" v-model="cp.postal_code.cp" id="cp" :icon="mdiAccount" type="text"
                      required />
                  </FormField>
         -->
                <FormField label="Codigo postal" help="Porfavor introduce el codigo postal de tu residencia">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" id="cp"
                            class="block w-full p-4 pl-10 text-sm text-gray-700 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500  dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="cp.postal_code.cp" required>
                        <button @click="getColony"
                            class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
                    </div>
                </FormField>

                <FormField label="Estado" label-for="state"
                    help="Este campo se autocompletara al introducir el codigo postal">
                    <FormControl v-model="cp.postal_code.state" id="state" :icon="mdiEmail" type="text" transparent
                        disabled />
                </FormField>

                <FormField label="Municipio" label-for="township"
                    help="Este campo se autocompletara al introducir el codigo postal">
                    <FormControl v-model="cp.postal_code.township" id="township" :icon="mdiEmail" type="text" transparent
                        disabled />
                </FormField>

                <FormField label="Colonia" label-for="colony"
                    help="Las opciones se habilitaran al introducir el codigo postal">
                    <FormControl v-model="form.colony_id" id="colony" :options="cp.postal_code.colony" :disabled="show"
                        :transparent="show" required />
                </FormField>


                <FormField label="Centro de trabajo" label-for="workplace" help="Porfavor seleccione un centro de trabajo">
                    <FormControl v-model="form.workplace_id" id="workplace" :options="workplaces" required />
                </FormField>
                <BaseDivider />

                <BaseButtons>
                    <BaseButton @click="submit" type="submit" color="info" label="Crear"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
                    <BaseButton route-name="profile.index" color="danger"  label="Cancelar" />
                </BaseButtons>
            </div>
        </CardBox>
    </LayoutMain>
</template>