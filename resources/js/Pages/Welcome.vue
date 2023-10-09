<script>
import { Link, useForm } from '@inertiajs/vue3';
import Swal from "sweetalert2";
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import {
    mdiMonitorCellphone,
    mdiTableBorder,
    mdiTableOff,
    mdiGithub,
    mdiEye, mdiTrashCan
} from "@mdi/js";
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




export default {
    props: {
        records: {
            type: Object,
            required: true
        },
    },
    components: {
        Link,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        LayoutWelcome,
        PillTag
    },
    methods: {
        getDate(date_start, date_end) {
            const current = new Date();
            console.log(date_start, date_end)

            const isMajor = m_date => m_date > 10;
            const day = isMajor(current.getDate()) ? current.getDate() : '0' + current.getDate();

            const date = `${current.getFullYear()}-0${current.getMonth() + 1}-${day}`;
            console.log(date)
            if (date >= date_start && date <= date_end) {
                return true
            }
            else {
                return false
            }
        },
        getPdf(filename, announcement) {
            axios({
                url: '/download-AdPdf/' + (filename + '.pdf') + '/' + announcement,
                method: 'GET',
                responseType: 'blob', // This is important
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                console.log(url)
                link.href = url;
                link.setAttribute('download', filename + '.pdf');
                document.body.appendChild(link);
                link.click();
            });
        },
        convertTimeFormatDay(time) {
            const formattedDate = moment(time).format('DD');
            return formattedDate;
        },
        convertTimeFormatMonth(time) {
            const formattedDate = moment(time).format('MMMM');
            return formattedDate;
        }

    },
    setup() {
        return {
            mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiEye, mdiTrashCan,
            PillTag
        }
    }

}
</script>

<template>
    <LayoutWelcome>


    <CardBox class="mx-12 mt-24 max-xl:m-4 max-lg:mt-8" v-if="records.length < 1">
        <CardBoxComponentEmpty />
    </CardBox>



    <div v-else class="w-full ">

        <div class="mt-16 mx-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                <div v-for="item in records" :key="item.id"
                    class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                    <div>
                        <span>
                            <div
                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            Convocatoria
                        </span>

                        <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ item.name }} <span
                                class="text-lg text-gray-700 dark:text-gray-400">
                                {{
                                    convertTimeFormatMonth(item.created_at) }}
                            </span></h2>

                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            {{ item.description }}

                        </p>


                    </div>
                    <div class="px-12 flex flex-row space-x-2">
                        <div v-if="getDate(item.calendars[0].date_start, item.calendars[0].date_end)">
                        </div>
                        <a v-if="getDate(item.calendars[1].date_start, item.calendars[1].date_end)"
                            :href="route('proposals.show', item.id)" class="w-full">
                            <PillTag color="success" label="Inscribirse" :small="pillsSmall" :outline="pillsOutline"
                                :icon="pillsIcon" />
                        </a>
                        <a v-else-if="getDate(item.calendars[2].date_start, item.calendars[2].date_end)">
                            <PillTag color="warning" label="Propuestas en evaluacion" :small="pillsSmall"
                                :outline="pillsOutline" :icon="pillsIcon" />
                        </a>
                        <a v-else>
                            <PillTag color="danger" label="Convocatoria Cerrada" :small="pillsSmall"
                                :outline="pillsOutline" :icon="pillsIcon" />
                        </a>
                        <div @click="getPdf('advertising', item.name)">
                                <PillTag color="info" label="Descargar" :small="pillsSmall" :outline="pillsOutline"
                                :icon="pillsIcon" />
                        </div>
                    </div>

                </div>







            </div>
        </div>
        <!--   <section class="py-16 bg-[#EFF0F4] lg:py-20 dark:bg-gray-800 font-poppins">
            <div class="max-w-xl mx-auto">
                <div class="text-center ">
                    <div class="flex flex-col items-center ">
                        <p class="text-5xl font-bold leading-tight dark:text-white"> Convocatorias</p>
                        <div class="flex w-24 mt-1 mb-6 overflow-hidden rounded">
                            <div class="flex-1 h-2 bg-blue-200">
                            </div>
                            <div class="flex-1 h-2 bg-blue-400">
                            </div>
                            <div class="flex-1 h-2 bg-blue-600">
                            </div>
                        </div>
                    </div>
                    <p class="mb-16 text-base text-center text-gray-500">
                        Para el Cenidet, es de suma importancia contar con una plataforma que le
                        permita gestionar las Jornadas de Ciencia y Tecnología Aplicada que se
                        llevan a cabo dos veces al año.
                    </p>
                </div>
            </div>
            <div class="flex flex-col justify-center ">
                <div class="w-full px-4 mx-auto">
                    <div class="relative">
                        <div class="space-y-2 lg:space-y-4">
                            <div v-for="item in records" :key="item.id">
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center justify-start w-full mx-auto">
                                        <div class="w-full">
                                            <div
                                                class="relative flex-1 mb-10 bg-white rounded shadow lg:mb-8 dark:bg-gray-900">
                                                <div class="relative z-20 ">
                                                    <div class="flex flex-wrap items-center">
                                                        <div class="p-4 md:w-1/4 ">
                                                            <span class="text-lg text-gray-700 dark:text-gray-400">
                                                                {{
                                                                    convertTimeFormatMonth(item.created_at) }}
                                                            </span>
                                                            <p
                                                                class="text-2xl font-bold text-gray-700 dark:text-gray-400 text-bold">
                                                                    {{
                                                                        convertTimeFormatDay(item.created_at) }}</p>
                                                                <span class="text-lg text-gray-700 dark:text-gray-400">{{
                                                                    item.y_announcement }}</span>
                                                            </div>
                                                            <div
                                                                class="flex-1 p-4 pr-4 border-x border-gray-300 dark:border-gray-700">
                                                                                                    <p
                                                                                                        class="mb-2 text-xl font-bold text-gray-600 dark:text-gray-400">
                                                                                                        {{ item.name }}</p>
                                                                                                    <p class="text-gray-700 dark:text-gray-500">
                                                                                                        {{ item.description }}
                                                                                                    </p>
                                                                                                </div>
                                                                                                <div class="p-4 space-y-4 md:w-1/4 flex flex-col  ">

                                                                                                    <div
                                                                                                        v-if="getDate(item.calendars[0].date_start, item.calendars[0].date_end)">
                                                                                                    </div>
                                                                                                    <a v-if="getDate(item.calendars[1].date_start, item.calendars[1].date_end)"
                                                                                                        :href="route('proposals.show', item.id)" class="w-full">
                                                                                                        <PillTag color="success" label="Inscribirse"
                                                                                                            :small="pillsSmall" :outline="pillsOutline"
                                                                                                            :icon="pillsIcon" />
                                                                                                    </a>
                                                                                                    <a
                                                                                                        v-else-if="getDate(item.calendars[2].date_start, item.calendars[2].date_end)">
                                                                                                        <PillTag color="warning"
                                                                                                            label="Propuestas en evaluacion" :small="pillsSmall"
                                                                                                            :outline="pillsOutline" :icon="pillsIcon" />
                                                                                                    </a>
                                                                                                    <a v-else>
                                                                                                        <PillTag color="danger" label="Convocatoria Cerrada"
                                                                                                            :small="pillsSmall" :outline="pillsOutline"
                                                                                                            :icon="pillsIcon" />
                                                                                                    </a>
                                                                                                    <div @click="getPdf('advertising', item.name)">
                                                                                                        <PillTag color="info" label="Descargar"
                                                                                                            :small="pillsSmall" :outline="pillsOutline"
                                                                                                            :icon="pillsIcon" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        Right section -->
            <!--    <div>
                                                                                    <div class="flex flex-col items-center">
                                                                                        <div class="flex items-center justify-end w-full mx-auto">
                                                                                            <div class="w-full lg:w-1/2 lg:pl-8">
                                                                                                <div
                                                                                                    class="relative flex-1 mb-10 bg-white rounded shadow lg:mb-8 dark:bg-gray-900">
                                                                                                    <div
                                                                                                        class="absolute inline-block w-4 overflow-hidden -translate-y-1/2 top-7 -left-4">
                                                                                                        <div
                                                                                                            class="hidden h-10 origin-top-right transform -rotate-45 bg-white dark:bg-gray-900 lg:block drop-shadow-lg">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="relative z-20 ">
                                                                                                        <div class="flex flex-wrap items-center">
                                                                                                            <div class="p-4 md:w-1/4 ">
                                                                                                                <span
                                                                                                                    class="text-lg text-gray-700 dark:text-gray-400">April</span>
                                                                                                                <p
                                                                                                                    class="text-2xl font-bold text-gray-700 dark:text-gray-400 text-bold">
                                                                                                                    21</p>
                                                                                                                <span
                                                                                                                    class="text-lg text-gray-700 dark:text-gray-400">2022</span>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="flex-1 p-4 pr-4 border-l border-gray-300 dark:border-gray-700">
                                                                                                                <p
                                                                                                                    class="mb-2 text-xl font-bold text-gray-600 dark:text-gray-400">
                                                                                                                    Launch Project</p>
                                                                                                                <p class="text-gray-700 dark:text-gray-500">
                                                                                                                    Lorem ipsum dolor sit amet consectetur adipisicing
                                                                                                                    elit.
                                                                                                                    veniam libero facilis minus reprehenderit.
                                                                                                                </p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="absolute flex items-center justify-center w-8 h-8 transform -translate-x-1/2 -translate-y-4 bg-blue-500 rounded-full dark:bg-gray-700 left-1/2 lg:translate-y-[1px]">
                                                                                            <span class="text-gray-100 dark:text-gray-400">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                                                    fill="currentColor" class="w-4 h-4 bi bi-clock" viewBox="0 0 16 16">
                                                                                                    <path
                                                                                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z">
                                                                                                    </path>
                                                                                                </svg>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> 
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section> -->
        </div>

    </LayoutWelcome>
</template>
