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
        <div class="logo-colors text-2xl px-2 rounded tracking-widest">U</div>
        <span class="px-1 pb-0.5 text-sm">𝓼𝓮𝓻</span>
        <div class="logo-colors text-2xl px-2 rounded tracking-widest ms-2">R</div>
        <span class="px-1 pb-0.5 text-sn">𝓮𝓼𝓾𝓶𝓮</span>
    </div>
    <div v-else class="flex flex-row justify-start items-end text-gray-500 gap-0">
        <div class="logo-colors px-2 rounded tracking-widest">U</div>
        <span class="px-1 pb-1 text-xs">𝓼𝓮𝓻</span>
        <div class="logo-colors px-2 rounded tracking-widest ms-2">R</div>
        <span class="px-1 pb-1 text-xs">𝓮𝓼𝓾𝓶𝓮</span>
    </div>
</template>

<style scoped>

</style>
