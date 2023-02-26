<script setup>
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/core";
import { throttle } from "lodash";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  organization: Object,
});

const item = ref(props.organization);

const form = useForm({
  name: "",
  campus_adviser_id: null,
  id: null,
});
</script>

<template>
  <div class="form-max-h overflow-y-auto">
    <div class="">
      <label for="email" class="block te font-medium text-gray-700"
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





    <p class="mt-2 uppercase  leading-8 text-black font-medium">Requirements</p>
    <div v-if="organization.requirements.length > 0">
           <!-- {{ organization.organization_requirements }} -->
    <aside class="my-1" v-for="r in organization.requirements" :key="r">


    <div>
      <p class="text-gray-900 mb-1 capitalize">{{ r.name }}</p>
      <div class="bg-gradient-to-r from-lime-50 to-green-100 py-2 px-2 rounded">
        <!-- <FileCard class="mt-1 mr-1"> {{r}}</FileCard> -->
        

      </div>
 
      <FileUpload :model_id="r.id"/>
    </div>
    </aside>

    
    </div>


  </div>
</template>

<script></script>

<style lang="scss" scoped>
.form-max-h {
  max-height: 85vh;
}

/* ===== Scrollbar CSS ===== */
/* Firefox */
.form-max-h {
  scrollbar-width: auto;
  scrollbar-color: #d2d2d4 #ffffff;
}

.form-max-h::-webkit-scrollbar {
  width: 12px;
  height: 200px !important;
}

.form-max-h::-webkit-scrollbar-track {
  background: #ffffff;
}

.form-max-h::-webkit-scrollbar-thumb {
  background-color: #dedee4;
  border-radius: 10px;
  border: 3px solid #ffffff;
}
.dialog-error {
  padding: 10px;
  max-height: 85vh;
  overflow-y: auto;
}
</style>
