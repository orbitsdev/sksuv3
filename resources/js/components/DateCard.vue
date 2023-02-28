<script setup>
import moment from 'moment';

 function formatDate(dateString) {
      return moment(dateString).format('YYYY-MM-DD');
    }
</script>

<template>
        {{ formatDate(text) }}
</template>

<script>
    export default {
        props: {
            text: {
                type:String,
                default: '2023-02-28T02:36:41.000000Z'
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>