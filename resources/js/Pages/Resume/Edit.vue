<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateResumeForm from "@/Pages/Resume/Partials/UpdateResumeForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import EducationsForm from "@/Pages/Resume/Partials/EducationsForm.vue";
import ExamplesForm from "@/Pages/Resume/Partials/ExamplesForm.vue";
import ExperiencesForm from "@/Pages/Resume/Partials/ExperiencesForm.vue";
import SkillsForm from "@/Pages/Resume/Partials/SkillsForm.vue";

const props = defineProps({
    resume: [Array, Object],
    examples: [Array, Object],
    educations: [Array, Object],
    experiences: [Array, Object],
    skills: [Array, Object],
});

const title = props.resume.name + "'s Resume"

const pageLinks = [
    { name: title, active: true },
];

</script>

<template>
    <AppLayout :title="title" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateResumeForm :user="$page.props.auth.user"/>

                <SectionBorder />
            </div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EducationsForm :resume="resume" :educations="educations"/>

                <SectionBorder />
            </div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <ExamplesForm :resume="resume" :examples="examples"/>

                <SectionBorder />
            </div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <ExperiencesForm :resume="resume" :experiences="experiences"/>

                <SectionBorder />
            </div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <SkillsForm :resume="resume" :skills="skills"/>

                <SectionBorder />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>