<template>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Añade criterios a la convocatoria</h1>

        <div class=" mb-4">
            <FormField help="Los criterios agregados a esta convocatoria estaran ligados a la misma, y posteriomente podran ser utilizados en otras convocatorias">
                <FormControl v-model="name" type="text" placeholder="Criterio" />
                <FormControl v-model="value" type="number" placeholder="Valor del criterio (solo valores entre 1 y 100)" />
            </FormField>
            <BaseButtons>
                <BaseButton @click="addTask" color="info" label="Añadir" />
            </BaseButtons>
        </div>

        <!--  <ul class="list-disc pl-8">
            <li v-for="(task, index) in tasks" :key="index" class="mb-2">{{ task.name }}</li>
        </ul> -->
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
            value: '',
            mdiBallotOutline
        };
    },
    methods: {
        addTask() {
            this.tasks = []
            if (this.name.trim() !== '' && (this.value > 0 && this.value <= 100)) {
                this.tasks.push({ name: this.name, value: this.value });
                this.name = '';
                this.value = '';
                this.$emit("tasks", this.tasks)
            }
            else {

            }
        }
    }
};
</script>
  