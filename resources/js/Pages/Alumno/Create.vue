<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        usuarios: { type: String, required: true },
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton
    },
    setup() {

        const handleSubmit = () => {
            form.post(route('alumno.store'));
        };

        const form = useForm({
            cuatrimestre: '',
            matricula:'',
            user_id: null,
        });

        return { handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <a :href="`${route(routeName + 'index')}`">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </a>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField >
                <FormControl v-model="form.cuatrimestre"  placeholder="cuatrimestre"/>
                <FormControl v-model="form.matricula" placeholder="matricula" />
                <label for="user_id">Seleccionar Usuario:</label>
                <select v-model="form.user_id" id="user_id">
                    <option :value="null" disabled>Seleccione un usuario</option>
                    <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.id">{{ usuario.name }}</option>
                </select>
              </FormField>
           
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="handleSubmit" type="submit" color="info" label="Crear" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                        label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
