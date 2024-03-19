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
        pregunta: { type: Object, required: true },
        version: { type: Object, required: true },
        
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
    setup(props) {
        const handleSubmit = () => {
            form.post(route('pregunta.store-pregunta'));
        };

        const form = useForm({
            pregunta: '',
            formato: props.formato,
            version: props.version,
        });
        
       
        return { 
            handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub
        
        }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
          
        </SectionTitleLineWithButton>

{{ version }}

<table>
    <thead>
        <tr>
            <th>Versión</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="version in version" :key="version">
            <td>{{ version }}</td> 
            <td>
                <BaseButton color="warning" :icon="mdiApplicationEdit" small
                            :href="route('pregunta.habilitar-formulario', {formato_id: 1, version_id: version, estatus: '1'})" />
            </td>
            <td>
                <BaseButton color="danger" :icon="mdiApplicationEdit" small
                            :href="route('pregunta.habilitar-formulario', {formato_id: 1, version_id: version, estatus: '0'})" />
            </td>
        </tr>

    </tbody>
</table>

    </LayoutMain>
</template>
