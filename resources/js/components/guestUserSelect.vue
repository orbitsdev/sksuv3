<script setup>
import { ref, onMounted, defineEmits  } from "vue";

import { router } from '@inertiajs/vue3'
import axios from  'axios';
const items = ref([]);
const emit = defineEmits(['selectItem', 'setDefaultValue']);


onMounted(async () => {
  const { data } = await axios.get(route('public.guestusers'));


    if(data.data.length > 0){
      items.value = data.data;
      emit('setDefaultValue', items.value[0].id);

    }
    


});

  function handleChange(event) {
    //   console.log(event.target.value); // Selected value
    // //   console.log(event);


      emit('selectItem',parseInt(event.target.value))
    }

</script>

<template>
  <select
    v-if="items.length > 0"
    @change="handleChange($event)"
    
    autocomplete="country-name"
    class="block w-full max-w-lg h-10 px-2 rounded-md border shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
  >
    <option v-for="item in items" :key="item.id" :value="item.id" > {{ item.first_name }} - {{ item.last_name }}</option>
  </select>
  <div v-else class="p-2 rounded  bg-rose-600 animate-pulse  text-white"> Empty</div>
</template>

<script>
export default {

};
</script>