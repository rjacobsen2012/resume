<template>
    <layout title="Welcome">
        <template v-slot:default="slotProps">
            <div class="resume-title pl-4 pt-3">{{ getResumeUserProperty('name', 'Unknown') }}</div>
            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">PROFILE</div></div>
            <div class="info profile pt-3 pb-0 pl-4">{{ getResumeUserProperty('profile', 'Unknown') }}</div>
            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">SKILLS</div></div>
            <div class="info skills pt-3 pb-0 pl-4">
                <div v-for="skill in getResumeUserProperty('skills', [])" :key="skill.id" class="skill squared">{{ skill.name }}</div>
            </div>
            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">WORK EXAMPLES</div></div>
            <div class="info work-examples pt-3 pb-0 pl-4">
                <b-link v-for="example in getResumeUserProperty('workExamples', [])" :key="example.id" :href="example.url" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>{{ example.title }}</strong><span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
            </div>
            <div class="divider resume-education"><div class="divider-block ml-4 pl-3 pr-3">EDUCATION</div></div>
            <div class="info educations pt-3">
                <div v-for="education in getResumeUserProperty('educations', [])" :key="education.id" class="education pl-4">
                    <span @click="toggleEducation(education.id)" class="pointer pb-2"><span class="pr-2"><font-awesome-icon v-if="isEducationVisible(education.id)" icon="caret-down"/><font-awesome-icon v-else icon="caret-right"/></span><strong>{{ education.school }}</strong><span class="pl-2 pr-2">-</span>{{ education.degree }}<span class="pl-2 pr-2">-</span>{{ education.city }}, {{ education.state }}<span class="pl-2 pr-2"><font-awesome-icon icon="calendar-minus"/></span>{{ getDate(education) }}</span>
                    <ul v-show="isEducationVisible(education.id)" v-html="getEducationDescription(education)" class="pt-2 pb-2"></ul>
                </div>
            </div>
            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">EXPERIENCE</div></div>
            <div class="info experiences pt-3 pb-3">
                <div v-for="experience in getResumeUserProperty('experiences', [])" :key="experience.id" class="experience pl-4">
                    <span @click="toggleExperience(experience.id)" class="pointer pb-2"><span class="pr-2"><font-awesome-icon v-if="isExperienceVisible(experience.id)" icon="caret-down"/><font-awesome-icon v-else icon="caret-right"/></span><strong>{{ experience.company_name }}</strong><span class="pl-2 pr-2">-</span>{{ experience.title }}<span class="pl-2 pr-2">-</span>{{ experience.city }}, {{ experience.state }}<span class="pl-2 pr-2"><font-awesome-icon icon="calendar-minus"/></span>{{ getDate(experience) }}</span>
                    <ul v-show="isExperienceVisible(experience.id)" v-html="getDescription(experience)" class="pt-2 pb-2"></ul>
                </div>
            </div>
        </template>
    </layout>
</template>

<script>
    import User from '@mixins/user'
    import ResumeUser from '@mixins/resumeUser'
    import Layout from "../../components/layout/Layout";

    export default {
        components: {Layout},
        mixins: [User, ResumeUser],

        data() {
            return {
                actionItems: [],
                experiencesShown: [],
                educationsShown: [],
            }
        },

        methods: {
            getDate(experience) {
                if (experience.present) {
                    return this.$moment(experience.started_at).format("MMM YYYY") + ' - Now'
                }

                return this.$moment(experience.started_at).format("MMM YYYY") + ' - ' + this.$moment(experience.ended_at).format("MMM YYYY")
            },
            getDescription(experience) {
                const parts = experience.description.split('- ')
                let description = ''

                for (let i = 0; i < parts.length; i++) {
                    if (i) {
                        description = description + '<li>' + parts[i] + '</li>'
                    }
                }

                return description
            },
            getEducationDescription(education) {
                if (education.description.includes('-')) {
                    const parts = education.description.split('-')
                    let description = ''

                    for (let i = 0; i < parts.length; i++) {
                        if (i) {
                            description = description + '<li>' + parts[i] + '</li>'
                        }
                    }

                    return description
                }

                return '<li>' + education.description + '</li>'
            },
            toggleExperience(experienceId) {
                if (this.isExperienceVisible(experienceId)) {
                    this.experiencesShown = this.experiencesShown.filter(id => id !== experienceId)
                } else {
                    this.experiencesShown.push(experienceId)
                }
            },
            toggleEducation(educationId) {
                if (this.isEducationVisible(educationId)) {
                    this.educationsShown = this.educationsShown.filter(id => id !== educationId)
                } else {
                    this.educationsShown.push(educationId)
                }
            },
            isExperienceVisible(experienceId) {
                const found = this.experiencesShown.filter(id => id === experienceId)
                return found.length > 0
            },
            isEducationVisible(educationId) {
                const found = this.educationsShown.filter(id => id === educationId)
                return found.length > 0
            },
            getResumeUserProperty(field, defaultValue) {
                if (this.$resumeUser) {
                    return this.$resumeUser[field]
                }

                return defaultValue
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>
