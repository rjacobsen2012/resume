<script setup>
const props = defineProps({
    iconClass: String,
});
</script>

<template>
    <span>
        <i :class="iconClass"></i>
    </span>
</template>

<style scoped>

</style>
