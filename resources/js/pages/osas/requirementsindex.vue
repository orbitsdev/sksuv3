


<script setup>
import { ref, watch, defineProps, defineComponent } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

import UploadTemplate from "@/components/UploadTemplate.vue";

const props = defineProps({
  requirements: Object,
  filters: Object,
});

const search = ref(props.filters.search);
const show_form = ref(false);
const confirm_delete = ref(false);
const is_deleting = ref(false);
const selected_items = ref([]);
const selected_item = ref(null);
const has_warning = ref(null);
const is_updating = ref(false);

const form = useForm({
  name: "",
  temporary_uploaded_file: "",
  id: null,
  files: [],
});

defineComponent({
  UploadTemplate,
});

watch(
  search,
  throttle((value) => {
    router.get(
      route("requirement.index"),
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
  form.files = item.files;
}

function handleCloseForm() {
  form.files = [];
  show_form.value = false;
}

function deleteFile(file) {
  router.post(
    route("deleteTemplate"),
    { file_id: file.id },
    {
      onSuccess: () => {
        handleManageForm();
      },

      onStart: () => {
        is_updating.value = true;
      },

      onFinish: () => {
        handleManageForm();
      },
    }
  );
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

function updateRequirements() {
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
function handleManageForm() {
  is_updating.value = false;
  show_form.value = false;
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
      <div class="pt-4 flex items-center justify-between">
        <p class="text-xl text-green-800 font-bold font-rubik uppercase">
          Manage Requirements
        </p>
        <div class="flex items-center">
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

          <sk-button2
            @click="showForm"
            class="w-40 flex items-center justify-center h-10"
          >
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
            Add Requirement
          </sk-button2>
        </div>
      </div>
      <SkTable
        v-if="props.requirements.data.length > 0"
        :headers="['', 'Name', 'Template', '']"
      >
        <tr
          class="divide-x divide-gray-200"
          v-for="item in props.requirements.data"
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
          <Tcell class="uppercase"> {{ item.name }}</Tcell>
          <Tcell class=" whitespace-normal">
            <div v-if="item.files.length > 0">
              <div class="mb-1" v-for="file in item.files" :key="file" :file="file">
                <a
                  target="_blank"
                  :href="file.file_url"
                  class=" cursor-pointer bg-gray-300 hover:bg-blue-600 hover:text-white text-gray-800 py-2 px-4 rounded inline-flex items-center"
                >
                  <svg
                    class="fill-current w-4 h-4 mr-2"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                  </svg>
                  <span class="text-ellipsis"> {{ file.file_name }}</span>
                </a>
              </div>
            </div>
            <div v-else class="uppercase">None</div>
          </Tcell>

          <Tcell class="flex items-center justify-center">
            <SkButtonGray
              :disabled="selected_items.length > 0"
              class="max-w-40"
              @click="showUpdateForm(item)"
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
              <span class=""> Update </span>
            </SkButtonGray>
          </Tcell>
        </tr>
      </SkTable>

      <EmptyCard class="flex items-center justify-center h-64" v-else />

      <div class="mt-6 py-4 bg-white" v-if="$props.requirements.links.length > 0">
        <Pagination
          v-if="$props.requirements.data.length > 0"
          class="block"
          :links="$props.requirements.links"
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

        <div class="mb-2">
          <label for="email" class="block text-sm font-medium text-gray-700"
            >Requirement Name</label
          >

          <div class="mt-1">
            <Authfield1 type="email" v-model="form.name" />
            <!-- <input id="email" v-model="form.email" name="email" type="email" autocomplete="email"  class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"> -->
          </div>
          <p class="text-red-700 text-sm" v-if="$page.props.errors.name">
            {{ $page.props.errors.name }}
          </p>
        </div>

        <div v-if="form.files.length > 0">
          <div class="my=2">
            <div
              @click="deleteFile(file)"
              v-for="file in form.files"
              :key="file"
              class="hover:scale-105 transition-all cursor-pointer ease-in-out mb-2 center relative inline-block select-none whitespace-nowrap rounded-lg bg-gradient-to-tr from-gray-700 to-gray-800 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white"
              data-dismissible="chip"
            >
              <div class="mr-5 mt-px">{{ file.file_name }}</div>
              <div
                class="absolute top-1 right-1 mx-px mt-[0.5px] w-max rounded-md bg-rose-800 transition-colors hover:bg-rose-900"
                data-dismissible-target="chip"
              >
                <div role="button" class="h-5 w-5 p-1">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="3"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"
                    ></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- <span class="badge badge-primary" > {{ file.file_name }}  </span> -->
            <!-- <FileCard @click="deleteFile(file)" class="mt-1 mr-1">
                        {{ file.file_name }}</FileCard -->
          </div>
        </div>

        <div v-if="form.id != null">
          <label for="email" class="block text-sm font-medium text-gray-700"
            >Template</label
          >

          <div class="mt-1">
            <UploadTemplate
              @uploadSuccess="handleManageForm"
              @uploadStart="is_updating = true"
              @uploadFinish="handleManageForm"
              :model_id="form.id"
            />
          </div>
        </div>

        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
          <SkButtonGray @click="handleCloseForm"> Close </SkButtonGray>
          <SkButton
            v-if="form.id == null"
            @click="saveCampus"
            :processing="form.processing"
          >
            Save</SkButton
          >
          <SkButton v-else @click="updateRequirements" :processing="form.processing">
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
              Delete requirements
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

  <SkDialog :persistent="true" :isOpen="is_updating" :width="'260'">
    <div class="flex items-center justify-center">
      <w-progress
        :size="'24'"
        class="text-green-900 mr-8"
        color="green"
        circle
      ></w-progress>
      <p class="">Updating</p>
    </div>
  </SkDialog>
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
