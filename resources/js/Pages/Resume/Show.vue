<script setup>
import ResumeViewLayout from "@/Layouts/ResumeViewLayout.vue";
import ALink from "@/Components/ALink.vue";
import moment from "moment";
import {ref} from "vue";

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
        return moment(item.started_at).format("MMM YYYY") + ' - Now'
    }

    return moment(item.started_at).format("MMM YYYY") + ' - ' + moment(item.ended_at).format("MMM YYYY")
}

</script>

<template>
    <ResumeViewLayout :resume="resume" :title="`${resume.user.name}'s Resume`">
        <div class="container-fluid theme-text">
            <div class="ps-0 py-2 pt-0 text-4xl font-extrabold">{{ resume.name }}</div>
            <div class="divider"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-sm">PROFILE</div></div>
            <div class="flex flex-row justify-start items-center gap-4 mt-4">
                <div class="">
                    <img v-if="resume.user.gravatar" :src="resume.user.gravatar" class=""/>
                </div>
                <div class="">
                    <div class="text-lg sm:text-2xl font-bold text-gray-400 dark:text-gray-300">{{ resume.title }}</div>
                    <div class="text-sm sm:text-lg font-thin">{{ resume.city }}, {{ resume.state }}, {{ resume.country }}</div>
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
                        <li class="pt-2">
                            <a-link :href="`tel:${resume.phone}`" title="Phone" target="_blank">
                                <i class="fa fa-phone-square"/>{{ resume.phone }}
                            </a-link>
                        </li>
                        <li class="pt-2">
                            <a-link :href="route('resume.download', [resume.id, 'pdf'])" title="Download PDF Resume" target="_blank">
                                <i class="fa fa-file-pdf"/>PDF Resume
                            </a-link>
                        </li>
                        <li class="pt-2">
                            <a-link :href="route('resume.download', [resume.id, 'word'])" title="Download Word Resume" target="_blank">
                                <i class="fa fa-file-word"/>Microsoft Word Resume
                            </a-link>
                        </li>
                        <li class="pt-2">
                            <a-link :href="resume.github_profile" title="Github Profile" target="_blank">
                                <i class="fa-brands fa-github"/>Github Profile
                            </a-link>
                        </li>
                        <li class="pt-2">
                            <a-link :href="resume.linked_in_profile" title="LinkedIn Profile" target="_blank">
                                <i class="fa-brands fa-linkedin"/>LinkedIn Profile:
                            </a-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="divider my-3"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-sm">SKILLS</div></div>
            <div class="py-1 text-xs">
                <div v-for="skill in resume.skills" :key="skill.id" class="inline-block rounded-full px-1.5 font-semibold me-2 mb-2 bg-gray-200 dark:bg-gray-700 shadow-sm">{{ skill.name }}</div>
            </div>
            <div class="divider my-3"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-sm">WEBSITE EXAMPLES</div></div>
            <div class="ps-0 font-thin text-sm">
                <ul>
                    <li v-for="example in resume.examples" :key="example.id">
                        <a-link :href="example.url" :title="example.title" target="_blank">
                            {{ example.title }}<i class="fa fa-external-link-alt"/>
                        </a-link>
                    </li>
                </ul>
            </div>
            <div class="divider my-3"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-sm">EDUCATION</div></div>
            <div class="ps-0 font-thin text-sm">
                <div v-for="(education, index) in resume.educations" :key="education.id" class="education pt-2">
                    <span @click="toggleEducation(education.id)" class="cursor-pointer pb-2 font-extrabold text-md">
                        <span class="pe-2">
                            <i v-if="isEducationVisible(education.id)" class="fa fa-caret-down"/>
                            <i v-else class="fa fa-caret-right"/>
                        </span>
                        <strong>{{ education.school }}</strong>
                        <span class="ps-2 pe-1">-</span>
                        {{ education.degree }}
                        <span class="ps-1 pe-1">-</span>
                        {{ education.city }}, {{ education.state }}
                        <span class="ps-2 pe-2">
                            <i class="fa fa-calendar-minus"/>
                        </span>{{ getDate(education) }}
                    </span>
                    <div v-if="isEducationVisible(education.id)" class="bg-gray-200 dark:bg-gray-900 border-2 border-gray-300 dark:border-gray-600 mt-1">
                        <ul v-html="getDescription(education)" class="list-disc font-thin text-sm text-gray-600 dark:text-gray-400 pt-2 pb-2 ms-4"></ul>
                    </div>
                    <div v-if="! isEducationVisible(education.id) && index < (resume.educations.length - 1)" class="bg-gray-900 border-t-2 border-gray-300 dark:border-gray-600 mt-1"></div>
                </div>
            </div>
            <div class="divider my-3"><div class="divider-block ms-4 ps-3 pe-3 uppercase text-sm">EXPERIENCE</div></div>
            <div class="ps-0 font-thin text-sm">
                <div v-for="(experience, index) in resume.experiences" :key="experience.id" class="experience pt-2">
                    <span @click="toggleExperience(experience.id)" class="cursor-pointer pb-2 font-extrabold text-md">
                        <span class="pe-2">
                            <i v-if="isExperienceVisible(experience.id)" class="fa fa-caret-down"/>
                            <i v-else class="fa fa-caret-right"/>
                        </span>
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
                    <div v-if="isExperienceVisible(experience.id)" class="bg-gray-200 dark:bg-gray-900 border-2 border-gray-300 dark:border-gray-600 mt-3">
                        <ul v-html="getDescription(experience)" class="list-disc font-thin text-sm text-gray-600 dark:text-gray-400 pt-1 pb-2 ms-4"></ul>
                    </div>
                    <div v-if="! isExperienceVisible(experience.id) && index < (resume.experiences.length - 1)" class="bg-gray-900 border-t-2 border-gray-300 dark:border-gray-600 mt-3"></div>
                </div>
            </div>
        </div>
    </ResumeViewLayout>
</template>

<style scoped>

</style>
