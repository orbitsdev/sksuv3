<script setup>
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

import moment from "moment";

const props = defineProps({
  organizations: Object,
  filters: Object,
});

const search = ref("");
const show_form = ref(false);
const marker = ref("");
const show_manage_form = ref(false);
const show_remark_form = ref(false);
const confirm_delete = ref(false);
const confirm_endorse = ref(false);
const is_deleting = ref(false);
const is_updating = ref(false);
const selected_items = ref([]);
const selected_item = ref(null);
const has_warning = ref(null);

const enodrsed_list = ref([]);



const show_endorsement_letter = ref(false);

function makeEndorsementLeter() {
  show_endorsement_letter.value = true;
}

const print_form = useForm({
  print_date: moment().format("YYYY-MM-DD"),
  director_student_affair: "Maria Kate Dijuan",
  campus: "Sultan Kudarate State University (Isulan Campus)",
  sbo_governor: "Jushua Allan Magdangal",
  sbo_adviser: "Jessa Marites Oha",
});
const form = useForm({
  comment: "",
  approver_type: "campus_adviser",
  item_id: null,
  id: null,
});


function  formattedDate(date) {
      // Create a Moment.js object from the date string
      const momentDate = moment(date);

      // Format the date to display as December 1, 2022
      return momentDate.format('MMMM D, YYYY');
    }

function printEndorsement() {
  print();
  // const printContents = document.getElementById("endosement-letter").innerHTML;
  //     const originalContents = document.body.innerHTML;
  //     document.body.innerHTML = printContents;
  //     window.print();
  //     document.body.innerHTML = originalContents;
}

watch(
  search,
  throttle((value) => {
    router.get(
      route("campusadviser.organization.index"),
      { search: value },
      {
        preserveState: true,
        replace: true,
      }
    );
  }, 500)
);

function showEndorsedConfirmation(item) {
  form.id = item.id;
  confirm_endorse.value = true;
}

function showForm() {
  //   form.school_year_id = null;
  form.comment = "";
  selected_item.value = null;
  form.id = null;
  show_form.value = true;
}

function showUpdateForm(item) {
  // selected_item.value = item;

  form.id = item.id;
  show_form.value = true;
}

function approve() {
  form.post(route("organization.application.approve"), {
    preserveState: true,
    onSuccess: () => {
      show_manage_form.value = false;
      form.reset();
    },
    onError: (error) => {
      has_warning.value = error;
    },

    onFinish: () => {
      show_manage_form.value = false;
      form.reset();
    },
  });
}
function endorse() {
  form.post(route("organization.application.endorse"), {
    preserveState: true,
    onSuccess: () => {
      show_manage_form.value = false;
      confirm_endorse.value = false;
      form.reset();
    },
    onError: (error) => {
      has_warning.value = error;
    },

    onFinish: () => {
      show_manage_form.value = false;
      confirm_endorse.value = false;

      form.reset();
    },
  });
}
function deny() {
  form.post(route("organization.application.deny"), {
    preserveState: true,
    onStart: () => {
      show_remark_form.value = false;
    },
    onSuccess: () => {
      show_manage_form.value = false;
      show_remark_form.value = false;
      form.reset();
    },
    onError: (error) => {
      has_warning.value = error;
      show_manage_form.value = false;
      show_remark_form.value = false;
    },

    onFinish: () => {
      show_manage_form.value = false;
      show_remark_form.value = false;
      form.reset();
    },
  });
}

function handleSubmit(type) {
  marker.value = type;

  if (marker.value === "approve") {
    approve();
  }
  if (marker.value === "deny") {
    show_remark_form.value = true;
  }
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

    form.comment = "";
    confirm_delete.value = false;
    selected_items.value = [];
  } catch (error) {
    has_warning.value = error.message;
  } finally {
    is_deleting.value = false;
  }
}

function getValue(item) {
  form.item_id = parseInt(item);
}

function getDefaultValue(item) {
  if (item != null) {
    form.item_id = parseInt(item);
  }
}

function showManageForm(item) {
  show_manage_form.value = true;
  selected_item.value = item;
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
            class="block w-full px-2 rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm"
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
        <TableTitle> Organizations </TableTitle>
        <div class="">
          <sk-button
            :disabled="enodrsed_list.length <=0"
            @click="makeEndorsementLeter"
            :c="enodrsed_list.length > 0 ?'sk-bg-green text-white' : 'bg-gray-100 text-gray-400 '"
            class="flex items-center justify-center mr-2 h-10"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-5 h-5 mr-2 "
            >
              <path
                fill-rule="evenodd"
                d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM9.75 14.25a.75.75 0 000 1.5H15a.75.75 0 000-1.5H9.75z"
                clip-rule="evenodd"
              />
              <path
                d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z"
              />
            </svg>

            Make Endorsement Letter
          </sk-button>
        </div>
      </div>
      <SkTable
        v-if="props.organizations.data.length > 0"
        :headers="[
          '',
          'Name of Organization',
          'Campus',
          'School Year',
          'Appication Documents & Remarks ',
          'Application Process Status',
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
              v-model="enodrsed_list"
              :value="item"
              type="checkbox"
              class="h-4 w-4 accent-green-600 text-white rounded border-gray-200"
            />
          </Tcell>

          <Tcell class="uppercase align-top pt-2"> {{ item.name }} </Tcell>
          <Tcell class="uppercase align-top pt-2">
            {{ item.campus_adviser.campus.name }}
          </Tcell>
          <Tcell class="uppercase align-top pt-2">
            SY.{{ item.campus_adviser.school_year.from }}
            {{ item.campus_adviser.school_year.from }}
          </Tcell>

          <Tcell class="align-top pt-2 whitespace-normal">
            <div>
              <div
                class="truncate text-sm font-medium text-gray-900 uppercase flex items-center"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="w-5 h-5 mr-2"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM9.75 14.25a.75.75 0 000 1.5H15a.75.75 0 000-1.5H9.75z"
                    clip-rule="evenodd"
                  />
                  <path
                    d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z"
                  />
                </svg>

                Requirements
              </div>

              <div class="mt-1 py-1" v-if="item.organization_requirements.length > 0">
                <aside class="" v-for="og in item.organization_requirements" :key="og">
                  <li class="text-xs">
                    {{ og.requirement.name }}
                  </li>
                </aside>
              </div>

              <div class="mt-2">
                <div
                  class="truncate text-sm font-medium text-gray-900 uppercase flex items-center"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-5 h-5 mr-2"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10.5 3.75a6 6 0 00-5.98 6.496A5.25 5.25 0 006.75 20.25H18a4.5 4.5 0 002.206-8.423 3.75 3.75 0 00-4.133-4.303A6.001 6.001 0 0010.5 3.75zm2.25 6a.75.75 0 00-1.5 0v4.94l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V9.75z"
                      clip-rule="evenodd"
                    />
                  </svg>

                  Uploaded
                </div>
                <div>
                  <aside class="" v-for="og in item.organization_requirements" :key="og">
                    <div class="mt-2" v-if="og.file.length > 0">
                      <div class="">
                        <p class="mb-1 px-2"></p>
                        <FileViewLink
                          :href="file.file_url"
                          target="_blank"
                          class="mb-1"
                          v-for="file in og.file"
                          :key="file"
                          :file="file"
                        >
                          {{ file.file_name }}
                        </FileViewLink>
                      </div>
                    </div>
                  </aside>
                </div>
              </div>
            </div>
          </Tcell>
          <Tcell class="align-top pt-2 capitalize">
            <div class="mb-1 border py-2 px-2 mr-4 rounded">
              <p class="truncate text-sm t text-gray-900 uppercase">You</p>

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
                <div class="mb-0.5">
                  <status-card
                    :c="[
                      item.organization_process.campus_adviser_endorsed_status === 'true'
                        ? 'cursor-pointer bg-gradient-to-r from-green-700 via-green-600 to-green-500 text-white'
                        : 'cursor-pointer bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 text-white',
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
                </div>
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
                <!-- 
                <div class="mb-0.5">
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

          <Tcell class="align-top pt-2">
            <div>
              <SkButtonGray
                :disabled="selected_items.length > 0"
                class="max-w-40 mr-2"
                @click="showManageForm(item)"
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

                <span class=""> Decide </span>
              </SkButtonGray>
            </div>
            <div
              v-if="
                item.organization_process.campus_adviser_approved_status == 'approved'
              "
              class="mt-2"
            >
              <SkButtonGray
                :disabled="selected_items.length > 0"
                class="max-w-40 mr-2"
                @click="showEndorsedConfirmation(item)"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="w-5 h-5 mr-2"
                >
                  <path
                    fill-rule="evenodd"
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                    clip-rule="evenodd"
                  />
                </svg>

                <span class=""> Endorse </span>
              </SkButtonGray>
            </div>
          </Tcell>
        </tr>
      </SkTable>
      <EmptyCard class="flex items-center justify-center h-64" v-else />
    </div>

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
      :width="'540'"
      :isOpen="show_manage_form"
    >
      <main class="p-2">
        <div class="grid grid-cols-1">
          <button
            :disabled="form.processing"
            v-if="
              selected_item.organization_process.campus_adviser_approved_status !=
              'approved'
            "
            @click="handleSubmit('approve')"
            class="border rounded-lg hover:scale-95 transition-all ease-in-out hover:bg-green-700 bg-green-600 text-white"
          >
            <div class="col-span-1 h-40 flex items-center justify-center flex-col">
              <thumbsUpSvg :active="form.processing && marker == 'approve'" />

              <p class="text-2xl mt-2">Approve</p>
            </div>
          </button>
          <button
            :disabled="form.processing"
            v-if="
              selected_item.organization_process.campus_adviser_approved_status !=
              'denied'
            "
            @click="handleSubmit('deny')"
            class="border rounded-lg hover:scale-95 transition-all ease-in-out hover:bg-red-800 bg-red-700 text-white"
          >
            <div class="col-span-1 h-40 flex items-center justify-center flex-col">
              <thumbsDownSvg :active="form.processing && marker == 'deny'" />

              <p class="text-2xl mt-2">Deny</p>
            </div>
          </button>
        </div>

        <div class="mt-5 flex items-center justify-end">
          <SkButtonGray class="w-40 mr-4" @click="show_manage_form = false">
            Close
          </SkButtonGray>
        </div>
      </main>
    </sk-dialog>
    <sk-dialog
      :transition="'slide-down'"
      :persistent="true"
      :width="'640'"
      :isOpen="show_remark_form"
    >
      <main class="p-2">
        <div>
          <div
            tabindex="0"
            class="focus:outline-none text-sm bg-indigo-100 text-indigo-700 dark:text-indigo-600 rounded font-medium p-2"
          >
            Please specify if there is a mistake or missing files in the information This
            way, the applicant can correct and resubmit the application for your review.
          </div>
          <label for="comment" class="block font-medium text-gray-700">Remark</label>
          <div class="mt-1">
            <textarea
              rows="4"
              v-model="form.comment"
              class="p-2 block w-full rounded-md border shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            ></textarea>
          </div>
        </div>

        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
          <SkButtonGray @click="show_remark_form = false"> Close </SkButtonGray>

          <sk-delete-button @click="deny" :processing="form.processing">
            Submit
          </sk-delete-button>
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
  <SkDialog :persistent="true" :isOpen="confirm_endorse" :width="'540'">
    <div>
      <div
        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100"
      >
        <svg
          class="h-6 w-6 text-green-600"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          aria-hidden="true"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M4.5 12.75l6 6 9-13.5"
          />
        </svg>
      </div>
      <div class="mt-3 text-center sm:mt-5">
        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
          Endorsed
        </h3>
        <div class="mt-2">
          <p class="text-sm text-gray-500">
            Are you sure do you want to endorse this application
          </p>
        </div>
      </div>
    </div>
    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
      <SkButtonGray @click="confirm_endorse = false"> No </SkButtonGray>

      <SkButton @click="endorse" :processing="form.processing"> Yes</SkButton>
    </div>
  </SkDialog>

  <SkDialog :persistent="true" :isOpen="show_endorsement_letter" :fullScreen="true">
    <div class="print:hidden sticky top-0 bg-white">
      <div class="bg-white shdaow py-4 flex items-center justify-end">
        <button
          class="flex justify-center rounded-md items-center hover:bg-gray-100 border mr-2 py-2 px-4 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:green-500 focus:ring-offset-2"
          @click="show_endorsement_letter = false"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-6 h-6"
          >
            <path
              fill-rule="evenodd"
              d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
              clip-rule="evenodd"
            />
          </svg>
          Close
        </button>
        <button
          @click="printEndorsement"
          class="flex justify-center rounded-md items-center hover:bg-gray-100 border py-2 px-4 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:green-500 focus:ring-offset-2"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-6 h-6 mr-2"
          >
            <path
              fill-rule="evenodd"
              d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 003 3h.27l-.155 1.705A1.875 1.875 0 007.232 22.5h9.536a1.875 1.875 0 001.867-2.045l-.155-1.705h.27a3 3 0 003-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0018 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM16.5 6.205v-2.83A.375.375 0 0016.125 3h-8.25a.375.375 0 00-.375.375v2.83a49.353 49.353 0 019 0zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 01-.374.409H7.232a.375.375 0 01-.374-.409l.526-5.784a.373.373 0 01.333-.337 41.741 41.741 0 018.566 0zm.967-3.97a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H18a.75.75 0 01-.75-.75V10.5zM15 9.75a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V10.5a.75.75 0 00-.75-.75H15z"
              clip-rule="evenodd"
            />
          </svg>

          Print
        </button>
      </div>
    </div>
    <div class="print:hidden mb-6 w-3/6 mx-auto">
      <div class="rounded">
        <h3 class="text-base font-semibold leading-6 text-gray-900">
          Customize Information Before Print
        </h3>

        <div class="grid gap-x-6 gap-y-2 grid-cols-6 bg-gray-200 py-2 px-4 rounded">
          <div class="col-span-2">
            <label
              for="first-name"
              class="block text-sm font-medium leading-6 text-gray-900"
              >Director of Student Affair</label
            >
            <div class="mt-2">
              <input
                v-model="print_form.director_student_affair"
                type="text"
                autocomplete="given-name"
                class="block w-full px-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"
              />
            </div>
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium leading-6 text-gray-900"
              >Campus</label
            >
            <div class="mt-2">
              <input
                v-model="print_form.campus"
                type="text"
                autocomplete="given-name"
                class="block w-full px-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"
              />
            </div>
          </div>
          <div class="col-span-2">
            <label
              for="first-name"
              class="block text-sm font-medium leading-6 text-gray-900"
              >SBO GOVERNOR</label
            >
            <div class="mt-2">
              <input
                v-model="print_form.sbo_governor"
                type="text"
                autocomplete="given-name"
                class="block w-full px-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"
              />
            </div>
          </div>

          <div class="col-span-2">
            <label class="block text-sm font-medium leading-6 text-gray-900"
              >SBO Adviser</label
            >
            <div class="mt-2">
              <input
                type="text"
                v-model="print_form.sbo_adviser"
                autocomplete="family-name"
                class="block w-full px-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"
              />
            </div>
          </div>
          <div class="col-span-2">
            <label class="block text-sm font-medium leading-6 text-gray-900">Date</label>
            <div class="mt-2">
              <input
                type="date"
                v-model="print_form.print_date"
                class="pr-8 block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      id="endorsement-parent"
      class="mx-auto print:w-full w-3/6 border border-gray-400 p-6"
    >
      <div id="endosement-letter">
        <section class="flex items-center justify-center">
          <div class="w-36 flex items-center justify-center">
            <img src="/assets/sksu1.png" alt="" class="h-12 w-12" />
          </div>

          <aside>
            <p class="leading-4 text-sm text-center">Republic of the Philippines</p>
            <p class="leading-5 text-sm text-center uppercase font-bold">
              Sultan Kudarat State University
            </p>
            <p class="leading-4 text-sm text-center">Province of Sultan Kudarat</p>
          </aside>

          <div class="w-36 flex items-center justify-center">
            <img src="/assets/sbo.png" alt="" class="h-12 w-12" />
          </div>
        </section>

        <section class="mx-auto w-full">
          <p class="mt-6 text-sm">{{ formattedDate(print_form.print_date) }}</p>

          <aside class="mt-4">
            <p class="text-sm leading-5 font-bold">
              {{ print_form.director_student_affair }}
            </p>
            <p class="text-sm leading-5">Director of Student Affair and Services</p>
            <p class="text-sm leading-5">Office of Student Affair and Services</p>
          </aside>

          <aside class="mt-4">
            <p class="text-sm">Sir</p>
            <p class="text-sm mt-4">Greeting of Peace!</p>
            <p class="text-sm mt-6 leading-5">
              This is to respecfully submit the documents of the following clubs and
              organizations of {{ print_form.campus }}
            </p>
          </aside>

          <aside class="mt-4">
            <div
              v-for="(item, index) in enodrsed_list"
              :key="item"
              class="flex items-center px-6 text-sm"
            >
              <span class="text-black w-8 inline-block"> {{ index + 1 }}. </span>
              <p class="uppercase">
                {{ item.name }}
              </p>
            </div>
          </aside>

          <aside class="mt-4">
            <p class="text-sm">Thank you and God Bless!</p>
          </aside>
          <aside class="mt-4 text-sm">
            <p class="text-sm">Respectfully Yours,</p>
          </aside>
          <aside class="mt-5">
            <p class="text-sm uppercase">{{ print_form.sbo_governor }}</p>
            <p class="text-sm">SBO GOVERNOR</p>
          </aside>
          <aside class="mt-6">
            <p class="text-sm">NOTED BY</p>
          </aside>
          <aside class="mt-6">
            <p class="text-sm uppercase">{{ print_form.sbo_adviser }}</p>
            <p class="text-sm">SBO ADVISER</p>
          </aside>
        </section>
      </div>
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

<style coped>
@media print {
  #endorment-letter {
  }
}
</style>
