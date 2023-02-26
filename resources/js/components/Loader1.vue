




<template>
    <span class="loading"><i class="fa fa-refresh mr-3"></i></span>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>
.loading i.fa-refresh {
    animation: spin 700ms linear infinite;
  }
  
  @keyframes spin {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
</style>