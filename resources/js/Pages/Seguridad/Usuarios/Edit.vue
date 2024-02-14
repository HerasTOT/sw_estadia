<script setup>
import { ref, defineProps, onMounted } from 'vue';
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

const props = defineProps(['titulo', 'usuario', 'alumno', 'routeName']);
const form = useForm({ ...props.usuario, ...props.alumno });

const guardar = () => {
    form.put(route("usuarios.update", props.usuario.id, props.alumno.id));
};

</script>

<template>
    <LayoutMain :title="titulo">

             <!--
         <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
         <Link :href="route(`${routeName}index`)">
          </Link>
            </SectionTitleLineWithButton>
            -->


        <CardBox form @submit.prevent="guardar">
            <FormField label="Nombre">
                <FormControl v-model="form.name" placeholder="nombre" />
                <FormControl v-model="form.apellido_paterno" placeholder="apellido_paterno" />
                <FormControl v-model="form.apellido_materno" placeholder="apellido_materno" />
                <FormControl v-model="form.numero" placeholder="numero" />
                <FormControl v-model="form.email" placeholder="email" />
                <FormControl v-model="form.password" placeholder="password" />
                <FormControl v-model="form.role" placeholder="role" />
            </FormField>
            <FormField label="Datos del Alumno" v-if="alumno">
                <FormControl v-model="form.cuatrimestre" placeholder="cuatrimestre" />
                <FormControl v-model="form.matricula" placeholder="matricula" />
            </FormField>


            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" color="info" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

