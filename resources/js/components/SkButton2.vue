

<template>
    <button :class=" ['rounded py-1 text-sm   transition-all ease-in-out', c] "> <slot></slot></button>

</template>

<script>
    export default {
        
        props: {
        c: {
            typpe:String,
            default: 'sk-button2 text-white'
        },
        processing: {
                type: Boolean,
                default: false
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>