
<template>
    

     <Link  :class="[' group inline-flex items-center py-4 px-1 font-medium text-sm', active ? 'border-green-500 text-green-600  border-b-2' : 'border-transparent text-gray-500 hover:text-gray-700  group inline-flex items-center py-4 px-1  font-medium text-sm']" aria-current="page">
          
          <slot>
          </slot>

        </Link>
</template>

<script>
export default {

    props: {
        active: {
            type: Boolean,
            default: false,
        }
    }
};
</script>

<style lang="scss" scoped></style>
