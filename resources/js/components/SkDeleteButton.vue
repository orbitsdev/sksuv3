

<template>

          <button type="button" :disabled="processing"  @click="confirm_delete = false" :class="['inline-flex  justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 ', processing? 'bg-red-200' : '' ]">  <Loader1 v-if="processing"/> <slot></slot></button>


</template>

<script>
    export default {
        props: {
            processing: {
                type: Boolean,
                default: false
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>