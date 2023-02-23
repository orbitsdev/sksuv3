

<template>
<accounts>

    <template #default>
            <SkTable :headers="['', 'Name', ,'School Year', 'Campus', '' ]">
            
            </SkTable>
    </template>
</accounts>
</template>

<script>

import accounts from '@/pages/osas/accounts.vue';

export default {
    components: {
        accounts
    }
}

</script>