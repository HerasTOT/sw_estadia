<script>
import axios from 'axios';
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
        roles: { type: Object, required: true },
        permissions: { type: Object, required: true },
        user: { type: Object, required: true },
    },
    data() {
        return {
            selectedRole: null,
            mdiBallotOutline,
            mdiAccount,
            mdiMail,
            mdiGithub
        };
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        SectionTitleLineWithButton,
        CardBox
    },
    methods: {
        assignRole() {
            const form = useForm({
                role_id: this.selectedRole
            })
            form.post(route('profile.assignRole', this.$props.user.id))
        },
    },
};

</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <a :href="route('profile.index')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg></a>
        </SectionTitleLineWithButton>


        <CardBox form @submit.prevent="assignRole">
            <FormField label="Roles">
                <FormControl v-model="selectedRole" placeholder="" :options="roles" :icon="mdiAccount" />
            </FormField>
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="assignRole" type="submit" color="info" label="Crear" />
                    <BaseButton :href="route('profile.index')" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

