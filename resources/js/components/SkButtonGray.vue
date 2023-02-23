

<template>
          <button type="button" :disabled="disabled" :class="['inline-flex  justify-center rounded-md  px-4 py-2 font-medium shadow-sm text-sm', c, disabled ? 'bg-gray-59 text-gray-400 border' : ' text-gray-700 hover:bg-gray-50 border border-gray-300 bg-white ' ]"><slot> Click Me</slot></button>

</template>

<script>
    export default {
        props:{
            c: {
                type:String,
                default: ''
            },
            disabled: {
                type:Boolean,
                default: false
            }
        },

        
        

    }
</script>

<style lang="scss" scoped>

</style>