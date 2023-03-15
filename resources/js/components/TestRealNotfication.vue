







<script setup>
import { ref, onMounted, onUnmounted , defineProps} from 'vue'

const props = defineProps({
    notfications: {
        type: Object,
    }
})



</script>


<template>
    <div>
                {{ notfications }}
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>