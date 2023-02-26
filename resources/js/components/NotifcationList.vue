

<template>

<ul role="list" class="divide-y divide-gray-200">
  <li class="flex py-4" v-for="item in notfication" :key="item">
    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
    <div class="ml-3">
      <p class="text-sm font-medium text-gray-900">Calvin Hawkins</p>
      <p class="text-sm text-gray-500">calvin.hawkins@example.com</p>
    </div>
  </li>

  
</ul>
</template>

<script>
    export default {
        props: {
            notfication: {
                type: Array,
                default: [],
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>