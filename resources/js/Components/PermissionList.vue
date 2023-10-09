<template>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Especifica la documentacion necesaria para la convocatoria</h1>

        <div class=" mb-4">
            <FormField help="Documentos requeridos para la propuesta de un proyecto">
                <FormControl v-model="name" type="text" placeholder="Nombre del documento" />
            </FormField>
            <BaseButtons>
                <BaseButton @click="addTask" color="info" label="Añadir" />
            </BaseButtons>
        </div>
    </div>
</template>
  
<script>
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";



export default {
    components: {
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        SectionTitleLineWithButton
    },
    data() {
        return {
            tasks: [],
            name: '',
            mdiBallotOutline
        };
    },
    methods: {
        addTask() {
            this.tasks = []
            if (this.name.trim() !== '') {
                this.tasks.push({ name: this.name});
                this.name = '';
                this.$emit("permissions", this.tasks)
            }
            else {

            }
        }
    }
};
</script>
  