<script setup>

import FormSection from "@/Components/FormSection.vue";

const props = defineProps({
    resume: [Array, Object],
    examples: [Array, Object],
});
</script>

<template>
    <FormSection>
        <template #title>
            Work Examples
        </template>

        <template #description>
            Work examples of past employers or businesses.
        </template>

        <template #form>

        </template>
    </FormSection>
</template>

<style scoped>

</style>