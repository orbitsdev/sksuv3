


<script setup>


import { ref, watch, defineProps, defineComponent } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";


const props = defineProps({
  requirements: Object,
  filters: Object,
});

const search = ref(props.filters.search);


watch(
  search,
  throttle((value) => {
    router.get(
      route("template.index"),
      { search: value },
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
    

       <table 
       
         v-if="props.requirements.data.length > 0"
       class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th class="bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900" scope="col">REQUIREMENTS</th>
                      <th class="bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900" scope="col"></th>
                      <th class="bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900" scope="col">TEMPLATES</th>
                      <th class="bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900" scope="col"></th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                
                    <tr class="bg-white" v-for="item in props.requirements.data" :key="item">
                      <td class="w-full max-w-0 whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                        <div class="flex">
                          <p  class="group inline-flex space-x-2 truncate text-sm">
                          

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 flex-shrink-0 text-green-700 group-hover:text-green-800">
  <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z" clip-rule="evenodd" />
  <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
</svg>


                            <p class="truncate text-gray-900">{{ item.name }}</p>
                          </p>
                        </div>
                      </td>
                      <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-500">
                       
                      </td>
                     
                      <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-500">
                            <div v-if="item.files.length > 0">
                                    <div class="mb-1" v-for="file in item.files" :key="file" :file="file">
                <a
                  target="_blank"
                  :href="file.file_url"
                  class=" cursor-pointer bg-gray-200 hover:bg-blue-600 hover:text-white text-gray-700  py-2 px-4 rounded inline-flex items-center"
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

                            <span v-else>
                                                    NONE

                            </span>

                      </td>
                      <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-500">
                      </td>
                     
                     
                    </tr>

                    <!-- More transactions... -->
                  </tbody>
                </table>

                      <EmptyCard class="flex items-center justify-center h-64" v-else />

                         <div class="mt-6 py-4 bg-white" v-if="$props.requirements.links.length > 0">
        <Pagination
          v-if="$props.requirements.data.length > 0"
          class="block"
          :links="$props.requirements.links"
        />
      </div>
    </div> 
    </adminlayout>
</template>



<script>


import adminlayout from "../../layouts/adminlayout.vue";

export default {
  components: {

    adminlayout,
  },
};
</script>


<style lang="scss" scoped>

</style>