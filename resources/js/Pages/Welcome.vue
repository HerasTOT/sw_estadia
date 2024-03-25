<script setup>
import { ref, onMounted, watchEffect } from 'vue';
import { Link } from '@inertiajs/vue3';
import Swal from "sweetalert2";
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import LayoutWelcome from '@/layouts/LayoutWelcome.vue';
import axios from 'axios';
import PillTag from "@/components/PillTag.vue";
import moment from 'moment';

const { canLogin,  recursamientos, routeName } = defineProps([
  'canLogin',
  'recursamientos',
  'routeName',
]);
</script>

<template>
    
    <LayoutWelcome>
      hola
{{ recursamientos }}


    </LayoutWelcome>
 
</template>
