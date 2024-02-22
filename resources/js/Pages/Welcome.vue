<script>
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




export default {
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
    data(){
        return{
        totalrecursamientos: 0,
      selectedRecursamiento: {},
    }
}, methods: {
    mostrar(recursamientos) {
      Swal.fire({
        html: `
          <div class="promotion-modal">
            <h2 class="modal-title">${recursamientos}</h2>
          </div>
        `,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Regresar",
        customClass: {
          popup: 'custom-popup-class',
        },
      }).then((res) => {
        if (!res.isConfirmed) {
          this.$router.push('/welcome');
        }
      });
    },
    openModal(recursamientos) {
      this.selectedRecursamiento = { ...recursamientos };
      this.selectedRecursamiento.showModal = true;
      this.mostrar(recursamientos);
    },
    closeModal() {
      this.selectedRecursamiento.showModal = false;
    },
    updateTotalEvents() {
      if (this.recursamientos) {
        this.totalrecursamientos = Object.keys(this.recursamientos).length;
      }
    },
  },
  async onMounted() {
    console.log(this.recursamientos, this.routeName);
    this.updateTotalEvents();
  },
  watch: {
    recursamientos: {
      handler() {
        console.log(this.recursamientos, this.routeName);
        try {
          this.updateTotalEvents();
        } catch (error) {
          console.error('Error en watchEffect:', error);
        }
      },
      immediate: true,
    },
  },
};


</script>

<template>
    
    <LayoutWelcome>

        <div v-for="recursamiento in recursamientos" :key="recursamiento.id"
        class="max-w-full p-10 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        {{ recursamiento }}
      </div>

        <div class="py-12">

            <div class=" max-w-full mx-auto sm:px-6 lg:px-8">
              <div class="  bg-white dark:bg-gray-700 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid gap-8  ml-4 mt-4 md:mb-4 md:grid-cols-5">
                  <div v-for="recursamiento in recursamientos" :key="recursamiento.id"
                    class="max-w-full p-10 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a :href="recursamiento.materia">
                     
                    </a>
                    <a :href="recursamiento.periodo">
                     
                    </a>
                 
                  </div>
                </div>
              </div>
            </div>
          </div>

    </LayoutWelcome>
   
</template>
