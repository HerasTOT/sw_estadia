<script>
import { Link, useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import { ref } from 'vue';


export default {
    props: {
        role: { type: Object, required: true },
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        permissions: { type: Object, required: true }
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
        FormValidationErrors,
        TableCheckboxCell
    },
    methods: {
       
    },
    setup(props) {


        const permission = ref([]);

        const remove = (arr, cb) => arr.filter(item => !cb(item));

        const isClientName = row => client => row.name === client.name;

        const checked = (isChecked, client) => {
            let checkedArray = permission.value;
            const isNameChecked = isClientName(client);

            if (isChecked) {
                checkedArray.push(client);
            } else {
                checkedArray = remove(checkedArray, isNameChecked);
            }

            permission.value = checkedArray
        };

        const guardar = () => {
            form.put(route('roles.update', props.role.id));
        };

        const form = useForm({
            ...props.role
        });

        return { guardar, form, permission,checked }
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

            <FormField label="Nombre">
                <FormControl placeholder="Nombre" v-model="form.name" :icon="mdiAccount" />
            </FormField>

            <FormField label="Descripcion">
                <FormControl placeholder="Descripcion" v-model="form.description" :icon="mdiAccount" />
            </FormField>

            <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="`Seleccione los permisos del rol ${'Admin'}`" main>

            </SectionTitleLineWithButton>


            <div v-if="permission.length" class="p-3 bg-gray-100/50 dark:bg-slate-800">
                <span v-for="checkedRow in permission" :key="checkedRow.id"
                    class="inline-block px-2 py-1 rounded-sm mr-2 text-sm bg-gray-100 dark:bg-slate-700">
                    {{ checkedRow.name }}
                </span>
            </div>

            <card-box has-table>
                <table>
                    <thead>
                        <tr>
                            <th v-if="true" />
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Guard Name</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in permissions" :key="item.id">
                            <TableCheckboxCell @checked="checked($event, item)" />
                            <td data-label="Nombre">
                                {{ item.name }}
                            </td>
                            <td data-label="Descripcion">
                                {{ item.description }}
                            </td>
                            <td data-label="Guard Name">
                                {{ item.guard_name }}
                            </td>

                        </tr>
                    </tbody>
                </table>
            </card-box>

            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" color="info" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
