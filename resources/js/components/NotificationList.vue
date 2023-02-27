






<script setup>
import {defineProps} from 'vue';
import { ref, onMounted, defineEmits  } from "vue";
import { router } from '@inertiajs/vue3'
import axios from  'axios';

import moment from 'moment';

const notifcation = ref([]);



onMounted(async () => {
  const { data } = await axios.get(route('nottification.index'));
    console.log(data.data);

    if(data.data.length > 0){
      notifcation.value = data.data;
    }
    


});

 function formatDate(dateString) {
      return moment(dateString).format('YYYY-MM-DD');
    }

</script>


<template>
<div>
 <li v-for="item in notifcation" :key="item" class="cursor-pointer flex py-4 z-0 hover:bg-gray-50">
       
         <div class="ml-3 ">
            <div class="border-b mb-1  flex items-center justify-between  ">
            <p class="text-sm font-medium inline-block  text-gray-900 capitalize mr-2"> {{ item.user_sender.first_name }}  {{ item.user_sender.last_name }}</p>
              <p class="text-xs inline-block ">
                    <time datetime="2020-01-07  ">{{ formatDate(item.created_at )}}</time>
            </p>
            </div>
            <!-- <p :class="['text-sm font-medium   inline-block px-2 roundedd text-white rounded', data.status == 'denied' ? 'bg-red-400': 'bg-green-400' ]"  > {{  }}  </p>
            <p :class="['text-sm font-medium   inline-block px-2 roundedd text-white rounded', data.status == 'denied' ? 'bg-red-400': 'bg-green-400' ]"  > {{  }}  </p> -->
             <p :class="['text-sm font-medium   inline-block px-2 roundedd text-white rounded capitalize', item.approved_status  === 'approved' ? 'bg-green-400' : 'bg-red-400' ]" > {{ item.approved_status }} </p>
            <p class="text-sm text-gray-500 whitespace-normal mt-1">

            {{ item.body }}
            </p>
          </div>
        </li>
</div>
</template>

<script>
  
</script>

<style lang="scss" scoped>

</style>