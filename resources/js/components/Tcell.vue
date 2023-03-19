


<script setup>
import { defineProps } from "vue";

const props = defineProps({
  c: {
    type: String,
    default: "whitespace-nowrap  text-sm text-gray-500 p-2 ",
  },
});
</script>

<template>
  <td :class="c">
    <slot></slot>
  </td>
</template>

<script>
export default {
};
</script>

<style lang="scss" scoped></style>
