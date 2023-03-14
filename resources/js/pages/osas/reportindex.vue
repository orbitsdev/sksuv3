<script setup>
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

const search = ref("");
</script>
<template>
  <adminlayout>
   

    <div class="bg-white rounded-xl shadow-xl mx-auto max-w-7xl l">
      <div class="grid grid-cols-3">
        <Link
          :href="route('osas.generatecerticate.certificate.index')"
          class="ounded-tr-lg group relative h-56 flex items-center justify-center flex-col p-6 focus-within:ring-2 focus-within:ring-inset hover:bg-gray-100"
        >
          <div class="text-center">
            <span
              class="inline-flex rounded-lg p-3 bg-teal-50 text-teal-700 ring-4 ring-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-6 h-6"
              >
                <path
                  fill-rule="evenodd"
                  d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813A3.75 3.75 0 007.466 7.89l.813-2.846A.75.75 0 019 4.5zM18 1.5a.75.75 0 01.728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 010 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 01-1.456 0l-.258-1.036a2.625 2.625 0 00-1.91-1.91l-1.036-.258a.75.75 0 010-1.456l1.036-.258a2.625 2.625 0 001.91-1.91l.258-1.036A.75.75 0 0118 1.5zM16.5 15a.75.75 0 01.712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 010 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 01-1.422 0l-.395-1.183a1.5 1.5 0 00-.948-.948l-1.183-.395a.75.75 0 010-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0116.5 15z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
          </div>
          <div class="mt-4 text-center">
            <h3 class="text-lg font-medium">
              <a href="#" class="focus:outline-none">
                <!-- Extend touch target to entire panel -->
                <span class="absolute inset-0" aria-hidden="true"></span>
                Generate Certificate
              </a>
            </h3>
            <p class="text-sn text-gray-500">
              Generate certificate for oganizations 
            </p>
          </div>
        </Link>

        <Link
        :href="route('osas.print.lisoforganizationpercampus.index')"
          class="rounded-tr-lg group relative h-56 flex items-center justify-center flex-col p-6 focus-within:ring-2 focus-within:ring-inset hover:bg-gray-100"
        >
          <div class="text-center">
            <span
              class="inline-flex rounded-lg p-3 bg-purple-50 text-purple-700 ring-4 ring-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-6 h-6"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 003 3h.27l-.155 1.705A1.875 1.875 0 007.232 22.5h9.536a1.875 1.875 0 001.867-2.045l-.155-1.705h.27a3 3 0 003-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0018 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM16.5 6.205v-2.83A.375.375 0 0016.125 3h-8.25a.375.375 0 00-.375.375v2.83a49.353 49.353 0 019 0zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 01-.374.409H7.232a.375.375 0 01-.374-.409l.526-5.784a.373.373 0 01.333-.337 41.741 41.741 0 018.566 0zm.967-3.97a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H18a.75.75 0 01-.75-.75V10.5zM15 9.75a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V10.5a.75.75 0 00-.75-.75H15z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
          </div>
          <div class="mt-4 text-center">
            <h3 class="text-lg font-medium">
              <a href="#" class="focus:outline-none">
                <!-- Extend touch target to entire panel -->
                <span class="absolute inset-0" aria-hidden="true"></span>
                List of Organization
              </a>
            </h3>
            <p class="text-sn text-gray-500">Print List of Organizations</p>
          </div>
        </Link>

        <Link
        :href="route('osas.print.listofsubmitteddocuments.index')"
          class="rounded-tr-lg group relative h-56 flex items-center justify-center flex-col p-6 focus-within:ring-2 focus-within:ring-inset hover:bg-gray-100"
        >
          <div class="text-center">
            <span
              class="inline-flex rounded-lg p-3 bg-sky-50 text-sky-700 ring-4 ring-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-6 h-6"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 003 3h15a3 3 0 01-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125zM12 9.75a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H12zm-.75-2.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H12a.75.75 0 01-.75-.75zM6 12.75a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5H6zm-.75 3.75a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM6 6.75a.75.75 0 00-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-3A.75.75 0 009 6.75H6z"
                  clip-rule="evenodd"
                />
                <path
                  d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 01-3 0V6.75z"
                />
              </svg>
            </span>
          </div>
          <div class="mt-4 text-center">
            <h3 class="text-lg font-medium">
              <a href="#" class="focus:outline-none">
                <!-- Extend touch target to entire panel -->
                <span class="absolute inset-0" aria-hidden="true"></span>
                Document Submitted
              </a>
            </h3>
            <p class="text-sn text-gray-500">Print Submitted Documents</p>
          </div>
        </Link>
      </div>
    </div>
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
