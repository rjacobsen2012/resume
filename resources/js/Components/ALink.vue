<script setup>

const props = defineProps({
    href: [String, null],
    title: String,
    active: Boolean,
});
</script>

<template>
    <a v-if="! active"
       :href="href"
       :title="title"
       class="flex flex-row items-center gap-2"
    >
        <slot/>
    </a>
    <span v-else>
        <slot/>
    </span>
</template>

<style scoped>

</style>
