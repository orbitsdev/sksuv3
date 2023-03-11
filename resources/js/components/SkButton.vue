

<template>
    <button :disabled="processing" :class="['flex justify-center rounded-md border border-transparent  py-2 px-4 text-sm font-medium  shadow-sm  focus:outline-none focus:ring-2 focus:green-500 focus:ring-offset-2', c , processing? 'sk-bg-green-disbaled ' :'']">  <Loader1 v-if="processing"/> <slot></slot></button>

</template>

<script>
    export default {
        props: {
            processing: {
                type: Boolean,
                default: false
            },
            c: {
                type: [String, Array],
                default:'w-full sk-bg-green text-white'
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>