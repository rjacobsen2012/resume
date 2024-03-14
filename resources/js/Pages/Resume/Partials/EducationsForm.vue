<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import PlainSection from "@/Components/PlainSection.vue";
import Education from "@/Pages/Resume/Partials/Education.vue";

const emit = defineEmits([
    'updated',
    'errors',
]);

const props = defineProps({
    resume: [Array, Object],
    newModel: [Array, Object, null],
});

const form = useForm({
    educations: usePage().props.resume.educations
});

const updated = (data) => {
    emit('updated', data);
}

</script>

<template>
    <PlainSection>
        <template #title>
            Educations
        </template>

        <template #description>
            Past and present educations along with degrees.
        </template>

        <template #content>
            <div>
                <div v-if="resume.educations.length > 0"
                     v-for="(education, index) in resume.educations"
                     :key="education.id"
                     class="px-4 py-3 dark:bg-gray-800 sm:p-6 shadow sm:rounded-md mb-16">
                    <div class="grid grid-cols-1 gap-6">
                        <Education :resume="resume" :model-value="resume.educations[index]" @updated="updated"/>
                    </div>
                </div>
                <div class="px-4 py-3 dark:bg-gray-800 sm:p-6 shadow sm:rounded-md">
                    <div class="grid grid-cols-1 gap-6">
                        <Education :resume="resume" :model-value="newModel" @updated="updated"/>
                    </div>
                </div>
            </div>
        </template>
    </PlainSection>
</template>

<style scoped>

</style>