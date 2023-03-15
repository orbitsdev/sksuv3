<script setup>
import { defineProps } from "vue";
import { ref, onMounted, defineEmits } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

import moment from "moment";

const notifications = ref([]);
const is_loading = ref(false);

onMounted(async () => {
  is_loading.value = true;
  const { data } = await axios.get(route("nottification.index"));
  is_loading.value = false;
  console.log(data.data);

  if (data.data.length > 0) {
    notifications.value = data.data;
  }


  // router.get(route('refresh'),{
  // preserveState: true,
  // preserveScroll: true,
  // });
  
});

function formatDate(dateString) {
  return moment(dateString).format("YYYY-MM-DD");
}
</script>

<template>
  <div class="max-h-n">



  <!-- {{ data }} -->
    <p class="px-4 py-3 border-b font-medium">Notifications</p>


    <div class="h-40 flex items-center justify-center" v-if="is_loading">
      <w-progress
        :size="'24'"
        class="text-green-900 "
        color="green"
        circle
      ></w-progress>
    </div>
   

    <!-- <li v-for="item in notifications" :key="item" class="cursor-pointer flex py-4 z-0 hover:bg-gray-50">
       
         <div class="ml-3 ">
            <div class="border-b mb-1  flex items-center justify-between  ">
            <p class="text-sm font-medium inline-block  text-gray-900 capitalize mr-2"> {{ item.user_sender.first_name }}  {{ item.user_sender.last_name }}</p>
              <p class="text-xs inline-block ">
                    <time datetime="2020-01-07  ">{{ formatDate(item.created_at )}}</time>
            </p>
            </div>
        
             <p :class="['text-sm font-medium   inline-block px-2 roundedd text-white rounded capitalize', item.approved_status  === 'approved' ? 'bg-green-400' : 'bg-red-400' ]" > {{ item.approved_status }} </p>
            <p class="text-sm text-gray-500 whitespace-normal mt-1">

            {{ item.body }}
            </p>
          </div>
        </li> -->
    <!-- {{ notifications  }} -->
    <div v-else>
    
    <div class="px-4 cursor-pointer hover:bg-gray-50 border-b" v-for="item in notifications" :key="item" >
  
      <div class="flex center justify-between pt-2">
        <p class="text-xs  text-gray-900  uppercase font-medium ">{{ item.data.sender }}</p>
        <p class="text-xs text-gray-600 capitalize"> {{ formatDate(item.created_at )}}</p>
      </div>
    <p v-if="item.data.status == 'approved' || item.data.status == 'denied' " :class="['rounded-md text-green-600 font-bold  inline-block   text-xs  uppercase' , item.data.status == 'approved' ?  'text-green-600': 'text-red-400'  ]">{{ item.data.status }}</p>
      <div class="">
      <div class="flex items-center  ">
      </div>
        <p class="whitespace-normal text-sm py-1  text-gray-600">
          {{ item.data.body }}
        </p>
      </div>
    </div>
    </div>
    
  </div>
</template>

<script>



</script>

<style  scoped>


  .max-h-n{
        max-height: 500px;
        overflow-y: auto;
  }


  .max-h-n {
    scrollbar-width: auto;
    scrollbar-color: #d2d2d4 #ffffff;
  }
  
  .max-h-n::-webkit-scrollbar {
    width: 12px;
    height: 200px !important;
  }
  
  .max-h-n::-webkit-scrollbar-track {
    background: #ffffff;
  }
  
  .max-h-n::-webkit-scrollbar-thumb {
    background-color: #dedee4;
    border-radius: 10px;
    border: 3px solid #ffffff;
  }
</style>
