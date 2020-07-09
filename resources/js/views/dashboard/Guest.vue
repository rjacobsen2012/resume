<template>
    <layout title="Welcome">
        <div class="resume-title pl-4 pt-3">{{ getResumeUserProperty('name', 'Unknown') }}</div>
        <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">PROFILE</div></div>
        <div class="info profile pt-2 pb-0 pl-4">{{ getResumeUserProperty('profile', 'Unknown') }}</div>
        <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">SKILLS</div></div>
        <div class="info skills pt-3 pb-0 pl-4">
            <div v-for="skill in getResumeUserProperty('skills', [])" :key="skill.id" class="skill squared">{{ skill.name }}</div>
        </div>
        <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">WORK EXAMPLES</div></div>
        <div class="info work-examples pt-2 pb-0">
            <ul>
                <li v-for="example in getResumeUserProperty('workExamples', [])" :key="example.id">
                    <strong>{{ example.title }}</strong> : <b-link :href="example.url" target="_blank">{{ example.url }}</b-link>
                </li>
            </ul>
        </div>
        <div class="divider resume-profile"><div class="divider-block ml-4 pl-3 pr-3">EXPERIENCE</div></div>
        <div class="info experiences pt-2 pb-3">
            <ul>
                <li v-for="experience in getResumeUserProperty('experiences', [])" :key="experience.id">
                    <span @click="toggleExperience(experience.id)" class="pointer"><strong>{{ experience.company_name }}</strong>  -  {{ experience.title }}  -  {{ experience.city }}, {{ experience.state }}  <font-awesome-icon icon="calendar-minus"/>  {{ getDate(experience) }} <font-awesome-icon v-if="!isExperienceVisible(experience.id)" icon="caret-down"/><font-awesome-icon v-else icon="caret-left"/></span>
                    <ul v-show="isExperienceVisible(experience.id)" v-html="getDescription(experience)" class="pt-2 pb-2"></ul>
                </li>
            </ul>
        </div>
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
                const parts = experience.description.split('-')
                let description = ''

                for (let i = 0; i < parts.length; i++) {
                    if (i) {
                        description = description + '<li>' + parts[i] + '</li>'
                    }
                }

                return description
            },
            toggleExperience(experienceId) {
                if (this.isExperienceVisible(experienceId)) {
                    this.experiencesShown = this.experiencesShown.filter(id => id !== experienceId)
                } else {
                    this.experiencesShown.push(experienceId)
                }
            },
            isExperienceVisible(experienceId) {
                const found = this.experiencesShown.filter(id => id === experienceId)
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
