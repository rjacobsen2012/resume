<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    resume: [Array, Object],
});

const title = props.resume.name + "'s Resume"

const pageLinks = [
    { name: title, active: true },
];

</script>

<template>
    <AppLayout :title="title" :links="pageLinks">
        Resume to display here
    </AppLayout>
</template>

<style scoped>

</style>