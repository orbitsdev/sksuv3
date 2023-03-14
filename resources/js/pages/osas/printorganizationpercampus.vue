<script setup>
import { ref, watch, defineProps, defineComponent } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

import schoolYearSelectForPrint from "@/components/schoolYearSelectForPrint.vue";

import UploadTemplate from "@/components/UploadTemplate.vue";
import moment from "moment";
const props = defineProps({
  campus: Object,
  filters: Object,
  filter_by_school_year: Object,
});

const search = ref(props.filters.search);
const date = ref(moment().format("YYYY-MM-DD"));
const school_year = ref(props.filter_by_school_year.school_year);
const show_print_form = ref(false);
const selected_campus = ref(null);

defineComponent({
  schoolYearSelectForPrint,
});

function showPrintForm(item) {
  selected_campus.value = item;
  show_print_form.value = true;
}

function hidePrintForm() {
  selected_campus.value = null;
  show_print_form.value = false;
}

function printEndorsement() {
  print();
}

function getValueOfYear(item) {
  school_year.value = item;
}

function getDefaultValueOfYear(item) {
  if (item != null) {
    school_year.value = item;
  }
}

watch(
  search,
  throttle((value) => {
    router.get(
      route("osas.print.lisoforganizationpercampus.index"),
      { search: value },
      {
        preserveState: true,
        replace: true,
      }
    );
  }, 500)
);

watch(
  school_year,
  throttle((value) => {
    console.log(value);
    router.get(
      route("osas.print.lisoforganizationpercampus.index"),
      { school_year: value },
      {
        preserveState: true,
        replace: true,
      }
    );
  }, 500)
);
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
            placeholder="Campus "
            type="search"
            name="search"
          />
        </div>
      </div>
    </template>

    <div class="bg-white rounded-xl shadow-xl mx-auto px-4 max-w-7xl">
      <div class="bg-white">
        <div class="">
          <div class="py-6">
            <div class="min-w-0 flex-1">
              <!-- Profile -->
              <div class="flex items-center justify-between">
                <div>
                  <div class="flex items-center">
                    <table-title> Print Organization Percampus </table-title>
                  </div>
                </div>
                <!-- <div>
                  <schoolYearSelectForPrint
                    @selectItem="getValueOfYear"
                    @setDefaultValue="getDefaultValueOfYear"
                  />
                </div> -->
              </div>
            </div>
            <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4"></div>
          </div>
        </div>

        <ul
          v-if="props.campus.data.length > 0"
          role="list"
          class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
          <li
            @click="showPrintForm(item)"
            v-for="item in props.campus.data"
            :key="item"
            class=" rounded text-center shadow cursor-pointer hover:bg-gray-100 relative"
          >
            <div class="flex flex-1 flex-col p-8">
              <h3 class="mt-6 text-sm font-medium text-gray-900"></h3>
              <dl class="mt-1 flex flex-grow flex-col justify-between">
                <dd class="text-sm text-gray-700 leading-5 uppercase">{{ item.name }}</dd>
                <dt class="sr-only"></dt>
                <dd class="mt-3">
                  <!-- <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800">{{ item }}</span> -->
                </dd>
              </dl>
            </div>


          <!-- <div class="absolute top-4 left-4">
                 {{ item.campus_adviser.school_year.from }} -                                   {{ item.campus_adviser.school_year.to }}
            </div> -->
            <div class="absolute top-4 right-4">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-8 h-8"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 003 3h.27l-.155 1.705A1.875 1.875 0 007.232 22.5h9.536a1.875 1.875 0 001.867-2.045l-.155-1.705h.27a3 3 0 003-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0018 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM16.5 6.205v-2.83A.375.375 0 0016.125 3h-8.25a.375.375 0 00-.375.375v2.83a49.353 49.353 0 019 0zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 01-.374.409H7.232a.375.375 0 01-.374-.409l.526-5.784a.373.373 0 01.333-.337 41.741 41.741 0 018.566 0zm.967-3.97a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H18a.75.75 0 01-.75-.75V10.5zM15 9.75a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V10.5a.75.75 0 00-.75-.75H15z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
          </li>

          <!-- More people... -->
        </ul>
        <EmptyCard class="flex items-center justify-center h-64" v-else />
      </div>

      <div class="mt-6 py-4 bg-white" v-if="$props.campus.links.length > 0">
        <Pagination
          v-if="$props.campus.data.length > 0"
          class="block"
          :links="$props.campus.links"
        />
      </div>
    </div>
  </adminlayout>

  <SkDialog :persistent="true" :isOpen="show_print_form" :fullScreen="true">
    <div class="print:hidden sticky top-0 bg-white">
      <div class="bg-white shdaow py-4 flex items-center justify-end">
        <button
          class="flex justify-center rounded-md items-center hover:bg-gray-100 border mr-2 py-2 px-4 text-sm font-medium shadow-sm focus:outline-none"
          @click="hidePrintForm"
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
          class="flex justify-center rounded-md items-center hover:bg-gray-100 border py-2 px-4 text-sm font-medium shadow-sm focus:outline-none"
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

    <div
      id="organization-percampus"
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

        <aside class="mt-6">
          <p class="leading-5 text-sm text-center uppercase">
            List of Organization Per Campus
          </p>
        </aside>

        <aside class="mt-4 item-min-h" v-if="selected_campus.campus_advisers.length > 0">
          <div v-for="(item, index) in selected_campus.campus_advisers" :key="item">
            <span class="text-black w-8 inline-block"> </span>
            <p class="px-6 uppercase mb-2">
              {{ selected_campus.name }}
            </p>

            <aside v-if="item.organizations.length > 0">
              <div
                v-for="(o, indexo) in item.organizations"
                :key="o"
                class="flex items-center px-6 text-sm"
              >
                <span class="text-black w-8 inline-block"> {{ indexo + 1 }}. </span>
                <p class="uppercase">
                  {{ o.name }}
                </p>
              </div>
            </aside>
          </div>
        </aside>
      </div>
    </div>
  </SkDialog>
</template>

<script>
import adminlayout from "../../layouts/adminlayout.vue";

export default {
  components: {
    adminlayout,
  },
};
</script>

<style scoped>
.item-min-h {
  min-height: 40vh;
}

@media print {
  #organization-percampus {
  }
}
</style>
