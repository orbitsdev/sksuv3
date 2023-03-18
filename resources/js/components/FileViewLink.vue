

<template>
  
   <!-- <a    target="_blank"
   
       class="cursor-pointer bg-gray-300 hover:bg-blue-600 hover:text-white text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center"
    >
              <div class="flex w-0 flex-1 items-center">
             



                <span class="ml-2 w-0 flex-1 truncate"><slot></slot></span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
  <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
</svg>
              </div>
              <div class="ml-4 flex-shrink-0">
                <p  class="font-medium "> DOWNLOAD</p>
              </div>
            </a> -->


             <a
                  target="_blank"

                  class="cursor-pointer  bg-gray-100 hover:bg-blue-600   hover:text-white text-blue-500  py-2 px-4 rounded inline-flex items-center"
                >
                  <svg
                    class="fill-current w-5 h-5 mr-3 "
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                  </svg>
                  <span class="text-ellipsis"> <slot> File</slot></span>
                </a>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>