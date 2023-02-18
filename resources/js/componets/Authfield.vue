<template>
  <div class="relative">
    <input
      :type="showPassword? 'text' : 'password'"  
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      
      autocomplete="current-password"
      class="pr-8 block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm"
    />

    <div class="absolute top-2  right-3" @click="showPassword =!showPassword">
      <i :class="{ 'fa-regular fa-eye-slash': !showPassword, 'fa-regular fa-eye': showPassword }"></i>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            showPassword: false
        }
    },

  imits: ["showPassword"],
  props: {
    modelValue: {
      type: [String, Number],
      default: "",
    },

    show: {
      type: Boolean,
      default: true,
      required: false,
    },
  },
};
</script>

<style lang="scss" scoped></style>
