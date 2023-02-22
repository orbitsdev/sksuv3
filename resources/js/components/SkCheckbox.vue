<template>
  <label>
    <input
      type="checkbox"
      :checked="checked"
      @change="toggle"
      class="h-4 w-4 accent-green-600 text-white rounded border-gray-200"
    />
    <slot></slot>
  </label>
</template>

<script>
export default {
  props: {
    value: {
      type: [String, Number, Boolean],
      required: true,
    },
    modelValue: {
      type: [String, Number, Boolean],
      required: true,
    },
  },
  computed: {
    checked() {
      return this.value === this.modelValue
    },
  },
  methods: {
    toggle() {
      this.$emit('update:modelValue', this.checked ? null : this.value)
    },
  },
}
</script>
