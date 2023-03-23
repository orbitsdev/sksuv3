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
const marker = ref('');
const show_manage_form = ref(false);
const show_remark_form = ref(false);
const confirm_delete = ref(false);
const is_deleting = ref(false);
const is_updating = ref(false);
const selected_items = ref([]);
const selected_item = ref(null);
const has_warning = ref(null);




const form = useForm({
  comment: "",
  approver_type:"campus_director",
  item_id: null,
  id: null,
});

watch(
  search,
  throttle((value) => {
    router.get(
      route("director.organization.index"),
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
function deny() {
  form.post(route("organization.application.deny"), {
    preserveState: true,
    onStart: () =>{
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


 function handleSubmit(type){



    
    marker.value = type;

    if(marker.value === 'approve'){
            approve();      
    }
    if(marker.value === 'deny'){

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
            class="block w-full rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm"
            placeholder="Search "
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
          'Document Information',
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

          <Tcell class="align-top">
              <aside class="whitespace-normal">
                <div class="flex items-center mb-2 justify-end">
                  <p class="text-sm uppercase font-medium px-3 text-gray-600">Details</p>
                  <div class="inline-block rounded-full p-2 bg-blue-50 text-blue-400">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="w-6 h-6"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </div>
                </div>
                <div class="border-b pb-3">
                  <div class="px-2 mb-2">
                    <p class="text-gray-600 leading-5 uppercase text-sm">
                      {{ item.name }}
                    </p>
                    <p class="text-xs min-sk-w-t text-gray-500 leading-4">
                      ( Organizaiton name )
                    </p>
                  </div>
                  <div class="px-2 mb-2">
                    <p class="text-gray-600 leading-5 uppercase text-sm">
                      {{
                        item.campus_adviser != null
                          ? item.campus_adviser.user.first_name +
                            " " +
                            item.campus_adviser.user.last_name
                          : "None"
                      }}
                    </p>
                    <p class="text-xs min-sk-w-t text-gray-500 leading-4">
                      ( Campus adviser)
                    </p>
                  </div>
                  <div class="px-2 mb-2">
                    <p class="text-gray-600 leading-5 uppercase text-sm">
                      {{
                        item.campus_adviser != null
                          ? item.campus_adviser.school_year.from +
                            " - " +
                            item.campus_adviser.school_year.to
                          : "None"
                      }}
                    </p>
                    <p class="text-xs min-sk-w-t text-gray-500 leading-4">
                      ( School Year )
                    </p>
                  </div>
                </div>

                <div class="mt-3 border-b pb-3">
                  <div class="flex items-center mb-2 justify-end">
                    <p class="text-sm uppercase font-medium text-gray-600">
                      Requirements
                    </p>
                    <div
                      class="inline-block rounded-full p-2 bg-emerald-50 text-emerald-400 ml-2"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z"
                          clip-rule="evenodd"
                        />
                        <path
                          fill-rule="evenodd"
                          d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zm9.586 4.594a.75.75 0 00-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.116-.062l3-3.75z"
                          clip-rule="evenodd"
                        />git
                      </svg>
                    </div>
                  </div>

                  <div v-if="item.organization_requirements.length > 0">
                    <p
                      class="text-sm min-sk-w-t text-gray-600 leading-5 mb-1"
                      v-for="(og, index) in item.organization_requirements"
                      :key="og"
                    >
                      <span class="mx-1 normal"> {{ index + 1 }}. </span>
                      <span class=""> {{ og.requirement.name }} </span>
                    </p>
                  </div>
                </div>
              </aside>

              <aside class="mt-2">
                <div class="flex items-center mb-2 justify-end">
                  <p class="text-sm uppercase font-medium text-gray-600">Files</p>
                  <div
                    class="inline-block rounded-full p-2 bg-purple-50 text-purple-400 ml-2"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="w-6 h-6"
                    >
                      <path
                        d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 00-3-3h-3.879a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H6a3 3 0 00-3 3v3.162A3.756 3.756 0 014.094 9h15.812zM4.094 10.5a2.25 2.25 0 00-2.227 2.568l.857 6A2.25 2.25 0 004.951 21H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-2.227-2.568H4.094z"
                      />
                    </svg>
                  </div>
                </div>

                <div class="border-b mb-1">
                  <div
                    class="whitespace-normal mb-1"
                    v-for="og in item.organization_requirements"
                    :key="og"
                  >
                    <div v-if="og.file.length > 0">
    
                      <div v-for="file in og.file" :key="file" :file="file">
                        <FileViewLink :href="file.file_url" target="_blank" class="mb-1">
                          {{ file.file_name }}
                        </FileViewLink>
                      </div>
                    </div>
                  </div>
                </div>
              </aside>
            </Tcell>

         <Tcell>
          <aside class="whitespace-normal mb-2">
                <div class="flex items-center mb-2 justify-end">
                  <p class="text-sm uppercase font-medium px-3 text-gray-600">
                    Approvals
                  </p>
                  <div class="inline-block rounded-full p-2 bg-orange-50 text-orange-300">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="w-6 h-6"
                    >
                      <path
                        d="M12.378 1.602a.75.75 0 00-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03zM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 00.372-.648V7.93zM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 00.372.648l8.628 5.033z"
                      />
                    </svg>
                  </div>
                </div>

                <div class="mt-2 rounded-lg bg-gray-200 p-2">
                  <div class="p-4 bg-white rounded">
                    <p class="text-gray-600 leading-5 uppercase text-sm text-center">
                          Campus Adviser
                    </p>

                    <div class="mt-2 text-center">
                      <ApproveCard :status="item.organization_process.campus_adviser_approved_status" />
                        <EndorsementCard :status=" item.organization_process.campus_adviser_endorsed_status"/>

                    </div>
                  </div>
                </div>
                <div class="mt-2 rounded-lg bg-gray-200 p-2">
                  <div class="p-4 bg-white rounded">
                    <p class="text-gray-600 leading-5 uppercase text-sm text-center">
                      You
                    </p>

                    <div class="mt-2 text-center">
                        <ApproveCard :status=" item.organization_process.campus_director_approved_status" />
                    </div>
                  </div>
                </div>
                <div class="mt-2 rounded-lg bg-gray-200 p-2">
                  <div class="p-4 bg-white rounded">
                    <p class="text-gray-600 leading-5 uppercase text-sm text-center">
                     Osas
                    </p>

                    <div class="mt-2 text-center">
                      <ApproveCard :status="item.organization_process.osas_approved_status" />
                      <EndorsementCard :status=" item.organization_process.osas_endorsed_status"/>
                    </div>
                  </div>
                </div>
                <div class="mt-2 rounded-lg bg-gray-200 p-2">
                  <div class="p-4 bg-white rounded">
                    <p class="text-gray-600 leading-5 uppercase text-sm text-center">
                      VPAA
                    </p>

                    <div class="mt-2 text-center">
                      <ApproveCard :status="item.organization_process.vpa_approved_status" />
                    </div>
                  </div>
                </div>
              </aside>
          </Tcell>

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
          </Tcell>
        </tr>
      </SkTable>
      <EmptyCard class="flex items-center justify-center h-64" v-else />

       <div class="mt-6 py-4 bg-white" v-if="$props.organizations.links.length > 0">
        <Pagination
          v-if="$props.organizations.data.length > 0"
          class="block"
          :links="$props.organizations.links"
        />
      </div>
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
       
          
          <button  :disabled="form.processing" v-if="selected_item.organization_process.campus_director_approved_status != 'approved' "  @click="handleSubmit('approve')" class="border rounded-lg hover:scale-95 transition-all ease-in-out hover:bg-green-700 bg-green-600 text-white">
            <div class="col-span-1 h-40 flex items-center justify-center flex-col">
              <thumbsUpSvg :active="form.processing && marker =='approve' "/>

              <p class="text-2xl mt-2">Approve</p>
            </div>
          </button>
          <button :disabled="form.processing" v-if="selected_item.organization_process.campus_director_approved_status != 'denied'" @click="handleSubmit('deny')" class="border rounded-lg hover:scale-95 transition-all ease-in-out hover:bg-red-800 bg-red-700 text-white">
            <div class="col-span-1 h-40 flex items-center justify-center flex-col">
              <thumbsDownSvg :active="form.processing && marker =='deny' "/>
            
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
              Please specify if there is a mistake or missing files in the information
              This way, the applicant can correct and resubmit the application for your
              review.
            </div>
  <label for="comment" class="block  font-medium text-gray-700">Remark</label>
  <div class="mt-1">
    <textarea rows="4" v-model="form.comment" class="p-2 block w-full rounded-md border shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
  </div>
</div>

       <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
          <SkButtonGray @click="show_remark_form  = false"> Close </SkButtonGray>

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
