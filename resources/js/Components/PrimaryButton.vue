<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    classes: {
        type: String,
        default: 'btn-light',
    },
});
</script>

<template>
    <button :type="type" :class="classes">
        <slot />
    </button>
</template>
