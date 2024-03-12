<script setup>
defineProps({
    type: {
        type: String,
    }
});
</script>

<template>
    <button :type="type">
        <slot />
    </button>
</template>
