

<template>
 
      
      <w-dialog
        :model-value="isOpen"
        :content-class="contentClass"
        :dialog-class="dialogClass"
        :full-screen="fullScreen"
        :peristent="peristent"
        :overlay-color="overlayColor"
        :width="width"
        :transition="transition"
        title="">

        
            <div>
                <slot></slot>
            </div>
     
</w-dialog>
</template>

<script>
    export default {
        

        props: {
            isOpen: {
                type: Boolean,
                default: false,
            },
            contentClass: {
                type: String,
                default: '',
            },
            dialogClass: {
                type: String,
                default: '',
            },
            fullScreen: {
                type: Boolean,
                default: false,
            },
            peristent: {
                type: Boolean,
                default: false,
            },

            overlayColor: {
                type: String,
                default: 'rgba(0,0,0, 0.50)',
            },
            width: {
                type: String,
                default: '540',
            },
            transition: {
                type: String,
                default: 'slide-up',
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>