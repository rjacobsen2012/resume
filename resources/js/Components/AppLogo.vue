<script setup>

const props = defineProps({
    small: {
        type: Boolean,
        default: false,
    },
});

</script>

<template>
    <div v-if="! small" class="flex flex-row justify-start items-end text-gray-500 gap-0">
        <div class="text-4xl logo-colors px-1 rounded">U</div>
        <span class="px-1 pb-1.5">𝓼𝓮𝓻</span>
        <div class="text-4xl logo-colors px-1 rounded">R</div>
        <span class="px-1 pb-1.5">𝓮𝓼𝓾𝓶𝓮</span>
    </div>
    <div v-else class="flex flex-row justify-start items-end text-gray-500 gap-0">
        <div class="text-2xl logo-colors px-1 rounded">U</div>
        <span class="px-1 pb-1.5 text-xs">𝓼𝓮𝓻</span>
        <div class="text-2xl logo-colors px-1 rounded">R</div>
        <span class="px-1 pb-1.5 text-xs">𝓮𝓼𝓾𝓶𝓮</span>
    </div>
</template>

<style scoped>

</style>
