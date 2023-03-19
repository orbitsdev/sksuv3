

<template>
   <div :class="['px-2 py-2 rounded inline-block text-', c]">
        <slot>
                    Waiting for review
        
        </slot>
   
    </div>
</template>

<script>
    export default {

        props: {
            c: {
                type:[String, Array],
                default: 'bg-blue-700 text-white'
            }
        }

    }
</script>

<style lang="scss" scoped>

</style>