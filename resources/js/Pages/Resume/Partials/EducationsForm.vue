<script setup>

import FormSection from "@/Components/FormSection.vue";

const props = defineProps({
    resume: [Array, Object],
    educations: [Array, Object],
});
</script>

<template>
    <FormSection>
        <template #title>
            Educations
        </template>

        <template #description>
            Past and present educations along with degrees.
        </template>

        <template #form>

        </template>
    </FormSection>
</template>

<style scoped>

</style>