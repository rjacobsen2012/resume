<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ResumeViewLayout from "@/Layouts/ResumeViewLayout.vue";

const props = defineProps({
    resume: [Array, Object],
});

const title = props.resume.name + "'s Resume"

const pageLinks = [
    { name: title, active: true },
];

</script>

<template>
    <ResumeViewLayout :resume="resume">Test</ResumeViewLayout>
<!--    <AppLayout :title="title" :links="pageLinks">-->
<!--        <div class="container-fluid">-->
<!--            <div class="resume-title pl-4 pt-3">{{ getResumeUserProperty('name', 'Unknown') }}</div>-->
<!--            <div class="resume-contact info work-examples pl-4">-->
<!--                <b-link :href="`mailto:${getResumeUserProperty('email')}`" title="Email" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>{{ getResumeUserProperty('email') }}</strong><span class="pl-2"><font-awesome-icon icon="envelope"/></span></b-link>-->
<!--                <b-link :href="`tel:${getResumeUserProperty('phone')}`" title="Call" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>{{ getResumeUserProperty('phone') }}</strong><span class="pl-2"><font-awesome-icon icon="phone-square"/></span></b-link>-->
<!--                <b-link @click="downloadResume" title="PDF Resume" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>pdf resume</strong><span class="pl-2"><font-awesome-icon icon="file-pdf"/></span></b-link>-->
<!--                <b-link @click="downloadResumeWord" title="Word Resume" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>word resume</strong><span class="pl-2"><font-awesome-icon icon="file-word"/></span></b-link>-->
<!--                <b-link :href="getResumeUserProperty('github_profile', '#')" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>github profile</strong><span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>-->
<!--                <b-link :href="getResumeUserProperty('linked_in_profile', '#')" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>linkedin profile</strong><span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>-->
<!--            </div>-->
<!--            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">SKILLS</div></div>-->
<!--            <div class="info skills pt-3 pb-0 pl-4">-->
<!--                <div v-for="skill in getResumeUserProperty('skills', [])" :key="skill.id" class="skill squared">{{ skill.name }}</div>-->
<!--            </div>-->
<!--            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">WEBSITE EXAMPLES</div></div>-->
<!--            <div class="info work-examples pt-3 pb-0 pl-4">-->
<!--                <b-link v-for="example in getResumeUserProperty('workExamples', [])" :key="example.id" :href="example.url" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>{{ example.title }}</strong><span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>-->
<!--            </div>-->
<!--            <div class="divider resume-education"><div class="divider-block ml-4 pl-3 pr-3">EDUCATION</div></div>-->
<!--            <div class="info educations pt-3">-->
<!--                <div v-for="education in getResumeUserProperty('educations', [])" :key="education.id" class="education pl-4">-->
<!--                    <span @click="toggleEducation(education.id)" class="pointer pb-2"><span class="pr-2"><font-awesome-icon v-if="isEducationVisible(education.id)" icon="caret-down"/><font-awesome-icon v-else icon="caret-right"/></span><strong>{{ education.school }}</strong><span class="pl-2 pr-2">-</span>{{ education.degree }}<span class="pl-2 pr-2">-</span>{{ education.city }}, {{ education.state }}<span class="pl-2 pr-2"><font-awesome-icon icon="calendar-minus"/></span>{{ getDate(education) }}</span>-->
<!--                    <ul v-show="isEducationVisible(education.id)" v-html="getEducationDescription(education)" class="pt-2 pb-2"></ul>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">EXPERIENCE</div></div>-->
<!--            <div class="info experiences pt-3 pb-3">-->
<!--                <div v-for="experience in getResumeExperience()" :key="experience.id" class="experience pl-4">-->
<!--                    <span @click="toggleExperience(experience.id)" class="pointer pb-2"><span class="pr-2"><font-awesome-icon v-if="isExperienceVisible(experience.id)" icon="caret-down"/><font-awesome-icon v-else icon="caret-right"/></span><strong>{{ experience.company_name }}</strong><span class="pl-2 pr-2">-</span>{{ experience.title }}<span class="pl-2 pr-2">-</span>{{ experience.city }}, {{ experience.state }}<span class="pl-2 pr-2"><font-awesome-icon icon="calendar-minus"/></span>{{ getDate(experience) }}</span>-->
<!--                    <ul v-show="isExperienceVisible(experience.id)" v-html="getDescription(experience)" class="pt-2 pb-2"></ul>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </AppLayout>-->
</template>

<style scoped>

</style>
