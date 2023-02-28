

<template>

 <Link  :class="['', active ? 'text-white text-sm mb-4  mr-2 inline-block font-medium rounded-md bg-white bg-opacity-10 px-3 py-2 hover:bg-opacity-10' :'text-cyan-100 text-sm font-medium rounded-md bg-white bg-opacity-0  px-3 py-2 hover:bg-opacity-10']" aria-current="page"><slot> Link </slot></Link>


</template>

<script>
import {Link} from '@inertiajs/vue3'
    export default {
        components: {
            Link
        }
    ,


        props: {
            active: {
                type: Boolean,
               
            },
        },

    }
</script>

<style lang="scss" scoped>

</style>