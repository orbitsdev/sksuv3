



<template>


<div
    v-if="status == 'false' "
      
                          class="flex items-center justify-center bg-gradient-to-r mt-2 py-1 px-2 rounded from-gray-100 to-gray-200 text-gray-400 uppercase"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-2">
  <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
</svg>


                          <p class="text-xs">Not Yet Endorsed</p>
                        </div>
   <div
    v-if="status == 'true' "
      
                          class="flex items-center justify-center bg-gradient-to-r mt-2 py-1 px-2 rounded from-green-400 to-green-600 text-white uppercase"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-2">
  <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
</svg>

                          <p class="text-xs">Endorsed</p>
                        </div>
</template>

<script>
    export default {

        props: {
            status: {
      type: String,
      default: "false",
    },
        },
        
    }
</script>

<style lang="scss" scoped>

</style>