<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import PlainSection from "@/Components/PlainSection.vue";
import Experience from "@/Pages/Resume/Partials/Experience.vue";

const emit = defineEmits([
    'updated',
    'errors',
]);

const props = defineProps({
    resume: [Array, Object],
    newModel: [Array, Object, null],
});

const form = useForm({
    experiences: usePage().props.resume.experiences
});

const updated = (data) => {
    emit('updated', data);
}

</script>

<template>
    <PlainSection>
        <template #title>
            Work Experience
        </template>

        <template #description>
            Current and past work experience.
        </template>

        <template #content>
            <div>
                <Experience v-if="resume.experiences.length > 0"
                            v-for="(experience, index) in resume.experiences"
                            :key="experience.id"
                            :resume="resume"
                            :model-value="resume.experiences[index]"
                            class="mb-12"
                            @updated="updated"/>
                <Experience :resume="resume" :model-value="newModel" @updated="updated"/>
            </div>
        </template>
    </PlainSection>
</template>

<style scoped>

</style>