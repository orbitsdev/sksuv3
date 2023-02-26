<script setup>
import { ref, defineComponent, defineProps, defineEmits } from "vue";

import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  model_id: Number,
});

const emit = defineEmits('uploadSuccess','uploadStart','uploadFinish');

const files = ref([]);

const form = useForm({
  model_id: props.model_id,
  name: null,
  file: null,
});

function hanldeFile(e) {
  form.file = e.target.files[0];

  form.post(route("uploadtolocal"), {
    preserveState: true,
    onStart: ()=>{
      emit('uploadStart');
    },
    onSuccess: ()=>{
      emit('uploadSuccess');
    },
    onFinish: ()=>{
      emit('uploadFinish');
    },
  }
  
  );
}
</script>

<template>
  <label
    class="block text-sm font-medium text-gray-900 dark:text-white"
    for="default_size"
    >Default size</label
  >
  <input
    @change="hanldeFile"
    class="block p-2 w-full mb-5 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:placeholder-gray-400"
    type="file"
  />

  <progress v-if="form.progress" :value="form.progress.percentage" max="100">
    {{ form.progress.percentage }}%
  </progress>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
