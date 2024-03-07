
<script setup>
import { ref, defineProps,watch, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';
import { mdiBallotOutline} from "@mdi/js";
const props = defineProps(['titulo', 'Inteligencia','respuestas', 'preguntas','routeName']);


const form = useForm({ 
...props.Inteligencia,
respuestas:{}

});



const handleSubmit = () => {
    updateFormWithWatchData();
    console.log('Datos del formulario:', form);
    form.put(route("inteligencia.update"));
};

watch(
    () => form,
    (newValue) => {
        console.log('form:', newValue);
    },
    { deep: true }
);

watch(
    () => props.respuestas,
    (newValue) => {
        console.log('respuestas:', newValue);
    },
    { deep: true }
);
onMounted(() => {
    updateFormWithWatchData();
});
function updateFormWithWatchData() {
    form.respuestas = {};
    props.respuestas.forEach(respuesta => {
        form.respuestas[respuesta.pregunta.id] = respuesta;
    });
}
</script>
<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <Link :href="route(`${routeName}index`)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </Link>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField label="Matricula">
                <FormControl v-model="form.matricula"  placeholder="Matricula"/>
             </FormField>
             <FormField label="Grado">
                <FormControl v-model="form.grado" placeholder="grado" />
             </FormField>
             <FormField label="Grupo">
                <FormControl v-model="form.grupo" placeholder="grupo" />
             </FormField>
             <FormField label="Tutor">
                <FormControl v-model="form.tutor" placeholder="tutor" />
             </FormField>
             <FormField label="Periodo">
                <FormControl v-model="form.periodo" placeholder="periodo" />
             </FormField>
             
             <FormField label="Inteligencias multiples">
                <div v-for="pregunta in preguntas" :key="pregunta.id">
                    <p style="font-size: 20px; color: #292929; font-weight: 600;">{{ pregunta.pregunta }}</p>
                    <ul>
                        <li v-for="respuestaForm in respuestas.filter(item => item.pregunta.id === pregunta.id)" :key="respuestaForm.id">
                            
                            <FormControl v-model="respuestaForm.respuesta" />
                        </li>
                    </ul>
                    <br>
                </div>
            </FormField>
          
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="handleSubmit" type="submit" color="info" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                        label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
       
    </LayoutMain>
</template>