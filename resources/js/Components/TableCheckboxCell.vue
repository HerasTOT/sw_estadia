<script>
import { ref, watch } from "vue";

export default {
  props: {
    type: {
      type: String,
      default: "td",
    },
    value: {
      type: Boolean,
      default: false
    }
  },
  emits:['checked'],
  setup(props,ctx) {

    const checked = ref(props.value);

    watch(checked, (newVal) => {
      ctx.emit("checked", newVal);
    });
    return {checked}

  }
}


</script>

<template>
  <component :is="type" class="lg:w-1">
    <label class="checkbox">
      <input v-model="checked" type="checkbox" />
      <span class="check" />
    </label>
  </component>
</template>
