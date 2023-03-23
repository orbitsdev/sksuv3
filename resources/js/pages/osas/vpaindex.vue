<script setup>
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  vpas: Object,
  filters: Object,
});

const search = ref(props.filters.search);
const show_form = ref(false);
const confirm_delete = ref(false);
const is_deleting = ref(false);
const selected_items = ref([]);
const selected_item = ref(null);
const has_warning = ref(null);


const form = useForm({
  
  user_id: null,
  id: null,
});



function getValueOfUser(item) {


  form.user_id = item;
}

function getDefaultValueOfUser(item) {

 if (item != null) {

    form.user_id = item;
  }
}



async function deleteSelected(){





  selected_item.value = null;
  is_deleting.value = true;



  try {
    const response = await router.post(route('vpa.deleteselected'), {
      ids: selected_items.value,
    });



    confirm_delete.value = false;
    selected_items.value = [];
  } catch (error) {
    has_warning.value = error.message;
  } finally {
    is_deleting.value = false;
  }


}



watch(
  search,
  throttle((value) => {
    router.get(
      route("vpa.index"),
      { search: value },
      {
        preserveState: true,
        replace: true,
      }
    );
  }, 500)
);



function showForm() {

form.reset();
show_form.value = true;

}


function save() {




  form.post(route("vpa.create"), {
    preserveState: true,
    onSuccess: () => {
    show_form.value = false;
    form.reset();
    },
    onError: (error) => {
      has_warning.value = error;
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
            placeholder="Name, Campus, Shool Year"
            type="search"
            name="search"
          />
        </div>
      </div>
    </template>

    <div class="flex items-center  justify-end">
      <div class="flex items-center ">
        <sk-button2
          v-if="selected_items.length > 0"
          @click="confirm_delete = true"
          :c="'bg-white border '"
          class="w-40 flex items-center justify-center mr-2 h-10"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-5 h-5 mr-2 text-rose-700"
          >
            <path
              fill-rule="evenodd"
              d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
              clip-rule="evenodd"
            />
          </svg>
          Delete Selected
        </sk-button2>

        <sk-button2 @click="showForm" class="min-w-40 px-4 flex items-center justify-center h-10">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-5 h-5 mr-2"
          >
            <path
              fill-rule="evenodd"
              d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
              clip-rule="evenodd"
            />
          </svg>
          Add Vpa
        </sk-button2>
      </div>
    </div>


    <SkTable 
    v-if="props.vpas.data.length > 0"

    :headers="['', 'Name', '' ]"> 
     <tr
          class="divide-x divide-gray-200"
          v-for="item in props.vpas.data"
          :key="item"
        >
         
            <Tcell
              :c="'whitespace-nowrap align-center text-center text-sm items-center  font-medium text-gray-900'"
            >
              <input
                v-model="selected_items"
                :value="item.id"
                type="checkbox"
                class="h-4 w-4 accent-green-600 text-white rounded border-gray-200"
              />
            </Tcell>
            

          <Tcell class="uppercase" v-if="item.user != null"> {{ item.user.first_name }} - {{ item.user.last_name }} </Tcell>
          <Tcell>     </Tcell> 
    
        
        </tr>
    </SkTable>

      <EmptyCard   v-else class="flex items-center justify-center h-64" />

        <div class="mt-6 py-4 bg-white" v-if="$props.vpas.links.length > 0">
          <Pagination
            v-if="$props.vpas.data.length > 0"
            class="block"
            :links="$props.vpas.links"
          />
        </div>

    <sk-dialog :transition="'slide-down'" :persistent="true" :isOpen="show_form">
      <main class="p-2">
      
        
       
         <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700"
            > User </label
          >

          <div class="mt-1">
            <guestUserSelect  @selectItem="getValueOfUser" @setDefaultValue="getDefaultValueOfUser"/>
         
          </div>
        </div>
        
        

        
        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
          <SkButtonGray @click="show_form = false"> Close </SkButtonGray>
          <div>
          <SkButton v-if="( form.user_id != null )" @click="save"  :processing="form.processing">  Save</SkButton>
          </div>
        </div>
      </main>
    </sk-dialog>

    
    <sk-dialog :transition="'slide-down'" :persistent="true" :isOpen="confirm_delete">
      <main class="p-2">
        <div class="sm:flex sm:items-start">
          <div
            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
          >
            <svg
              class="h-6 w-6 text-red-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
              />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
              Delete campus Director/s 
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                Are you sure you want to delete Directors/es ? All of your data will be
                permanently removed from our servers forever. This action cannot be
                undone.
              </p>
            </div>
          </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <SkDeleteButton @click="deleteSelected" :processing="is_deleting" class="w-24">
           Yes
          </SkDeleteButton>
          <SkButtonGray @click="confirm_delete = false" :c="'w-24'">
            No
          </SkButtonGray>
        </div>
      </main>
    </sk-dialog> 
  </accounts>
</template>

<script>
import accounts from "@/pages/osas/accounts.vue";
import guestUserSelect from "@/components/guestUserSelect.vue";

export default {
  components: {
    accounts,
    
     
     guestUserSelect,
     
  },
};
</script>
