

<template>
    <button class=" bg-rose-700 rounded py-1 text-sm text-white transition-all ease-in-out "> <slot></slot></button>

</template>

<script>
    export default {
        props: {
            c: {
                type:String,
                default: ' bg-white font-medium text-gray-700 shadow-sm hover:bg-gray-50 border-gray-300 '
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>