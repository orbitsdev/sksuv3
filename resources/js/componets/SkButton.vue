

<template>
    <button :disabled="processing" :class="['flex w-full justify-center rounded-md border border-transparent  py-2 px-4 text-sm font-medium text-white shadow-sm  focus:outline-none focus:ring-2 focus:green-500 focus:ring-offset-2', processing? 'sk-bg-green-disbaled ' :'sk-bg-green']">  <Loader1 v-if="processing"/> <slot></slot></button>

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