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
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { useStyleStore } from "@/stores/style.js";
import { computed } from 'vue';
import FormValidationErrors from "@/components/FormValidationErrors.vue";


export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        events: { type: Array, required: true },
        announcements: { type: Array, required: true },
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
        VueDatePicker,
        FormValidationErrors
    },
    setup(props) {
        const submit = () => {
            if (form.date_start == '' || form.date_end == '') {
                form.post(route('calendar.store'));
            }
            else{
                form.date_start = dateTransform(form.date_start)
                form.date_end = dateTransform(form.date_end)
                console.log(form.data())
                form.post(route('calendar.store'));
            }

        };

        

        const dateTransform = (dateRefer) => {
            var date = new Date();
            date = dateRefer;
            date = date.getUTCFullYear() + '-' +
                ('00' + (date.getUTCMonth() + 1)).slice(-2  ) + '-' +
                ('00' + date.getUTCDate()).slice(-2) + ' ' +
                ('00' + date.getUTCHours()).slice(-2) + ':' +
                ('00' + date.getUTCMinutes()).slice(-2) + ':' +
                ('00' + date.getUTCSeconds()).slice(-2);
            return date;
        }

        const form = useForm({
            date_start: '',
            date_end: '',
            id_announcements: '',
            id_events: '',
            observations: ''
        });

        const styleStore = useStyleStore();
        const isDark = computed(() => styleStore.isDark())

        return { submit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, isDark }
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

        <CardBox form @submit.prevent="submit">
            <FormValidationErrors />

            <FormField label="Fecha de inicio">
                <VueDatePicker v-model="form.date_start" :dark="isDark" :enableTimePicker="false"></VueDatePicker>
            </FormField>
            <FormField label="Fecha Final">
                <VueDatePicker v-model="form.date_end" :dark="isDark" :enableTimePicker="false"></VueDatePicker>
            </FormField>
            <FormField v-if="events" label="Eventos" label-for="events" help="Porfavor seleccione un Evento">
                <FormControl v-model="form.id_events" id="events" :options="events" required />
            </FormField>

            <FormField v-else label="Eventos" label-for="events" help="Porfavor seleccione un evento">
                <FormControl v-model="form.id_events" id="events" placeholder="NO HAY EVENTOS DISPONIBLES" :options="events"
                    transparent disabled required />
            </FormField>

            <FormField v-if="announcements" label="Convocatorias" label-for="announcements"
                help="Porfavor seleccione una convocatoria">
                <FormControl v-model="form.id_announcements" id="announcements" :options="announcements" required />
            </FormField>

            <FormField v-else label="Convocatorias" label-for="announcements" help="Porfavor seleccione un convocatoria">
                <FormControl v-model="form.id_announcements" id="announcements"
                    placeholder="NO HAY CONVOCATORIAS DISPONIBLES" :options="announcements" transparent disabled required />
            </FormField>

            <FormField label="Observaciones" label-for="observations" help="Observaciones Generales">
                <FormControl v-model="form.observations" id="observations" />
            </FormField>


            <template #footer>
                <BaseButtons>
                    <BaseButton @click="submit" type="submit" color="info" label="Crear" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
