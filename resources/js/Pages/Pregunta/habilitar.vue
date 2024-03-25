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
<table>
    <thead>
        <tr>
            <th>Versión</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
  

    <tbody v-for="(versions, formato) in version" :key="formato">
        <tr v-for="version in versions" :key="version">
            <td>{{ formato }}</td> 
            <td>Versión {{ version }}</td> 
            <td>
                <BaseButton color="warning" :icon="mdiApplicationEdit" small label="Activar formulario" 
                            :href="route('pregunta.habilitar-formulario', {formato_id: formato, version_id: version, estatus: '1'})" />
            </td>
            <td>
                <BaseButton color="danger" :icon="mdiApplicationEdit" small label="Desactivar formulario" 
                            :href="route('pregunta.habilitar-formulario', {formato_id: formato, version_id: version, estatus: '0'})" />
            </td>
        </tr>
    </tbody>
    
</table>

    </LayoutMain>
</template>
