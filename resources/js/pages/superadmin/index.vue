<script setup>
import { ref, defineProps, watch } from "vue";

import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

let props = defineProps({
  users: Object,
  filters: Object,
});

const show_update_form = ref(false);
const is_updating = ref(false);
const selected_user = ref(null);
const show_confirmation = ref(false);
const has_warning = ref(null);
const search = ref(props.filters.search);

const selected_items = ref([]);

const form = useForm({
  role_id: null,
  user_id: null,
});

function getValueOfRole(item) {
  form.role_id = item;
}

function getDefaultValueOfRole(item) {
  if (item != null) {
    form.role_id = item;
  }
}
watch(
  search,
  throttle((value) => {
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

function showUpdateForm() {
  show_update_form.value = true;
}

async function updateRoles() {
  is_updating.value = true;
  router.post(
    route("superadmin.changeuserroles"),
    {
      role_id: form.role_id,
      user_ids: selected_items.value,
    },
    {
      preserveState: true,
      replace: true,

      onSuccess: () => {
        show_update_form.value = false;
        is_updating.value = false;

        form.reset();
        selected_items.value = [];
      },
      onFinish: () => {
        show_update_form.value = false;
        is_updating.value = false;
      },
    }
  );
}
</script>

<template>
  <adminlayout>
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
    <div
      class="bg-white rounded-xl shadow-xl mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8"
    >
      <div class="pt-4 flex items-center justify-end">
        <sk-button2
          v-if="selected_items.length > 0"
          @click="showUpdateForm"
          :c="'bg-white border '"
          class="w-40 flex items-center justify-center mr-2 h-10"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-6 h-6 mr-2"
          >
            <path
              d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z"
            />
            <path
              d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
            />
          </svg>

          Change Role



        </sk-button2>
      </div>

      <SkTable :headers="['Name', 'Email', 'Role']">
        <tr class="divide-x divide-gray-200" v-for="item in props.users.data" :key="item">
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
          <Tcell class="uppercase"> {{ item.first_name }} - {{ item.last_name }}</Tcell>
          <Tcell> {{ item.email }} </Tcell>
          <Tcell>
            <div v-if="item.roles.length > 0">
              {{ item.roles[0].name }}
            </div>
          </Tcell>
          <!-- <Tcell class="flex items-center justify-center">
            <SkButtonGray class="max-w-40" @click="showUpdateForm(item)">
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
              <span class=""> Make this user as Osas </span>
            </SkButtonGray>
          </Tcell> -->
        </tr>
      </SkTable>
      <div class="mt-6 py-4 bg-white" v-if="$props.users.links.length > 0">
        <Pagination
          v-if="$props.users.data.length > 0"
          class="block"
          :links="$props.users.links"
        />
      </div>
    </div>
  </adminlayout>

  <sk-dialog :transition="'slide-down'" :persistent="true" :isOpen="show_update_form">
    <template #default>
      <main class="p-2">
        <SelectRoles
          @selectItem="getValueOfRole"
          @setDefaultValue="getDefaultValueOfRole"
        />

        <div class="sm:flex sm:items-start">
          <div class="mt-5 w-full flex justify-end sm:flex-row-reverse">
            <SkButton @click="updateRoles" :processing="is_updating" class="w-24">
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
</template>

<script>
import adminlayout from "../../layouts/adminlayout.vue";
import SelectRoles from "@/components/SelectRoles.vue";
export default {
  components: {
    adminlayout,
    SelectRoles,
  },
};
</script>
