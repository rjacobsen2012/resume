<script setup>

import FormSection from "@/Components/FormSection.vue";

const props = defineProps({
    resume: [Array, Object],
    experiences: [Array, Object],
});
</script>

<template>
    <FormSection>
        <template #title>
            Work Experience
        </template>

        <template #description>
            Current and past work experience.
        </template>

        <template #form>

        </template>
    </FormSection>
</template>

<style scoped>

</style>