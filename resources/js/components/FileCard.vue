








<template>

          <div class="">
            <div
           
              class="hover:scale-105 transition-all cursor-pointer ease-in-out mb-2 center relative inline-block select-none whitespace-nowrap rounded-lg bg-gradient-to-tr from-gray-700 to-gray-800 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white"
              data-dismissible="chip"
            >
              <div class="mr-5 mt-px"><slot> Word.docx</slot></div>
              <button
                class="absolute top-1 right-1 mx-px mt-[0.5px] w-max rounded-md bg-rose-800 transition-colors hover:bg-rose-900"
                data-dismissible-target="chip"
              >
                <div role="button" class="h-5 w-5 p-1">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="3"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"
                    ></path>
                  </svg>
                </div>
              </button>
            </div>

          </div>

      
       
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>