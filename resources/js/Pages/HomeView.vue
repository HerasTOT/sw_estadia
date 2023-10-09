<script setup>
import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/stores/main";
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
  mdiMonitorCellphone,
  mdiReload,
  mdiGithub,
  mdiChartPie,
  mdiClockTimeOne,
  mdiDeleteAlert,
  mdiHandOkay,
  mdiEye,
  mdiFaceManProfile,
  mdiFlash
} from "@mdi/js";
import * as chartConfig from "@/components/Charts/chart.config.js";
import LineChart from "@/components/Charts/LineChart.vue";
import SectionMain from "@/components/SectionMain.vue";
import CardBoxWidget from "@/components/CardBoxWidget.vue";
import CardBox from "@/components/CardBox.vue";
import TableSampleClients from "@/components/TableSampleClients.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxTransaction from "@/components/CardBoxTransaction.vue";
import CardBoxClient from "@/components/CardBoxClient.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import SectionBannerStarOnGitHub from "@/components/SectionBannerStarOnGitHub.vue";
import { usePage } from "@inertiajs/vue3";

const chartData = ref(null);

const fillChartData = () => {
  chartData.value = chartConfig.sampleChartData();
};

onMounted(() => {
  fillChartData();
});

const mainStore = useMainStore();

const accepted = computed(() => props.proposals.filter((item) => item.state_id == 1).length)
const denied = computed(() => props.proposals.filter((item) => item.state_id == 4).length)
const inProcess = computed(() => props.proposals.filter((item) => item.state_id == 2 || item.state_id == 3).length)


const clientBarItems = computed(() => mainStore.clients.slice(0, 4));

const transactionBarItems = computed(() => mainStore.history);

const props = defineProps({
  users: {
    type: Object,
    default: null,
  },
  announcements: {
    type: Object,
    default: null,
  },
  proposals: {
    type: Object,
    default: null,
  },


})
</script>

<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Cifras" main>
        <BaseButton href="https://github.com/justboil/admin-one-vue-tailwind" target="_blank" :icon="mdiGithub"
          label="Star on GitHub" color="contrast" rounded-full small />
      </SectionTitleLineWithButton>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget trend="12%" color="text-emerald-500" :icon="mdiAccountMultiple"
          :number="Object.keys(users).length" label="Usuarios" />
        <CardBoxWidget trend="12%" color="text-blue-500" :icon="mdiEye" :number="7770"
          label="Visitas" />
        <CardBoxWidget trend="General" trend-type="alert" color="text-yellow-500" :icon="mdiFlash"
          :number="Object.keys(proposals).length" label="Proyectos" />
        <CardBoxWidget trend="12%" color="text-emerald-500" :icon="mdiAccountMultiple"
          :number="Object.keys(announcements).length" label="Convocatorias" />
        <CardBoxWidget trend="12%"  trend-type="up"  color="text-emerald-500" :icon="mdiHandOkay" :number="accepted"
          label="Proyectos Aceptados" />
        <CardBoxWidget trend="Overflow" trend-type="down" color="text-red-500" :icon="mdiDeleteAlert"
          :number="denied" label="Proyectos Rechazados" />
        <CardBoxWidget trend="Overflow" trend-type="alert" color="text-yellow-500" :icon="mdiClockTimeOne"
          :number="inProcess" label="Proyectos en Revisión" />
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="flex flex-col justify-between">
          <CardBoxTransaction v-for="(transaction, index) in transactionBarItems" :key="index"
            :amount="transaction.amount" :date="transaction.date" :business="transaction.business"
            :type="transaction.type" :name="transaction.name" :account="transaction.account" />
        </div>
        <div class="flex flex-col justify-between">
          <CardBoxClient v-for="client in clientBarItems" :key="client.id" :name="client.name" :login="client.login"
            :date="client.created" :progress="client.progress" />
        </div>
      </div>


      <SectionTitleLineWithButton :icon="mdiChartPie" title="Tendencias">
        <BaseButton :icon="mdiReload" color="whiteDark" @click="fillChartData" />
      </SectionTitleLineWithButton>

      <CardBox class="mb-6">
        <div v-if="chartData">
          <line-chart :data="chartData" class="h-96" />
        </div>
      </CardBox>

    </SectionMain>
  </LayoutAuthenticated>
</template>
