<script setup>

import { ref, defineProps, watch } from "vue";

import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";


 let props = defineProps({
    users: Object,
    filters: Object
});

const show_update_form = ref(true);
const is_updating = ref(false);
const selected_user = ref(null);
const show_confirmation = ref(false);
const has_warning = ref(null);
const search = ref(props.filters.search);
watch(
  search,throttle((value) => {
    router.get(
      route("account.userpassword.index"),
      { search: value },
      {
        preserveState: true,
        replace: true,
      }
    );
  }, 500)
);

let form = useForm({
    password: '',
    id: selected_user.value,
});




function showUpdateForm(item){
    selected_user.value = item;

    show_update_form.value = true;
}

function updateUserPassword(){

    
     form.transform((data) => {
      return {
         password: form.password,
        id: selected_user.value.id
      };
    }).post(route('account.userpassword.update'), {
      preserveState: true,
      onSuccess: () => {
        show_confirmation.value = false;
        show_update_form.value = false;
      form.reset()
      },
      onError: (error) => {
        has_warning.value = error;
         console.log('on error');

         show_confirmation.value = false;
      },
      hasError: (err) => {
          
          console.log('has warnung error');
          show_confirmation.value = false;

         has_warning.value = err;
      },
    });

}




</script>


<template>
<accounts>
 <template v-slot:search>
      <div class="mx-auto w-full max-w-xs lg:max-w-md">
        <label for="search" class="sr-only">Search</label>
        <div class="relative text-white focus-within:text-gray-600">
          <div
            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
          >
            <svg
              class="h-5 w-5"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                clip-rule="evenodd"
              />
            </svg>
          </div>
          <input
            v-model.number="search"
            class="block w-full rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm"
            placeholder="Name, Email"
            type="search"
            name="search"
          />
        </div>
      </div>
    </template>

    <template #default>
        <SkTable :headers="['Name','Email', 'Campus','Password', '']">
         <tr   class="divide-x divide-gray-200" v-for="item in props.users.data" :key="item">
              <Tcell  class="uppercase min-w-40"> {{ item.first_name }} - {{ item.last_name }}</Tcell>
              <Tcell> {{ item.email }}  </Tcell>
              <Tcell class="uppercase"> {{ item.campus_director != null ?  item.campus_director.campus.name  : '' }} </Tcell>
              <Tcell> {{ item.password }}</Tcell>
               <Tcell class="flex items-center justify-center" > <SkButtonGray class="max-w-40" @click="showUpdateForm(item)"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5  mr-2">
  <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
  <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
</svg>
    <span class=""> 
 Update
    </span>
 </SkButtonGray> </Tcell> 
              </tr>
        </SkTable>
        <div class="mt-6 py-4 bg-white" v-if="$props.users.links.length > 0">
          <Pagination
            v-if="$props.users.data.length > 0"
            class="block"
            :links="$props.users.links"
          />
        </div>
    </template>






</accounts>


<sk-dialog v-if="selected_user != null" :transition="'slide-down'" :persistent="true" :isOpen="show_update_form">
      
      <template #default>
      
      <main class="p-2">


 <aside class="rounded-lg flex item-center ">
            <div
              class="rounded-l flex items-center justify-center w-36 bg-gradient-to-r from-red-500 to-red-600 "
            >
              <i class="fa-solid fa-triangle-exclamation text-4xl text-white"></i>
            </div>
            <div
              class="rounded-r bg-gradient-to-r from-red-500 to-red-600 px-4 py-4"
            >
              <p class="font-rubik text leading-5 text-white">
               We recommend changing the password only if the user is unable to access their account or has forgotten their password.
              </p>
            </div>
            </aside>


<figcaption class="mb-4 mt-4 bg-green-700 text-white px-4 py-2 rounded flex items-center ">
      <div class="text-sm leading-6">
      <p class="  text-sm "> Selected Account </p>
        <div class="font-semibold uppercase">  {{ selected_user.first_name }} - {{ selected_user.last_name }} </div>
      </div>
 </figcaption>
       
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700"
              >Password</label
            >
            <div class="mt-1">
              <Authfield v-model="form.password" />
        
            </div>
            <p class="text-red-700 text-sm" v-if="$page.props.errors.password">
              {{ $page.props.errors.password }}
            </p>
          </div>

     
        <div class="sm:flex sm:items-start">
      
         <div class="mt-5  w-full  flex justify-end sm:flex-row-reverse">
          <SkButton @click="show_confirmation = true" :processing="false" class="w-24 ">
            Update
          </SkButton>
          <SkButtonGray @click="show_update_form = false" :c="'w-24 mr-2'">
            Cancel
          </SkButtonGray>
          </div>
        </div> 
      </main>
      </template>
    </sk-dialog> 


     <sk-dialog  v-if="selected_user != null " :transition="'slide-down'" :persistent="true" :isOpen="show_confirmation">
      <main class="p-2">
     <div>
          <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-5">
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Are you sure?</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Do you wan to update user password</p>
            </div>
          </div>
        </div>

        
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <SkDeleteButton @click="updateUserPassword" :processing="form.processing" class="w-24">
           Yes
          </SkDeleteButton>
          <SkButtonGray @click="show_confirmation = false" :c="'w-24'">
            No
          </SkButtonGray>
        </div>
      </main>
      
    </sk-dialog>
</template>

<script>

import accounts from '@/pages/osas/accounts.vue';

export default {
    components: {
        accounts
    }
}

</script>