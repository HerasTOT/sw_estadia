<script setup>
import { ref, onMounted, watchEffect } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";
const { recursamientos, routeName } = defineProps([

    'recursamientos',
    'routeName',
]);


</script>

<template>
    <LayoutMain>
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>
      


    
    </LayoutMain>
</template>
