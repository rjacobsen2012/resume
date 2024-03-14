<script setup>
const props = defineProps({
    href: String,
    title: String,
    active: Boolean,
});
</script>

<template>
    <div class="px-2 py-1 bg-gray-50 dark:bg-gray-700 rounded">
        <a v-if="! active" :href="href"
           class="nav-link text-gray-600 dark:text-gray-400"
           :title="title">
            <slot/>
        </a>
        <span v-else class="nav-link text-gray-600 dark:text-gray-400 disabled">
            <slot/>
        </span>
    </div>
</template>

<style scoped>

</style>
