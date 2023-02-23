<script setup>
import { defineProps } from "vue";

const props = defineProps({
  c: {
    type: String,
    default: "whitespace-nowrap py-2 pl-4 pr-6 text-sm text-gray-500 sm:pr-0",
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
