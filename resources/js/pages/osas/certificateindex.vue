<script setup>
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

import axios from 'axios';

import moment from 'moment';


const props = defineProps({
  organizations: Object,
  filters: Object,
});

const search = ref("");
const show_form = ref(false);
const marker = ref("");
const show_manage_form = ref(false);

const confirm_delete = ref(false);
const is_deleting = ref(false);
const is_updating = ref(false);
const selected_items = ref([]);
const selected_item = ref(null);
const has_warning = ref(null);
const show_cerficate_form = ref(false);



const form = useForm({
  
  usg_adviser: '',
  director_affair: '',
  held_location: '',
  month_year:  moment().format('YYYY-MM'),
  comment: "",
  approver_type: "osas",
  item_id: null,
  comment_only: false,
  remark_id: null,
  id: null,
});

const confirm_endorse = ref(false);

function showEndorsedConfirmation(item) {
  form.id = item.id;
  confirm_endorse.value = true;
}

watch(
  search,
  throttle((value) => {
    router.get(
      route("osas.accreditation.index"),
      { search: value },
      {
        preserveState: true,
        replace: true,
      }
    );
  }, 500)
);

const show_remark_form = ref(false);
const show_remarks = ref(false);

function comment() {
  form.post(route("organization.application.comment"), {
    preserveState: true,
    onStart: () => {},
    onSuccess: () => {
      show_remark_form.value = false;
      form.reset();
    },
    onError: (error) => {
      has_warning.value = error;
      show_remark_form.value = false;
    },

    onFinish: () => {
      show_remark_form.value = false;
      form.reset();
    },
  });
}

function viewRemarks(item) {
  selected_item.value = item;
  show_remarks.value = true;
}
function closeRemark() {
  show_remarks.value = false;
  form.remark_id = null;
}

function showRemarkForm(item) {
  form.comment_only = true;
  show_remark_form.value = true;
  selected_item.value = item;
  form.id = item.id;
}

function closeRemarkForm(item) {
  show_remark_form.value = false;
  form.comment_only = false;
}

function deleteRemark(organization, remark) {
  form.id = organization;
  form.remark_id = remark;

  form.post(route("organization.application.deletecomment"), {
    preserveState: true,
    preserveScroll: true,

    onSuccess: () => {
      closeRemark();
      form.reset();
    },
    onError: (error) => {
      has_warning.value = error;
    },

    onFinish: () => {
      closeRemark();
      form.reset();
    },
  });
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
    preserveScroll: true,
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
    preserveScroll: true,
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
    preserveScroll: true,
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

function closeMangeForm() {
  show_manage_form.value = false;
  form.comment_only = false;
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

function showCertificateForm(item){

    form.id= item.id;
   show_cerficate_form.value = true;

}



const is_processing = ref(false);

async function generateCertificate() {

is_processing.value = true;
  axios
    .get(route("public.generateFile",{
       
      usg_adviser: form.usg_adviser,
      director_affair: form.director_affair,
      held_location: form.held_location,
      id: parseInt(form.id)
    
    }), {
     
      responseType: 'arraybuffer'
    })
    .then(response => {


      // console.log(response.data);

      let blob = new Blob([response.data], { type: 'image/png' }),
      url = window.URL.createObjectURL(blob),
      a = document.createElement('a')
    
    a.href = url
    a.download = 'accreditation-certificate.png'
    document.body.appendChild(a)
    a.click()
    document.body.removeChild(a)
   
    }).finally(()=>{
      is_processing.value=false;
      show_cerficate_form.value = false;
    }
    
    )

  //  try {
  //   const { data } = await form.get(route("public.generateFile"), {
  //     onSuccess: () => {
  //       // Handle any success logic
  //     },
  //     onError: (error) => {
  //       console.error(error);
  //     },
  //     onFinish: () => {
  //       // Handle any finish logic
  //     }
  //   });

  //   // Navigate to the file download URL
  //   window.location.href = data.downloadUrl;
  // } catch (error) {
  //   console.error(error);
  // }
  // const { data } = await form.get(route("public.generateFile", {responseType: 'arraybuffer'}), {
  //   onSuccess: () => {
  //     // Handle any success logic
  //   },
  //   onError: (error) => {
  //     console.error(error);
  //   },
  //   onFinish: () => {
  //     // Handle any finish logic
  //   }
  // });

  // // Create a blob URL for the file response
  // const url = URL.createObjectURL(
  //   new Blob([atob(data.file)], { type: "image/png" })
  // );

  // // Create a link and click it to download the file
  // const link = document.createElement("a");
  // link.href = url;
  // link.setAttribute("download", data.filename);
  // link.click();

  // // Release the blob URL
  // URL.revokeObjectURL(url);
}

//   function generateCertificate() {

    
    
//     form.get(route('public.generateFile'), {
//       preserveState:true,
//       preserveScroll:true,
//       onSuccess: (response) => {

// console.log(response.data);
// console.log('success');

// const url = URL.createObjectURL(new Blob([response.data]));

//       Create a link and click it to download the file
//       const link = document.createElement("a");
//       link.href = url;
//       link.setAttribute("download", "certificate.png");
//       link.click();

//       Release the blob URL
//       URL.revokeObjectURL(url);    
//         const url = route('osas.generatecerticate.certificate.generate');
//   const xhr = new XMLHttpRequest();
//   xhr.open('GET', url, true);
//   xhr.responseType = 'blob';

//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === XMLHttpRequest.DONE) {
//       if (xhr.status === 200) {
//         const blob = xhr.response;
//         const link = document.createElement('a');
//         link.href = window.URL.createObjectURL(blob);
//         link.download = 'certificate.pdf'; // Replace with the desired filename and extension
//         document.body.appendChild(link);
//         link.click();
//         document.body.removeChild(link);
//         window.URL.revokeObjectURL(link.href);
//         post(route('osas.generatecerticate.certificate.download-success', item.id));
//       } else {
//         console.error(xhr.statusText);
//       }
//     }
//   };

//   xhr.send(null);

//           working

//           const url = window.URL.createObjectURL(new Blob([response.data]));
//           const link = document.createElement('a');
//           link.href = url;
//           const fiile = "C:\\Users\\mj\\Documents\\2023\\sksuv3\\public\\assets/images/certificates/accreditation-certificate.png"
//           link.setAttribute('download', fiile);
//           document.body.appendChild(link);
//           link.click();

//          window.location.href = response.url;
//        window.open(response.request.responseURL, '_blank');//   console.log(response.data);
//         //  const url = window.URL.createObjectURL(new Blob([response.data]));
//         const link = document.createElement('a');
//         link.href = url;
//         document.body.appendChild(link);
//         link.click();

//         },
//         onError: (error) => {
//           console.error(error);
//         },

//         onFinish: () => {},
    
//     });


//   }

// function generateCertificate(item) {
//   router.get(
//     route("osas.generatecerticate.certificate.generate",{ id: item.id },),

//     {
//       responseType: "blob",
//       onSuccess: (response) => {
//         const url = window.URL.createObjectURL(new Blob([response.data]));
//         const link = document.createElement("a");
//         link.style.display = "none";
//         link.href = url;
//         link.setAttribute("download", "certificate.png");
//         document.body.appendChild(link);
//         link.click();
//         window.URL.revokeObjectURL(url);
//         document.body.removeChild(link);
//       },
//       onError: (error) => {
//         has_warning.value = error;
//       },
//       onFinish: () => {},
//     }
//   );
// }
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
        <p class="text-xl text-green-800 font-bold font-rubik uppercase">Organizations</p>
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
        </div>
      </div>
      <SkTable
        v-if="props.organizations.data.length > 0"
        :headers="[
          '',
          'Name of Organization',
          'Campus',
          'Adviser',
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
            <!-- <input
              v-model="selected_items"
              :value="item.id"
              type="checkbox"
              class="h-4 w-4 accent-green-600 text-white rounded border-gray-200"
            /> -->
          </Tcell>

          <Tcell class="uppercase align-top pt-2"> {{ item.name }} </Tcell>
          <Tcell class="uppercase align-top pt-2">
            {{ item.campus_adviser.campus.name }}
          </Tcell>
          <Tcell class="uppercase align-top pt-2">
            {{ item.campus_adviser.user.first_name }}
            {{ item.campus_adviser.user.last_name }}
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

              <div class="mt-1">
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
                    <div class="mt-1" v-if="og.file.length > 0">
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
                <!-- 
                <div
                  @click="viewRemarks(item)"
                  class="cursor-pointer bg-gradient-to-r hover:scale-95 transition-all ease-in-out from-rose-500 via-red-500 to-pink-500 text-white rounded py-2 text px-1 mr-2 mt-4"
                  v-if="item.remarks.length > 0"
                >
                  <div class="truncate text-sm font-medium uppercase flex items-center">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="w-5 h-5 mr-2"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M12 2.25c-2.429 0-4.817.178-7.152.521C2.87 3.061 1.5 4.795 1.5 6.741v6.018c0 1.946 1.37 3.68 3.348 3.97.877.129 1.761.234 2.652.316V21a.75.75 0 001.28.53l4.184-4.183a.39.39 0 01.266-.112c2.006-.05 3.982-.22 5.922-.506 1.978-.29 3.348-2.023 3.348-3.97V6.741c0-1.947-1.37-3.68-3.348-3.97A49.145 49.145 0 0012 2.25zM8.25 8.625a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25zm2.625 1.125a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0zm4.875-1.125a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    Comments {{ item.remarks.length }}
                  </div>
                </div> -->
              </div>
            </div>
          </Tcell>
          <Tcell class="align-top pt-2">
            <div class="mb-1 border py-2 px-2 mr-4 rounded">
              <div class="px-2">
                <p class="truncate text-sm t text-gray-900 uppercase">SBO ADVISER</p>

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
                <!-- 
                <div class="mb-0.5">
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
              <p class="truncate text-sm t text-gray-900 uppercase">You</p>
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

                <div class="mb-0.5">
                  <status-card
                    :c="[
                      item.organization_process.osas_endorsed_status === 'true'
                        ? 'cursor-pointer bg-gradient-to-r from-green-700 via-green-600 to-green-500 text-white'
                        : 'cursor-pointer bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 text-white',
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
                </div>
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

          <!-- osas.generatecerticate.certificate.generate -->

          <Tcell class="align-top pt-2">
            <div class="mt2">

              <SkButtonGray
                :disabled="selected_items.length > 0"
                class="max-w-40 mr-2"
                @click="showCertificateForm(item)"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="w-5 h-5 mr-2"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 00-.584.859 6.753 6.753 0 006.138 5.6 6.73 6.73 0 002.743 1.346A6.707 6.707 0 019.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 00-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 00.75-.75 2.25 2.25 0 00-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 01-1.112-3.173 6.73 6.73 0 002.743-1.347 6.753 6.753 0 006.139-5.6.75.75 0 00-.585-.858 47.077 47.077 0 00-3.07-.543V2.62a.75.75 0 00-.658-.744 49.22 49.22 0 00-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 00-.657.744zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 013.16 5.337a45.6 45.6 0 012.006-.343v.256zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 01-2.863 3.207 6.72 6.72 0 00.857-3.294z"
                    clip-rule="evenodd"
                  />
                </svg>

                
              
                <span class=""> Generate Certificate </span>
              </SkButtonGray>
              <!-- 
                <a
                :href="
                  route('osas.generatecerticate.certificate.generate', { id: item.id })
                "
                class="inline-flex justify-center rounded-md px-4 py-2 font-medium shadow-sm text-sm text-gray-700 hover:bg-gray-50 border border-gray-300 bg-white "
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="w-5 h-5 mr-2"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 00-.584.859 6.753 6.753 0 006.138 5.6 6.73 6.73 0 002.743 1.346A6.707 6.707 0 019.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 00-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 00.75-.75 2.25 2.25 0 00-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 01-1.112-3.173 6.73 6.73 0 002.743-1.347 6.753 6.753 0 006.139-5.6.75.75 0 00-.585-.858 47.077 47.077 0 00-3.07-.543V2.62a.75.75 0 00-.658-.744 49.22 49.22 0 00-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 00-.657.744zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 013.16 5.337a45.6 45.6 0 012.006-.343v.256zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 01-2.863 3.207 6.72 6.72 0 00.857-3.294z"
                    clip-rule="evenodd"
                  />
                </svg>

                <span class=""> Generate Certificate </span>
              </a> -->
              <!-- :href="route('osas.generatecerticate.certificate.generate', { id: 1 })" -->
              <!-- <div
                class="max-w-40 mr-2 border cursor-pointer" 
                @click="generateCertificate(item)"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="w-5 h-5 mr-2"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 00-.584.859 6.753 6.753 0 006.138 5.6 6.73 6.73 0 002.743 1.346A6.707 6.707 0 019.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 00-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 00.75-.75 2.25 2.25 0 00-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 01-1.112-3.173 6.73 6.73 0 002.743-1.347 6.753 6.753 0 006.139-5.6.75.75 0 00-.585-.858 47.077 47.077 0 00-3.07-.543V2.62a.75.75 0 00-.658-.744 49.22 49.22 0 00-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 00-.657.744zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 013.16 5.337a45.6 45.6 0 012.006-.343v.256zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 01-2.863 3.207 6.72 6.72 0 00.857-3.294z"
                    clip-rule="evenodd"
                  />
                </svg>

                <span class=""> Generate Certificate </span>
              </div> -->
            </div>
            <!-- <div>
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
            <div class="mt2">
              <SkButtonGray
                :disabled="selected_items.length > 0"
                class="max-w-40 mr-2"
                @click="showRemarkForm(item)"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="w-5 h-5 mr-2"
                >
                  <path
                    fill-rule="evenodd"
                    d="M4.848 2.771A49.144 49.144 0 0112 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 01-3.476.383.39.39 0 00-.297.17l-2.755 4.133a.75.75 0 01-1.248 0l-2.755-4.133a.39.39 0 00-.297-.17 48.9 48.9 0 01-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97zM6.75 8.25a.75.75 0 01.75-.75h9a.75.75 0 010 1.5h-9a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H7.5z"
                    clip-rule="evenodd"
                  />
                </svg>

                <span class=""> Comment </span>
              </SkButtonGray>
            </div>

              <div  v-if="(item.organization_process.osas_endorsed_status == 'false' && item.organization_process.osas_approved_status)" class="mt-2">
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
            </div> -->
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
            <div class="mt-1">
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
            v-if="selected_item.organization_process.osas_approved_status != 'approved'"
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
            v-if="selected_item.organization_process.osas_approved_status != 'denied'"
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
          <SkButtonGray @click="closeRemarkForm"> Close </SkButtonGray>

          <sk-delete-button
            v-if="form.comment_only"
            @click="comment"
            :processing="form.processing"
          >
            Post
          </sk-delete-button>
          <sk-delete-button v-else @click="deny" :processing="form.processing">
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
  <SkDialog :persistent="true" :isOpen="show_remarks" :width="'540'">
    <main class="form-max-h" v-if="selected_item.remarks.length > 0">
      <div
        class="flex items-center space-x-4 border-b mb-1 py-2"
        v-for="remark in selected_item.remarks"
        :key="remark"
      >
        <div class="min-w-0 flex-1">
          <p class="truncate text-xs font-medium text-gray-900">
            <DateCard :text="remark.created_at" />
          </p>

          <p>
            {{ remark.body }}
          </p>
        </div>
        <div>
          <button
            @click="deleteRemark(selected_item.id, remark.id)"
            class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-6 h-6 text-red-700"
            >
              <path
                fill-rule="evenodd"
                d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </div>
      </div>
      <div class="mt-5">
        <SkButtonGray class="w-40 mr-4" @click="closeRemark"> Close </SkButtonGray>
      </div>
    </main>
  </SkDialog>

  <SkDialog :persistent="true" :isOpen="show_cerficate_form" :width="'460'">


  <form @submit.prevent="generateCertificate">

  {{ form.month_year }}
  {{ form.usg_adviser }}
  {{ form.held_location }}
  {{ form.director_affair }}
  {{ form.id }}
      <div class="mx-2">
          <div class="mb-2 ">
            <label for="email" class="block text-sm font-medium text-gray-700 "
              >Month Year</label
            > 

            <div class="mt-1">

             <input type="month" v-model="form.month_year"  class="pr-8 block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm"/>
            </div>
           
          </div>
          <div class="mb-2 ">
            <label for="email" class="block text-sm font-medium text-gray-700"
              >Held Location </label
            > 

            <div class="mt-1">
              <Authfield1 type="text"  v-model="form.held_location" required />
              <!-- <input id="email" v-model="form.email" name="email" type="email"  class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"> -->
            </div>
            <p class="text-red-700 text-sm" v-if="$page.props.errors.held_location">
              {{ $page.props.errors.held_location }}
            </p>
          </div>
          <div class="mb-2 ">
            <label for="email" class="block text-sm font-medium text-gray-700"
              >Usg Adviser</label
            > 

            <div class="mt-1">
              <Authfield1 type="text" v-model="form.usg_adviser" required />
              <!-- <input id="email" v-model="form.email" name="email" type="email"  class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"> -->
            </div>
            <p class="text-red-700 text-sm" v-if="$page.props.errors.usg_adviser" >
              {{ $page.props.errors.usg_adviser }}
            </p>
          </div>
          <div class="mb-2 ">
            <label for="email" class="block text-sm font-medium text-gray-700"
              >Director Student Affair and Services</label
            >  

            <div class="mt-1">
              <Authfield1 type="tex"  v-model="form.director_affair" required />
              <!-- <input id="email" v-model="form.email" name="email" type="email" autocomplete="email"  class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"> -->
            </div>
            <p class="text-red-700 text-sm" v-if="$page.props.errors.director_affair">
              {{ $page.props.errors.director_affair }}
            </p>
          </div>
     </div>
    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
      <SkButtonGray @click="show_cerficate_form = false"> No </SkButtonGray>

      <SkButton type="submit"  :processing="is_processing"> Generate</SkButton>
    </div>
    
  </form>
 
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
