<template>
    <div class="flex items-center">
        <label :class="{ 'bg-green-400': checked, 'bg-gray-400': !checked }"
            class="relative inline-block w-10 h-6 rounded-full cursor-pointer transition-colors duration-300">
            <input type="checkbox" class="hidden" v-model="checked" @change="$emit('change', checked)">
            <span :class="{ 'translate-x-4': checked, 'translate-x-0': !checked }"
                class="absolute top-0 left-0 w-5 h-5 transition-transform duration-300 rounded-full bg-white shadow-sm transform"></span>
        </label>
        <span class="ml-2 text-gray-700 dark:text-white">{{ label }}</span>
    </div>
</template>
  
<script lang="ts">
export default {
    props: {
        value: {
            type: Boolean,
            default: false,
        },
        label: {
            type: String,
            default: '',
        },
    },
    data() {
        return {
            checked: this.value,
        };
    },
};
</script>
  