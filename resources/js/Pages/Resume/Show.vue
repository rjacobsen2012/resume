<script setup>
import ALink from "@/Components/ALink.vue";
import moment from "moment";
import {ref} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    resume: [Array, Object],
});

const title = props.resume.name + "'s Resume"

const pageLinks = [
    { name: title, active: true },
];

const experiencesShown = ref([]);
const educationsShown = ref([]);

const isExperienceVisible = (experienceId) => {
    const found = experiencesShown.value.filter(id => id === experienceId)
    return found.length > 0
}

const toggleExperience = (experienceId) => {
    if (isExperienceVisible(experienceId)) {
        experiencesShown.value = experiencesShown.value.filter(id => id !== experienceId)
    } else {
        experiencesShown.value.push(experienceId)
    }
}

const isEducationVisible = (educationId) => {
    const found = educationsShown.value.filter(id => id === educationId)
    return found.length > 0
}

const toggleEducation = (educationId) => {
    if (isEducationVisible(educationId)) {
        educationsShown.value = educationsShown.value.filter(id => id !== educationId)
    } else {
        educationsShown.value.push(educationId)
    }
}

const getDescription = (item) => {
    if (item.description.includes('-')) {
        const parts = item.description.split('-')
        let description = ''

        for (let i = 0; i < parts.length; i++) {
            if (i) {
                description = description + '<li class="pt-2">' + parts[i] + '</li>'
            }
        }

        return description
    }

    return '<li class="pt-2">' + item.description + '</li>'
}

const getDate = (item) => {
    if (item.present) {
        return moment(item.started_at).format("MMM YYYY") + ' - Present'
    }

    return moment(item.started_at).format("MMM YYYY") + ' - ' + moment(item.ended_at).format("MMM YYYY")
}

</script>

<template>
    <AppLayout :resume="resume" :title="`${resume.user.name}'s Resume`">
        <div class="container-fluid theme-text">
            <div class="ps-0 py-2 pt-0 text-4xl font-extrabold">{{ resume.name }}</div>
            <div class="divider mt-4"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-md">PROFILE</div></div>
            <div class="flex flex-row justify-start items-center gap-4 mt-4">
                <div>
                    <img v-if="resume.user.gravatar" :src="resume.user.gravatar"/>
                </div>
                <div>
                    <div v-if="resume.title" class="text-lg sm:text-2xl font-bold text-gray-400 dark:text-gray-300">{{ resume.title }}</div>
                    <div class="text-sm sm:text-lg font-thin">
                        <span v-if="resume.city">{{ resume.city }}</span>
                        <span v-if="resume.state">
                            <span v-if="resume.city">, </span>{{ resume.state }}
                        </span>
                        <span v-if="resume.country">
                            <span v-if="resume.city || resume.state">, </span>{{ resume.country }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="ps-0 pt-3 font-thin text-sm">
                <div>
                    <ul class="w-72">
                        <li>
                            <a-link :href="`mailto:${resume.email}`" title="Email" target="_blank">
                                <i class="fa fa-envelope"/>{{ resume.email }}
                            </a-link>
                        </li>
                        <li v-if="resume.phone" class="pt-2">
                            <a-link :href="`tel:${resume.phone}`" title="Phone" target="_blank">
                                <i class="fa fa-phone-square"/>{{ resume.phone }}
                            </a-link>
                        </li>
                        <li v-if="resume.pdf_resume" class="pt-2">
                            <a-link :href="route('resume.download', [resume.id, 'pdf'])" title="Download PDF Resume" target="_blank">
                                <i class="fa fa-file-pdf"/>PDF Resume
                            </a-link>
                        </li>
                        <li v-if="resume.word_resume" class="pt-2">
                            <a-link :href="route('resume.download', [resume.id, 'word'])" title="Download Word Resume" target="_blank">
                                <i class="fa fa-file-word"/>Microsoft Word Resume
                            </a-link>
                        </li>
                        <li v-if="resume.github_profile" class="pt-2">
                            <a-link :href="resume.github_profile" title="Github Profile" target="_blank" class="text-nowrap">
                                <i class="fa-brands fa-github"/>Github Profile: {{ resume.github_profile }}
                            </a-link>
                        </li>
                        <li v-if="resume.linked_in_profile" class="pt-2">
                            <a-link :href="resume.linked_in_profile" title="LinkedIn Profile" target="_blank" class="text-nowrap">
                                <i class="fa-brands fa-linkedin"/>LinkedIn Profile: {{ resume.linked_in_profile }}
                            </a-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div v-if="resume.skills.length > 0" class="divider my-3 mt-4"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-md">SKILLS</div></div>
            <div v-if="resume.skills.length > 0" class="py-1 text-sm">
                <div v-for="skill in resume.skills" :key="skill.id" class="inline-block rounded-full px-1.5 font-semibold me-2 mb-2 bg-gray-200 dark:bg-gray-700 shadow-sm">{{ skill.display }}</div>
            </div>
            <div v-if="resume.examples.length > 0" class="divider my-3 mt-4"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-md">WEBSITE EXAMPLES</div></div>
            <div v-if="resume.examples.length > 0" class="ps-0 font-thin text-sm">
                <ul>
                    <li v-for="example in resume.examples" :key="example.id">
                        <a-link :href="example.url" :title="example.title" target="_blank">
                            {{ example.title }}<i class="fa fa-external-link-alt"/>
                        </a-link>
                    </li>
                </ul>
            </div>
            <div v-if="resume.educations.length > 0" class="divider my-3 mt-4"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-md">EDUCATION</div></div>
            <div v-if="resume.educations.length > 0" class="ps-0 font-thin text-lg">
                <div v-for="(education, index) in resume.educations" :key="education.id" class="education pt-2">
                    <span class="pb-2 font-extrabold text-md">
                        <strong>{{ education.school }}</strong>
                        <span class="ps-2 pe-1">-</span>
                        {{ education.degree }}
                        <span class="ps-1 pe-1">-</span>
                        {{ education.city }}, {{ education.state }}
                        <span class="ps-2 pe-2">
                            <i class="fa fa-calendar-minus"/>
                        </span>{{ getDate(education) }}
                    </span>
                    <div class="bg-gray-200 dark:bg-gray-900 border-2 border-gray-300 dark:border-gray-600 mt-3">
                        <ul v-html="getDescription(education)" class="list-disc font-thin text-sm text-gray-600 dark:text-gray-400 pt-1 pb-2 ms-4"></ul>
                    </div>
                </div>
            </div>
            <div v-if="resume.experiences.length > 0" class="divider my-3 mt-4"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-md">EXPERIENCE</div></div>
            <div v-if="resume.experiences.length > 0" class="ps-0 font-thin text-lg">
                <div v-for="(experience, index) in resume.experiences" :key="experience.id" class="experience pt-2">
                    <span class="pb-2 font-extrabold text-md">
                        <strong>{{ experience.company_name }}</strong>
                        <span class="ps-2 pe-1">-</span>
                        {{ experience.title }}
                        <span class="ps-1 pe-1">-</span>
                        {{ experience.city }}, {{ experience.state }}
                        <span class="ps-2 pe-2">
                            <i class="fa fa-calendar-minus"/>
                        </span>
                        {{ getDate(experience) }}
                    </span>
                    <div class="bg-gray-200 dark:bg-gray-900 border-2 border-gray-300 dark:border-gray-600 mt-3">
                        <ul v-html="getDescription(experience)" class="list-disc font-thin text-sm text-gray-600 dark:text-gray-400 pt-1 pb-2 ms-4"></ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
