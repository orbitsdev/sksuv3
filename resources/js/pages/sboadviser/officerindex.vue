<script setup>
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  campuses: Object,
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
  name: "",
  id: null,
});

watch(
  search,
  throttle((value) => {
    router.get(
      route("officers.index"),
      { search: value },
      {
        preserveState: true,
        replace: true,
      }
    );
  }, 500)
);

function showForm() {
  //   form.school_year_id = null;
  form.name = "";
  selected_item.value = null;
  form.id = null;
  show_form.value = true;
}

function showUpdateForm(item) {
  // selected_item.value = item;
  form.name = item.name;
  form.id = item.id;
  show_form.value = true;
}

function saveCampus() {
  form.post(route("requirement.create"), {
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

function updateCampus() {
  form.post(route("requirement.update"), {
    preserveState: true,
    onSuccess: () => {
      form.id = null;
      show_form.value = false;
      form.reset();
    },
    onError: (error) => {
      has_warning.value = error;
    },
  });
}

async function deleteSelected() {
  selected_item.value = null;
  is_deleting.value = true;

  try {
    const response = await router.post(route("requirement.deleteselected"), {
      ids: selected_items.value,
    });

    form.name = "";
    confirm_delete.value = false;
    selected_items.value = [];
  } catch (error) {
    has_warning.value = error.message;
  } finally {
    is_deleting.value = false;
  }
}

function getValue(item) {
  form.school_year_id = parseInt(item);
}

function getDefaultValue(item) {
  if (item != null) {
    form.school_year_id = parseInt(item);
  }
}
</script>
<template>
  <adminlayout>
    <template #search>
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
                fill-rule="eveanodd"
                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                clip-rule="evenodd"
              />
            </svg>
          </div>
          <input
            v-model.number="search"
            class="block w-full rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm"
            placeholder="Name "
            type="search"
            name="search"
          />
        </div>
      </div>
    </template>

    <div
      class="bg-white rounded-xl shadow-xl mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8"
    >

    <div class="flex items-center justify-between pt-4">
      <TableTitle class=""> Campuses </TableTitle>
        
    </div>
      

      <SkTable
        v-if="props.campuses.data.length > 0"
        :headers="['Name', 'Officers', '']"
      >
        <tr
          class="divide-x divide-gray-200"
          v-for="item in props.campuses.data"
          :key="item"
        >
         
          <Tcell class="uppercase align-top pt-2"> {{ item.name }}</Tcell>
          <Tcell class="align-top pt-2">

            {{ item.campus_advisers }}
            <div class="pr-4" v-if="item.campus_adviser != null">
            <div v-if="item.campus_adviser.officers.length > 0">
              <div class="border-b mb-1" v-for="i in item.campus_adviser.officers" :key="i">
              <p class="truncate text-xs font-medium text-indigo-600 capitalize"> {{ i.position }}</p>
              <dd class="text-sm text-gray-900 capitalize ">{{ i.user.first_name }} {{ i.user.last_name }}</dd>
            </div>
            </div>
 
           
            </div>
          </Tcell>

          <Tcell class="flex align-top pt-2 items-center justify-center">
            <Link :href="route('officers.manageindex', {campus: item.id})"
              :disabled="selected_items.length > 0"
              class="max-w-40 inline-flex  justify-center rounded-md  px-4 py-2 font-medium shadow-sm text-sm"
             
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-5 h-5 mr-2"
              >
                <path
                  d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z"
                />
                <path
                  d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
                />
              </svg>
              <span class=""> Manage Officer </span>
            </Link>
          </Tcell>
        </tr>
      </SkTable>

      <EmptyCard class="flex items-center justify-center h-64" v-else />

      <div class="mt-6 py-4 bg-white" v-if="$props.campuses.links.length > 0">
        <Pagination
          v-if="$props.campuses.data.length > 0"
          class="block"
          :links="$props.campuses.links"
        />
      </div>
    </div>

    <sk-dialog :transition="'slide-down'" :persistent="true" :isOpen="show_form">
      <main class="p-2">
        <!-- <div class="mb-2">
          <label for="email" class="block text-sm font-medium text-gray-700"
            >School Year</label
          >

          <div class="mt-1">
            <schoolYearSelect @selectItem="getValue" @setDefaultValue="getDefaultValue" />
         
          </div>
        </div> -->

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700"
            >Requirement Name</label
          >

          <div class="mt-1">
            <Authfield1 type="email" autocomplete="email" v-model="form.name" />
            <!-- <input id="email" v-model="form.email" name="email" type="email" autocomplete="email"  class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"> -->
          </div>
          <p class="text-red-700 text-sm" v-if="$page.props.errors.name">
            {{ $page.props.errors.name }}
          </p>
        </div>

        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
          <SkButtonGray @click="show_form = false"> Close </SkButtonGray>
          <SkButton
            v-if="form.id == null"
            @click="saveCampus"
            :processing="form.processing"
          >
            Save</SkButton
          >
          <SkButton v-else @click="updateCampus" :processing="form.processing">
            Update</SkButton
          >
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
              Delete campuses
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                Are you sure you want to delete campus/es ? All of your data will be
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
          <SkButtonGray @click="confirm_delete = false" :c="'w-24'"> No </SkButtonGray>
        </div>
      </main>
    </sk-dialog>
  </adminlayout>
</template>

<script>
import campusandorganization from "@/pages/osas/campusandorganization.vue";

import adminlayout from "../../layouts/adminlayout.vue";
import schoolYearSelect from "@/components/schoolYearSelect.vue";

export default {
  components: {
    schoolYearSelect,
    adminlayout,
  },
};
</script>
