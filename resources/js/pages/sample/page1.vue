<script setup>
import { ref, defineProps, watch } from "vue";

// import { Inertia } from "@inertiajs/inertia";

import { router } from '@inertiajs/core';

const props = defineProps({
  users: Object,
  filters:Object
});


let search = ref(props.filters.search);

watch(search, (value) => {
  router.get(route('users'),{
    search:value
  },{
    preserveScroll:true,
    replace:true
  })
});
</script>

<template>
  <div class="px-6 lg:px-8">
    <input type="text" v-model="search" placeholder="seearch" class="mt-20 h-12 border w-full px-4"  />
    <ul>
      <li v-for="user in props.users.data">{{ user.first_name }} {{ user.email }}</li>
    </ul>
  </div>
</template>

<script>
import adminlayout from "../../layouts/adminlayout.vue";
export default {};
</script>

<style scoped></style>
