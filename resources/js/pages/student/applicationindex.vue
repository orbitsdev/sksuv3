<script setup>
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  organizations: Object,
  filters: Object,
});

const search = ref("");
const show_form = ref(false);
const show_manage_form = ref(false);
const confirm_delete = ref(false);
const is_deleting = ref(false);
const is_updating = ref(false);
const selected_items = ref([]);
const selected_item = ref(null);
const has_warning = ref(null);

const form = useForm({
  name: "",
  campus_adviser_id: null,
  id: null,
});

watch(
  search,
  throttle((value) => {
    router.get(
      route("application.index"),
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

function save() {
  form.post(route("application.create"), {
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

function update() {
  form.post(route("application.update"), {
    preserveState: true,
    onSuccess: () => {
      form.id = null;
      show_form.value = false;
      form.reset();
    },
    onFinish: (error) => {
      handleManageForm();
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
    const response = await router.post(route("application.deleteselected"), {
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
  form.campus_adviser_id = parseInt(item);
}

function getDefaultValue(item) {
  if (item != null) {
    form.campus_adviser_id = parseInt(item);
  }
}

function showManageForm(item) {
  show_manage_form.value = true;
  selected_item.value = item;
  form.name = item.name;
  form.id = item.id;
}

function deleteFile(file) {
  router.post(
    route("application.deletefile"),
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

function handleManageForm() {
  is_updating.value = false;
  show_manage_form.value = false;
}

function openUrl(url){
  window.open(url);
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
          Applied Organizations
        </p>
        <div class="flex items-center">
          <sk-button2
            v-if="selected_items.length > 0"
            @click="confirm_delete = true"
            :c="'bg-white border'"
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
              class="w-4 h-4 mr-2"
            >
              <path
                fill-rule="evenodd"
                d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"
                clip-rule="evenodd"
              />
              <path
                d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"
              />
            </svg>

            Apply Application
          </sk-button2>
        </div>
      </div>
      <SkTable
        v-if="props.organizations.data.length > 0"
        :headers="[
          '',
          'Organization Name',
          'Campus Adviser ',
          ' School Year',
          ' Requirements &  attachment',
          ' Application Process Status',

          '',
        ]"
      >
        <tr
          class="divide-x divide-gray-200"
          v-for="item in props.organizations.data"
          :key="item"
        >
          <Tcell
            :c="'whitespace-nowrap align-center text-center text-sm items-center  font-medium text-gray-900 align-top pt-2'"
          >
            <input
              v-model="selected_items"
              :value="item.id"
              type="checkbox"
              class="h-4 w-4 accent-green-600 text-white rounded border-gray-200"
            />
          </Tcell>
          <Tcell class="uppercase align-top pt-2"> {{ item.name }} </Tcell>
          <Tcell class="uppercase align-top pt-2 "> {{ item.campus_adviser.user.first_name }} {{ item.campus_adviser.user.last_name }} </Tcell>
          <Tcell class="uppercase align-top pt-2">     {{  item.campus_adviser.school_year != null ? 'SY.' +  item.campus_adviser.school_year.from + ' - ' + item.campus_adviser.school_year.to  : 'None'}} </Tcell> 

          <Tcell class="align-top pt-2 whitespace-normal">
            <div>
              <p class="truncate text-sm font-medium text-gray-900">Requirements</p>

              <div class="mt-1" v-if="item.organization_requirements.length > 0">
         
                <aside
                  class="my-1 mb-2"
                  v-for="og in item.organization_requirements"
                  :key="og"
                >
                  <div v-if="og.file.length > 0">
                    <div class="my=2">
                      <FileViewLink
                        :href="file.file_url"
                     
                        class="mb-1"
                        v-for="file in og.file"
                        :key="file"
                        :file="file"
                      >
                        {{ file.file_name }}
                      </FileViewLink>

                      <!-- <button
                        v-for="file in og.file"
                        :key="file"
                        :file="file"

                        @click="openUrl(file.file_url)"
                       class="p-1 border" >

                        {{ file.file_name }}
                      </button> -->
                    </div>
                  </div>
                </aside>

  

              </div>
            </div>
          </Tcell>
          <Tcell class="align-top pt-2">
            <div class="mb-1 border py-2 px-2 mr-4 rounded">
              <p class="truncate text-sm t text-gray-900 uppercase">SBO ADVISER</p>
              <div class="px-2">
                <div class="mb-0.5">
                  <status-card
                    v-if="
                      item.organization_process.campus_adviser_approved_status ===
                      'waiting for review'
                    "
          :c="'cursor-pointer bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 text-white'"
                    class="inline-flex items-center"
                  >
                    <timeSvg />

                    {{ item.organization_process.campus_adviser_approved_status }}
                  </status-card>
                </div>
                <div class="mb-0.5">
                  <status-card
                    v-if="
                      item.organization_process.campus_adviser_approved_status ===
                      'approved'
                    "
                              :c="'cursor-pointer bg-gradient-to-r from-green-700 via-green-600 to-green-500 text-white'"
                    class="inline-flex items-center"
                  >
                    <approveSvg />

                    {{ item.organization_process.campus_adviser_approved_status }}
                  </status-card>
                </div>

                <div class="mb-0.5">
                  <status-card
                    v-if="
                      item.organization_process.campus_adviser_approved_status ===
                      'denied'
                    "
                                     :c="'cursor-pointer bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white'"
                    class="inline-flex items-center"
                  >
                    <deniedSvg />

                    Denied
                  </status-card>
                </div>

                <!-- <div class="mb-0.5">
                  <status-card
                    :c="[
                      item.organization_process.campus_adviser_endorsed_status === 'true'
                        ? 'bg-green-100 text-green-600'
                        : 'bg-gray-50 text-gray-400',
                    ]"
                    class="inline-flex items-center"
                  >
                    <checkedSvg />

                    {{
                      item.organization_process.campus_adviser_endorsed_status === "true"
                        ? "Endorsed"
                        : "Not endorsed yet"
                    }}
                  </status-card>
                </div> -->
              </div>
            </div>
            <div class="mb-1 border py-2 px-2 mr-4 rounded">
              <p class="truncate text-sm t text-gray-900 uppercase">Campus Director</p>

              <div class="px-2">
                <div class="mb-0.5">
                  <status-card
                    v-if="
                      item.organization_process.campus_director_approved_status ===
                      'waiting for review'
                    "
                                                        :c="'cursor-pointer bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 text-white'"

                    class="inline-flex items-center"
                  >
                    <timeSvg />

                    {{ item.organization_process.campus_director_approved_status }}
                  </status-card>
                </div>
                <div class="mb-0.5">
                  <status-card
                    v-if="
                      item.organization_process.campus_director_approved_status ===
                      'approved'
                    "
                             :c="'cursor-pointer bg-gradient-to-r from-green-700 via-green-600 to-green-500 text-white'" 
                    class="inline-flex items-center"
                  >
                    <approveSvg />

                    {{ item.organization_process.campus_director_approved_status }}
                  </status-card>
                </div>

                <div class="mb-0.5">
                  <status-card
                    v-if="
                      item.organization_process.campus_director_approved_status ===
                      'denied'
                    "
                                     :c="'cursor-pointer bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white'"
                    class="inline-flex items-center"
                  >
                    <deniedSvg />

                    Denied
                  </status-card>
                </div>

                <!-- <div class="mb-0.5">
                  <status-card
                    :c="[
                      item.organization_process.campus_director_endorsed_status === 'true'
                        ? 'bg-green-100 text-green-600'
                        : 'bg-gray-50 text-gray-400',
                    ]"
                    class="inline-flex items-center"
                  >
                    <checkedSvg />

                    {{
                      item.organization_process.campus_director_endorsed_status === "true"
                        ? "Endorsed"
                        : "Not endorsed yet"
                    }}
                  </status-card>
                </div> -->
              </div>
            </div>
            <div class="mb-1 border py-2 px-2 mr-4 rounded">
              <p class="truncate text-sm t text-gray-900 uppercase">Osas</p>
              <div class="px-2">
                <div class="mb-0.5">
                  <status-card
                    v-if="
                      item.organization_process.osas_approved_status ===
                      'waiting for review'
                    "
          :c="'cursor-pointer bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 text-white'"

                    class="inline-flex items-center"
                  >
                    <timeSvg />

                    {{ item.organization_process.osas_approved_status }}
                  </status-card>
                </div>
                <div class="mb-0.5">
                  <status-card
                    v-if="item.organization_process.osas_approved_status === 'approved'"
                                :c="'cursor-pointer bg-gradient-to-r from-green-700 via-green-600 to-green-500 text-white'"

                    class="inline-flex items-center"
                  >
                    <approveSvg />

                    {{ item.organization_process.osas_approved_status }}
                  </status-card>
                </div>

                <div class="mb-0.5">
                  <status-card
                    v-if="item.organization_process.osas_approved_status === 'denied'"
                                     :c="'cursor-pointer bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white'"
                    class="inline-flex items-center"
                  >
                    <deniedSvg />

                    Denied
                  </status-card>
                </div>

                <!-- <div class="mb-0.5">
                  <status-card
                    :c="[
                      item.organization_process.osas_endorsed_status === 'true'
                        ? 'bg-green-100 text-green-600'
                        : 'bg-gray-50 text-gray-400',
                    ]"
                    class="inline-flex items-center"
                  >
                    <checkedSvg />

                    {{
                      item.organization_process.osas_endorsed_status === "true"
                        ? "Endorsed"
                        : "Not endorsed yet"
                    }}
                  </status-card>
                </div> -->
              </div>
            </div>

            <div class="mb-1 border py-2 px-2 mr-4 rounded">
              <p class="truncate text-sm t text-gray-900 uppercase">Vpa</p>
              <div class="px-2">
                <div class="mb-0.5">
                  <status-card
                    v-if="
                      item.organization_process.vpa_approved_status ===
                      'waiting for review'
                    "

                              :c="'cursor-pointer bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 text-white'"

                    class="inline-flex items-center"
                  >
                    <timeSvg />

                    {{ item.organization_process.vpa_approved_status }}
                  </status-card>
                </div>
                <div class="mb-0.5">
                  <status-card
                    v-if="item.organization_process.vpa_approved_status === 'approved'"
                              :c="'cursor-pointer bg-gradient-to-r from-green-700 via-green-600 to-green-500 text-white'"
                    class="inline-flex items-center"
                  >
                    <approveSvg />

                    {{ item.organization_process.vpa_approved_status }}
                  </status-card>
                </div>

                <div class="mb-0.5">
                  <status-card
                    v-if="item.organization_process.vpa_approved_status === 'denied'"
                                     :c="'cursor-pointer bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white'"
                    class="inline-flex items-center"
                  >
                    <deniedSvg />

                    Denied
                  </status-card>
                </div>
              </div>
            </div>
          </Tcell>
          <!-- <Tcell class="align-top pt-2">
            <div> 

                    <div class="flex space-x-3">
                      <div>
                        <div class="text-sm">
                          <a href="#" class="font-medium text-gray-900">Leslie Alexander</a>
                        </div>
                        <div class="mt-1 text-sm text-gray-700 whitespace-normal w-72">
                          <p>Ducimus quas delectus ad maxime totam doloribus reiciendis ex. Tempore dolorem maiores. Similique voluptatibus tempore non ut.</p>
                        </div>
                     
                      </div>
                    </div>
            </div>
         </Tcell> -->

          <Tcell class="flex items-center justify-center align-top pt-2">
            <SkButtonGray
              :disabled="selected_items.length > 0"
              class="max-w-40 mr-2"
              @click="showManageForm(item)"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-4 h-4 mr-2"
              >
                <path
                  d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z"
                />
                <path
                  d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
                />
              </svg>
              <span class=""> Manage </span>
            </SkButtonGray>
          </Tcell>
        </tr>
      </SkTable>
      <EmptyCard class="flex items-center justify-center h-64" v-else />
    </div>

    <sk-dialog :transition="'slide-down'" :persistent="true" :isOpen="show_form">
      <main class="p-2">
        <div class="mb-2">
          <label for="email" class="block text-sm font-medium text-gray-700"
            >School Year</label
          >

          <div class="mt-1">
            <campusAdviserSelect
              @selectItem="getValue"
              @setDefaultValue="getDefaultValue"
            />
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700"
            >Organization Name</label
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
          <SkButton v-if="form.id == null" @click="save" :processing="form.processing">
            Submit
          </SkButton>
          <SkButton v-else @click="update" :processing="form.processing">
            Update</SkButton
          >
        </div>
      </main>
    </sk-dialog>

    <sk-dialog :transition="'slide-down'" :persistent="true" :isOpen="confirm_delete">
      <main class="">
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

    <sk-dialog
      :transition="'slide-down'"
      :persistent="true"
      :width="'560'"
      :isOpen="show_manage_form"
    >
      <main class="p-2 form-max-h overflow-y-auto">
          <div class="">
            <label for="email" class="block te font-medium text-gray-700"
              >Organization Name</label
            >

            <div class="mt-">
              <Authfield1 type="email" autocomplete="email" v-model="form.name" />
              <!-- <input id="email" v-model="form.email" name="email" type="email" autocomplete="email"  class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"> -->
            </div>
            <p class="text-red-700 text-sm" v-if="$page.props.errors.name">
              {{ $page.props.errors.name }}
            </p>
          </div>

          <p class="mt-2 uppercase leading-8 text-black font-medium">Requirements</p>
          <div v-if="selected_item.requirements.length > 0">
            <!-- {{ selected_item.organization_requirements }} -->
            <aside
              class="shadow-md my-1 mb-2 border rounded-md p-2 bg-gradient-to-r from-gray-50 to-gray-100 "
              v-for="r in selected_item.organization_requirements"
              :key="r"
            >
              <p class="text-gray-900  capitalize">{{ r.name }}</p>
              <div class=" ">
                <p class="mb-2 t text-gray-800 capitalize ">
                  {{ r.requirement.name }}
                </p>
                <div
                  v-if="r.file.length > 0"
                  class="bg-gradient-to-r from-green-600 to-green-600 py-1 px-2 rounded-lg"
                >
                  <!-- {{ r.file  }} -->
                  <div class="my=2">
                    <span v-for="file in r.file" :key="file">
                      <!-- <span class="badge badge-primary" > {{ file.file_name }}  </span> -->
                      <FileCard @click="deleteFile(file)" class="mt-1 mr-1">
                        {{ file.file_name }}</FileCard
                      >
                    </span>
                  </div>
                  <!-- {{ r.organization_requirements }} -->
                </div>

                <div v-else class="mt-2 bg-gray-100 px-2 text-sm text-gray-600 rouned-lg inline-block">
                  No File
                </div>

                <FileUpload
                  @uploadSuccess="handleManageForm"
                  @uploadStart="is_updating = true"
                  @uploadFinish="handleManageForm"
                  :model_id="r.id"
                />
              </div>
            </aside>
          </div>
        

        
      </main>
      <div class="mt-5 flex items-center justify-end">
          <SkButtonGray class="w-40 mr-4" @click="show_manage_form = false">
            Close
          </SkButtonGray>

          <SkButton :c="['w-40']" @click="update" :processing="form.processing">
            Update
          </SkButton>
        </div>
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
import campusAdviserSelect from "@/components/campusAdviserSelect.vue";
import manageApplicationCard from "@/components/manageApplicationCard.vue";

export default {
  components: {
    campusAdviserSelect,
    adminlayout,
    manageApplicationCard,
  },
};
</script>
