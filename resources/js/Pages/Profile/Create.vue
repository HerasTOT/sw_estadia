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
            apellido_paterno: '',
            apellido_materno: '',
            numero: '',            
            email: '',
            password: '',
            password_confirmation: '',
            
        });

        const isLoading = ref(false);
        const fullPage = true;
        const show = ref(true);

        const submit = () => {
            isLoading.value = true;
            form.post(route('register'), {
                onSuccess: (e) => {
                    form.reset()
                    isLoading.value = false;
                },
                onFinish: () => {
                    isLoading.value = false;
                    form.reset(['password' | 'password_confirmation'])
                }
            });
        };

        return { show, submit, form, mdiBallotOutline, isLoading, fullPage, mdiAccount, mdiEmail, mdiFormTextboxPassword };
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
            

            <div @submit.prevent="submit">

                <FormField label="Nombre" label-for="name" help="Porfavor introduce tu nombre">
                    <FormControl v-model="form.name" id="name" :icon="mdiAccount" autocomplete="off" type="text" required />
                </FormField>

                <FormField label="Apellido Paterno" label-for="paternal" help="Porfavor introduce tu apellido paterno">
                    <FormControl v-model="form.apellido_paterno" id="paternal" :icon="mdiAccount" autocomplete="off"
                        type="text" required />
                </FormField>

                <FormField label="Apellido Materno" label-for="maternal" help="Porfavor introduce tu apellido materno">
                    <FormControl v-model="form.apellido_materno" id="maternal" :icon="mdiAccount" autocomplete="off"
                        type="text" required />
                </FormField>
                <FormField label="Teléfono" label-for="num" help="Porfavor introduce tu numero teléfonico">
                    <FormControl v-model="form.numero" id="num" :icon="mdiAccount" autocomplete="off"
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