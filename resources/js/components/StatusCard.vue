

<template>
   <div :class="['px-2 py-0.5 rounded inline-block text-xs',c]">
        <slot>
                    Waiting for review
        
        </slot>
   
    </div>
</template>

<script>
    export default {

        props: {
            c: {
                type:String,
                default: 'bg-blue-700 text-white'
            }
        }

    }
</script>

<style lang="scss" scoped>

</style>