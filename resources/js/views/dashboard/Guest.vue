<template>
    <layout title="Welcome">
        <template v-slot:default="slotProps">
            <div class="resume-title pl-4 pt-3">{{ getResumeUserProperty('name', 'Unknown') }}</div>
            <div class="resume-contact info work-examples pl-4">
                <b-link :href="`mailto:${getResumeUserProperty('email')}`" title="Email" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>{{ getResumeUserProperty('email') }}</strong><span class="pl-2"><font-awesome-icon icon="envelope"/></span></b-link>
                <b-link :href="`tel:${getResumeUserProperty('phone')}`" title="Call" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>{{ getResumeUserProperty('phone') }}</strong><span class="pl-2"><font-awesome-icon icon="phone-square"/></span></b-link>
                <b-link @click="downloadResume" title="PDF Resume" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>pdf resume</strong><span class="pl-2"><font-awesome-icon icon="file-pdf"/></span></b-link>
                <b-link @click="downloadResumeWord" title="Word Resume" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>word resume</strong><span class="pl-2"><font-awesome-icon icon="file-word"/></span></b-link>
                <b-link :href="getResumeUserProperty('github_profile', '#')" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>github profile</strong><span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
                <b-link :href="getResumeUserProperty('linked_in_profile', '#')" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>linkedin profile</strong><span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
            </div>
            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">PROFILE</div></div>
            <div class="info profile pt-3 pb-0 pl-4">
                <b-link :href="`${getResumeUserProperty('profile', 'Unknown')}`" class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>Resume:</strong> <span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
            </div>
            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">SKILLS</div></div>
            <div class="info skills pt-3 pb-0 pl-4">
                <div v-for="skill in getResumeUserProperty('skills', [])" :key="skill.id" class="skill squared">{{ skill.name }}</div>
            </div>
            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">WEBSITE EXAMPLES</div></div>
            <div class="info work-examples pt-3 pb-0 pl-4">
                <b-link v-for="example in getResumeUserProperty('workExamples', [])" :key="example.id" :href="example.url" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>{{ example.title }}</strong><span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
            </div>
            <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">CODE EXAMPLES</div></div>
            <div class="info work-examples pt-3 pb-0 pl-4">
                <b-link :href="`${getResumeUserProperty('github_profile')}?tab=repositories`" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>Github Repositories</strong><span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
                <b-link href="https://github.com/rjacobsen2012/resume" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>Resume:</strong> laravel / vue js<span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
                <b-link href="https://github.com/rjacobsen2012/flight-test-v2" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>Flight Test:</strong> laravel api<span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
                <b-link href="https://github.com/rjacobsen2012/yourbalance" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>YourBalance:</strong> laravel / vue js<span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
                <b-link href="https://github.com/rjacobsen2012/rjacobsen-test" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>Dev Test:</strong> laravel / blade<span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
                <b-link href="https://github.com/rjacobsen2012/laravel-vagrant" target="_blank" :class="[slotProps.textColorSchemeValue, `work-example`, `squared`]"><strong>Laravel Vagrant:</strong> linux / ubuntu / bash / packagist<span class="pl-2"><font-awesome-icon icon="external-link-alt"/></span></b-link>
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
                <div v-for="experience in getResumeExperience()" :key="experience.id" class="experience pl-4">
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
            getResumeExperience() {
                const resumeExperiences = this.getResumeUserProperty('experiences', [])
                return resumeExperiences.filter(experience => { return !experience.hidden})
            },
            getResumeField(field, value) {
                let resumeId = null

                this.$resumeUser.workExamples.forEach((el, index) => {
                    if (el[field] === value) resumeId = index
                })

                if (typeof resumeId !== 'undefined') {
                    return this.$resumeUser.workExamples[resumeId].url
                }

                return ''
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>
