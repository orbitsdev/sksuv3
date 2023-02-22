<template>
    <div>
        <Component

        :is="link.url ? 'Link' : 'span' "
        v-for="link  in links"
        :key="link"
        :href="link.url"
        v-html="link.label"
        :class="['px-4 py-2 mx-0.5 border rounded ', link.url ? '': 'text-gray-500 ', link.active ? 'bg-green-700 text-white': '']"

        >
        </Component>
    </div>
</template>

<script>
    export default {
        props: {
            links: Array
        }
    }
</script>

<style lang="scss" scoped>

</style>