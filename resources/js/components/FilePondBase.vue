<script setup>
import { ref, defineComponent } from "vue";

import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";
import FilePondPluginFileImageValidateSize from "filepond-plugin-image-validate-size";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginGetFile from "filepond-plugin-get-file";
import FilePondPluginPdfPreview from "filepond-plugin-pdf-preview";
import FilePondPluginImageOverlay from "filepond-plugin-image-overlay";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond-plugin-get-file/dist/filepond-plugin-get-file.min.css";
import "filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.css";
import "filepond-plugin-image-overlay/dist/filepond-plugin-image-overlay.css";

import vueFilePond from "vue-filepond";

// Create FilePond component
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileImageValidateSize,
  FilePondPluginFileValidateSize,
  FilePondPluginFilePoster,
  FilePondPluginImageOverlay
  //   FilePondPluginGetFile,
  //   FilePondPluginPdfPreview
);

const files = ref([]);
defineComponent({
  FilePond,
});

function handleFilePondInit() {}
function handleFilePondLoad(response) {

    console.log(response);
    console.log("dasdasd");
}
function handleFilePondError() {}
function handleFilePondRevert() {}

</script>

<template>
  <file-pond
    name="test"
    ref="pond"
    class-name="my-pond"
    label-idle="Drop files here..."
    allow-multiple="true"
    accepted-file-types="image/*, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
    v-bind:files="files"
    v-on:init="handleFilePondInit"
    v-bind:server="{
      url: '',
      timeout: 7000,
      process: {
        url: route('uploadtolocal'),
        methods: 'POST',
        headers: {
            'X-CSRF-TOKEN': $page.props.csrf_token
        },
        withCredentials: false,
        onload: handleFilePondLoad,
        onerror: handleFilePondError,
        timeout: 7000,
      },
      revert: handleFilePondRevert,
    }"
  />
</template>

<script>
export default {};
</script>

<style scoped></style>
