<script setup>
import { defineProps } from "vue";

const props = defineProps({
  headers: {
    type: Array,
    default: ["", "first name", "Last name", ""],
  },
});
</script>

<template>
   <div class="mt-8 flow-root">
              <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                  <table class="min-w-full divide-y divide-gray-300 ">
                    <thead class="  rounded">
                      <tr class="divide-x divide-gray-200 ">
                        <th
                        v-for="item in headers" :key="item"
                          scope="col"
                          class="py-3.5 pl-4 pr-6 text-center text-l  text-gray-800 "
                        >
                        {{ item }}
                        </th>
                    
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">

                    <slot>
                    
                    </slot>
                      <!-- <tr
                        class="divide-x divide-gray-200"
                        v-for="item in props.years.data"
                        :key="item.id"
                      >
                        <td
                          class="whitespace-nowrap align-center text-center text-sm items-center  font-medium text-gray-900 "
                        >
                          <input
                            v-model="selected_school_year"
                            :value="item.id"
                            type="checkbox"
                            class="h-4 w-4 accent-green-600 text-white rounded border-gray-200"
                          />
                        </td>
                        <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                          SY.{{ item.from }} - {{ item.to }}
                        </td>

                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-6 text-sm text-gray-500 sm:pr-0"
                        ></td>
                      </tr> -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
</template>

<style scoped>

</style>
