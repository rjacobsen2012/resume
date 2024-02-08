<template>
    <layout title="Resume Admin">
        <template v-slot:default="slotProps">
            <div class="mt-4">
                <div class="resume-form">
                    <div class="resume-field">
                        <div class="resume-label">Name:</div>
                        <div class="resume-input">
                            <b-form-input id="resume-name" name="resume-name" size="sm" v-model="resumeUserForm.name" :class="[fieldError('name') ? 'error' : '', 'form-control']" placeholder="Enter name"/>
                            <div v-show="fieldError('name')" class="validation-error">{{ fieldError('name') }}</div>
                        </div>
                    </div>
                    <div class="resume-field pt-2">
                        <div class="resume-label">Email:</div>
                        <div class="resume-input">
                            <b-form-input id="resume-email" name="resume-email" size="sm" v-model="resumeUserForm.email" :class="[fieldError('email') ? 'error' : '', 'form-control']" placeholder="Enter email"/>
                            <div v-show="fieldError('email')" class="validation-error">{{ fieldError('email') }}</div>
                        </div>
                    </div>
                    <div class="resume-field pt-2">
                        <div class="resume-label">Profile:</div>
                        <div class="resume-input">
                            <b-form-input id="resume-profile" name="resume-profile" size="sm" v-model="resumeUserForm.profile" :class="[fieldError('profile') ? 'error' : '', 'form-control']" placeholder="Enter profile"/>
                            <div v-show="fieldError('profile')" class="validation-error">{{ fieldError('profile') }}</div>
                        </div>
                    </div>
                    <div class="resume-field pt-2">
                        <div class="resume-label">Phone:</div>
                        <div class="resume-input">
                            <b-form-input id="resume-phone" name="resume-phone" size="sm" v-model="resumeUserForm.phone" :class="[fieldError('phone') ? 'error' : '', 'form-control']" placeholder="Enter phone"/>
                            <div v-show="fieldError('phone')" class="validation-error">{{ fieldError('phone') }}</div>
                        </div>
                    </div>
                    <div class="resume-field pt-2">
                        <div class="resume-label">Github Profile:</div>
                        <div class="resume-input">
                            <b-form-input id="resume-github-profile" name="resume-github-profile" size="sm" v-model="resumeUserForm.github_profile" :class="[fieldError('github_profile') ? 'error' : '', 'form-control']" placeholder="Enter github profile"/>
                            <div v-show="fieldError('github_profile')" class="validation-error">{{ fieldError('github_profile') }}</div>
                        </div>
                    </div>
                    <div class="resume-field pt-2">
                        <div class="resume-label">Linkedin Profile:</div>
                        <div class="resume-input">
                            <b-form-input id="resume-linkedin-profile" name="resume-linkedin-profile" size="sm" v-model="resumeUserForm.linked_in_profile" :class="[fieldError('linked_in_profile') ? 'error' : '', 'form-control']" placeholder="Enter linkedin profile"/>
                            <div v-show="fieldError('linked_in_profile')" class="validation-error">{{ fieldError('linked_in_profile') }}</div>
                        </div>
                    </div>

                    <div class="resume-field pt-2 align-content-end">
                        <div class="resume-label">Resume File:</div>
                        <div class="resume-input">
                            <b-form-file
                                v-model="resumeUserForm.resume"
                                :state="Boolean(resumeUserForm.resume)"
                                placeholder="Choose a resume or drop it here..."
                                drop-placeholder="Drop resume here..."
                            ></b-form-file>
                            <div class="mt-0">Selected file: {{ resumeUserForm.resume ? resumeUserForm.resume.name : '' }}</div>
                        </div>
                    </div>

                    <div class="resume-field pt-2">
                        <div class="resume-label"></div>
                        <div class="resume-input">
                            <b-button v-if="loadedResumeUser === null" @click="createResumeUser" size="sm" variant="primary">Create Resume</b-button>
                            <b-button v-else @click="updateResumeUser" size="sm" variant="primary">Update Resume</b-button>
                        </div>
                    </div>

                    <div v-if="loadedResumeUser !== null" class="resume-skills-holder mt-4">
                        <span class="title">Skills</span>
                        <div class="resume-field pt-2">
                            <div v-if="loadedResumeUser" class="resume-skills">
                                <div class="resume-skill">
                                    <div class="titles">
                                        <span class="text-center">Skill</span>
                                        <span class="text-center">Years</span>
                                        <span class="text-center">Months</span>
                                    </div>
                                    <div class="buttons"></div>
                                </div>
                                <div v-for="skill in skills" :key="skill.id" class="pt-2 resume-skill">
                                    <div class="content-row">
                                        <b-input-group size="sm" :model="`skill-name-${skill.id}`">
                                            <b-form-input :id="`skill-name-${skill.id}`" :name="`skill-name-${skill.id}`" type="text" size="sm" v-model.trim="skill.name"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-input-group size="sm" :model="`skill-years-${skill.id}`">
                                            <b-form-input :id="`skill-years-${skill.id}`" :name="`skill-years-${skill.id}`" type="number" size="sm" v-model="skill.years"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-input-group size="sm" :model="`skill-months-${skill.id}`">
                                            <b-form-input :id="`skill-months-${skill.id}`" :name="`skill-months-${skill.id}`" type="number" size="sm" v-model="skill.months"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-btn-toolbar>
                                            <b-button-group size="sm">
                                                <b-button variant="primary" size="sm" @click="updateSkill(skill.id)"><font-awesome-icon icon="save"/></b-button>
                                                <b-button variant="danger" size="sm" @click="deleteSkill(skill.id)"><font-awesome-icon icon="times"/></b-button>
                                            </b-button-group>
                                        </b-btn-toolbar>
                                    </div>
                                </div>
                                <div class="pt-2 resume-skill">
                                    <div class="content-row">
                                        <b-input-group size="sm" model="newskill.name">
                                            <b-form-input id="new-skill-name" name="new-skill-name" type="text" size="sm" v-model.trim="newSkillForm.name" placeholder="New Skill"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-input-group size="sm" model="newskill.years">
                                            <b-form-input id="new-skill-years" name="new-skill-years" type="number" size="sm" v-model="newSkillForm.years" placeholder="0"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-input-group size="sm" model="newskill.months">
                                            <b-form-input id="new-skill-months" name="new-skill-months" type="number" size="sm" v-model="newSkillForm.months" placeholder="0"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-button variant="primary" size="sm" @click="addSkill"><font-awesome-icon icon="plus"/></b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="loadedResumeUser !== null" class="resume-work-examples-holder mt-4">
                        <span class="title">Work Examples</span>
                        <div class="resume-work-examples-field pt-2">
                            <div v-if="loadedResumeUser" class="resume-work-examples">
                                <div class="resume-work-example">
                                    <div class="titles">
                                        <span class="text-center">Title</span>
                                        <span class="text-center">Url</span>
                                    </div>
                                    <div class="buttons"></div>
                                </div>
                                <div v-for="workExample in workExamples" :key="workExample.id" class="resume-work-example pt-2">
                                    <div class="content-row">
                                        <b-input-group size="sm" :model="`work-example-name-${workExample.id}`">
                                            <b-form-input :id="`work-example-name-${workExample.id}`" :name="`work-example-name-${workExample.id}`" type="text" size="sm" v-model.trim="workExample.title"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-input-group size="sm" :model="`work-example-years-${workExample.id}`">
                                            <b-form-input :id="`work-example-years-${workExample.id}`" :name="`work-example-years-${workExample.id}`" type="text" size="sm" v-model="workExample.url"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-btn-toolbar>
                                            <b-button-group size="sm">
                                                <b-button variant="primary" size="sm" @click="updateWorkExample(workExample.id)"><font-awesome-icon icon="save"/></b-button>
                                                <b-button variant="danger" size="sm" @click="deleteWorkExample(workExample.id)"><font-awesome-icon icon="times"/></b-button>
                                            </b-button-group>
                                        </b-btn-toolbar>
                                    </div>
                                </div>
                                <div class="resume-work-example pt-2">
                                    <div class="content-row">
                                        <b-input-group size="sm" model="newWorkExampleForm.title">
                                            <b-form-input id="new-work-example-title" name="new-work-example-title" type="text" size="sm" v-model.trim="newWorkExampleForm.title" placeholder="Title"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-input-group size="sm" model="newWorkExampleForm.url">
                                            <b-form-input id="new-work-example-url" name="new-work-example-url" type="text" size="sm" v-model.trim="newWorkExampleForm.url" placeholder="Url"/>
                                        </b-input-group>
                                    </div>
                                    <div class="content-row">
                                        <b-button variant="primary" size="sm" @click="addWorkExample"><font-awesome-icon icon="plus"/></b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="loadedResumeUser !== null" class="resume-educations-holder mt-4">
                        <span class="title">Education</span>
                        <div class="resume-education-field pt-2">
                            <div v-if="loadedResumeUser" class="resume-educations">
                                <div v-for="education in educations" :key="education.id" class="resume-education pt-2">
                                    <b-card :bg-variant="slotProps.bgColorValue" :text-variant="slotProps.textColorValue" :border-variant="slotProps.bgColorValue">
                                        <b-input-group size="sm" prepend="School" :model="`education-school-${education.id}`">
                                            <b-form-input :id="`education-school-${education.id}`" :name="`education-school-${education.id}`" type="text" size="sm" v-model.trim="education.school"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Degree" :model="`education-degree-${education.id}`" class="mt-2">
                                            <b-form-input :id="`education-degree-${education.id}`" :name="`education-degree-${education.id}`" type="text" size="sm" v-model.trim="education.degree"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="City" :model="`education-city-${education.id}`" class="mt-2">
                                            <b-form-input :id="`education-city-${education.id}`" :name="`education-city-${education.id}`" type="text" size="sm" v-model.trim="education.city"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="State" :model="`education-state-${education.id}`" class="mt-2">
                                            <b-form-input :id="`education-state-${education.id}`" :name="`education-state-${education.id}`" type="text" size="sm" v-model.trim="education.state"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Start Date" class="datepicker-date mt-2" :model="`education-start-date-${education.id}`">
                                            <datetime
                                                type="date"
                                                v-model="education.started_at"
                                                format="MMM, y"
                                                :input-id="`education-start-date-${education.id}`"
                                                :input-class="['form-control', 'form-control-sm', 'date-field']"
                                            />
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="End Date" class="datepicker-date mt-2" :model="`education-end-date-${education.id}`">
                                            <datetime
                                                type="date"
                                                v-model="education.ended_at"
                                                :disable="education.present"
                                                format="MMM, y"
                                                :input-id="`education-end-date-${education.id}`"
                                                :input-class="['form-control', 'form-control-sm', 'date-field']"
                                            />
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Description" :model="`education-description-${education.id}`" class="mt-2 mb-2">
                                            <b-form-textarea rows="3" max-rows="10" :id="`education-description-${education.id}`" :name="`education-description-${education.id}`" type="text" size="sm" v-model.trim="education.description"/>
                                        </b-input-group>
                                        <b-button variant="primary" size="sm" class="ml-2" @click="updateEducation(education.id)"><font-awesome-icon icon="save"/></b-button>
                                        <b-button variant="danger" size="sm" class="ml-2" @click="deleteEducation(education.id)"><font-awesome-icon icon="times"/></b-button>
                                    </b-card>
                                </div>
                                <div class="resume-education pt-2">
                                    <b-card :bg-variant="slotProps.bgColorValue" :text-variant="slotProps.textColorValue" :border-variant="slotProps.bgColorValue">
                                        <b-input-group size="sm" prepend="School" :model="`new-education-school`">
                                            <b-form-input :id="`new-education-school`" :name="`new-education-school`" type="text" size="sm" v-model.trim="newEducationForm.school"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Degree" :model="`new-education-degree`" class="mt-2">
                                            <b-form-input :id="`new-education-degree`" :name="`new-education-degree`" type="text" size="sm" v-model.trim="newEducationForm.degree"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="City" :model="`new-education-city`" class="mt-2">
                                            <b-form-input :id="`new-education-city`" :name="`new-education-city`" type="text" size="sm" v-model.trim="newEducationForm.city"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="State" :model="`new-education-state`" class="mt-2">
                                            <b-form-input :id="`new-education-state`" :name="`new-education-state`" type="text" size="sm" v-model.trim="newEducationForm.state"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Start Date" class="datepicker-date mt-2" :model="`new-education-start-date`">
                                            <datetime
                                                type="date"
                                                v-model="newEducationForm.started_at"
                                                format="MMM, y"
                                                :input-id="`new-education-start-date`"
                                                :input-class="['form-control', 'form-control-sm', 'date-field']"
                                            />
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="End Date" class="datepicker-date mt-2" :model="`new-education-end-date`">
                                            <datetime
                                                type="date"
                                                v-model="newEducationForm.ended_at"
                                                format="MMM, y"
                                                :input-id="`new-education-end-date`"
                                                :input-class="['form-control', 'form-control-sm', 'date-field']"
                                            />
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Description" :model="`new-education-description`" class="mt-2">
                                            <b-form-textarea rows="3" max-rows="10" :id="`new-education-description`" :name="`new-education-description`" type="text" size="sm" v-model.trim="newEducationForm.description"/>
                                        </b-input-group>
                                        <b-button variant="primary" size="sm" class="mt-2" @click="addEducation"><font-awesome-icon icon="plus"/></b-button>
                                    </b-card>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="loadedResumeUser !== null" class="resume-experiences-holder mt-4">
                        <span class="title">Experience</span>
                        <div class="resume-experience-field pt-2">
                            <div v-if="loadedResumeUser" class="resume-experiences">
                                <div v-for="experience in experiences" :key="experience.id" class="resume-experience pt-2">
                                    <b-card :bg-variant="slotProps.bgColorValue" :text-variant="slotProps.textColorValue" :border-variant="slotProps.bgColorValue">
                                        <b-input-group size="sm" :model="`experience-hidden-${experience.id}`" class="mt-2">
                                            <b-form-checkbox :id="`experience-hidden-${experience.id}`" :name="`experience-hidden-${experience.id}`" size="sm" v-model="experience.hidden" switch>
                                                Hide Employer
                                            </b-form-checkbox>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Company Name" :model="`experience-company-name-${experience.id}`">
                                            <b-form-input :id="`experience-company-name-${experience.id}`" :name="`experience-company-name-${experience.id}`" type="text" size="sm" v-model.trim="experience.company_name"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Title" :model="`experience-title-${experience.id}`" class="mt-2">
                                            <b-form-input :id="`experience-title-${experience.id}`" :name="`experience-title-${experience.id}`" type="text" size="sm" v-model.trim="experience.title"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="City" :model="`experience-city-${experience.id}`" class="mt-2">
                                            <b-form-input :id="`experience-city-${experience.id}`" :name="`experience-city-${experience.id}`" type="text" size="sm" v-model.trim="experience.city"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="State" :model="`experience-state-${experience.id}`" class="mt-2">
                                            <b-form-input :id="`experience-state-${experience.id}`" :name="`experience-state-${experience.id}`" type="text" size="sm" v-model.trim="experience.state"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Start Date" class="datepicker-date mt-2" :model="`experience-start-date-${experience.id}`">
                                            <datetime
                                                type="date"
                                                v-model="experience.started_at"
                                                format="MMM, y"
                                                :input-id="`experience-start-date-${experience.id}`"
                                                :input-class="['form-control', 'form-control-sm', 'date-field']"
                                            />
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="End Date" class="datepicker-date mt-2" :model="`experience-end-date-${experience.id}`">
                                            <datetime
                                                type="date"
                                                v-model="experience.ended_at"
                                                :disable="experience.present"
                                                format="MMM, y"
                                                :input-id="`experience-end-date-${experience.id}`"
                                                :input-class="['form-control', 'form-control-sm', 'date-field']"
                                            />
                                        </b-input-group>
                                        <b-input-group size="sm" :model="`new-experience-present-${experience.id}`" class="mt-2">
                                            <b-form-checkbox :id="`new-experience-present-${experience.id}`" :name="`new-experience-present-${experience.id}`" size="sm" v-model="experience.present" switch>
                                                Present Employer
                                            </b-form-checkbox>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Description" :model="`experience-description-${experience.id}`" class="mt-2 mb-2">
                                            <b-form-textarea rows="3" max-rows="10" :id="`experience-description-${experience.id}`" :name="`experience-description-${experience.id}`" type="text" size="sm" v-model.trim="experience.description"/>
                                        </b-input-group>
                                        <b-button variant="primary" size="sm" class="ml-2" @click="updateExperience(experience.id)"><font-awesome-icon icon="save"/></b-button>
                                        <b-button variant="danger" size="sm" class="ml-2" @click="deleteExperience(experience.id)"><font-awesome-icon icon="times"/></b-button>
                                    </b-card>
                                </div>
                                <div class="resume-experience pt-2">
                                    <b-card :bg-variant="slotProps.bgColorValue" :text-variant="slotProps.textColorValue" :border-variant="slotProps.bgColorValue">
                                        <b-input-group size="sm" prepend="Company Name" :model="`new-experience-company-name`">
                                            <b-form-input :id="`new-experience-company-name`" :name="`new-experience-company-name`" type="text" size="sm" v-model.trim="newExperienceForm.company_name"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Title" :model="`new-experience-title`" class="mt-2">
                                            <b-form-input :id="`new-experience-title`" :name="`new-experience-title`" type="text" size="sm" v-model.trim="newExperienceForm.title"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="City" :model="`new-experience-city`" class="mt-2">
                                            <b-form-input :id="`new-experience-city`" :name="`new-experience-city`" type="text" size="sm" v-model.trim="newExperienceForm.city"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="State" :model="`new-experience-state`" class="mt-2">
                                            <b-form-input :id="`new-experience-state`" :name="`new-experience-state`" type="text" size="sm" v-model.trim="newExperienceForm.state"/>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Start Date" class="datepicker-date mt-2" :model="`new-experience-start-date`">
                                            <datetime
                                                type="date"
                                                v-model="newExperienceForm.started_at"
                                                format="MMM, y"
                                                :input-id="`new-experience-start-date`"
                                                :input-class="['form-control', 'form-control-sm', 'date-field']"
                                            />
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="End Date" class="datepicker-date mt-2" :model="`new-experience-end-date`">
                                            <datetime
                                                type="date"
                                                v-model="newExperienceForm.ended_at"
                                                format="MMM, y"
                                                :input-id="`new-experience-end-date`"
                                                :input-class="['form-control', 'form-control-sm', 'date-field']"
                                            />
                                        </b-input-group>
                                        <b-input-group size="sm" :model="`new-experience-present`" class="mt-2">
                                            <b-form-checkbox :id="`new-experience-present`" :name="`new-experience-present`" size="sm" v-model="newExperienceForm.present">
                                                Present Employer
                                            </b-form-checkbox>
                                        </b-input-group>
                                        <b-input-group size="sm" prepend="Description" :model="`new-experience-description`" class="mt-2">
                                            <b-form-textarea rows="3" max-rows="10" :id="`new-experience-description`" :name="`new-experience-description`" type="text" size="sm" v-model.trim="newExperienceForm.description"/>
                                        </b-input-group>
                                        <b-button variant="primary" size="sm" class="mt-2" @click="addExperience"><font-awesome-icon icon="plus"/></b-button>
                                    </b-card>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </layout>
</template>

<script>
    import User from '@mixins/user'
    import ResumeUser from '@mixins/resumeUser'
    import Layout from "../../components/layout/Layout"

    export default {
        name: "Resume",
        components: {
            Layout,
        },
        mixins: [User, ResumeUser],

        created() {
            this.loadedResumeUser = this.$resumeUser
            this.refreshResumeUser(this.$resumeUser)
        },

        data() {
            return {
                resumeUserForm: {
                    id: null,
                    name: null,
                    email: null,
                    profile: null,
                    linked_in_profile: null,
                    github_profile: null,
                    phone: null,
                    resume: null,
                },
                resumeSkills: [],
                resumeExperiences: [],
                resumeEducations: [],
                newSkillForm: {
                    name: null,
                    years: 0,
                    months: 0,
                },
                newExperienceForm: {
                    company_name: null,
                    title: null,
                    city: null,
                    state: null,
                    started_at: null,
                    ended_at: null,
                    present: false,
                    description: null,
                },
                newEducationForm: {
                    school: null,
                    degree: null,
                    city: null,
                    state: null,
                    started_at: null,
                    ended_at: null,
                    description: null,
                },
                newWorkExampleForm: {
                    url: null,
                    title: null,
                },
                skills: [],
                experiences: [],
                educations: [],
                workExamples: [],
                loadedResumeUser: null,
                validationErrors: {},
            }
        },

        methods: {
            refreshResumeUser(resumeUser) {
                this.loadedResumeUser = resumeUser
                this.resumeUserForm.name = this.loadedResumeUser ? this.loadedResumeUser.name : this.$user.first_name + ' ' + this.$user.last_name
                this.resumeUserForm.email = this.loadedResumeUser ? this.loadedResumeUser.email : this.$user.email
                this.resumeUserForm.profile = this.loadedResumeUser ? this.loadedResumeUser.profile : null
                this.resumeUserForm.resume = this.loadedResumeUser ? this.loadedResumeUser.resume : null
                this.resumeUserForm.phone = this.loadedResumeUser ? this.loadedResumeUser.phone : null
                this.resumeUserForm.github_profile = this.loadedResumeUser ? this.loadedResumeUser.github_profile : null
                this.resumeUserForm.linked_in_profile = this.loadedResumeUser ? this.loadedResumeUser.linked_in_profile : null
                this.resumeUserForm.id = this.loadedResumeUser ? this.loadedResumeUser.id : null
                this.loadSkills()
                this.loadExperiences()
                this.loadWorkExamples()
                this.loadEducations()
                console.log(this.experiences)
            },

            loadSkills() {
                if (this.loadedResumeUser) {

                    this.skills = []

                    if (this.loadedResumeUser.skills.length > 0) {

                        for (let i = 0; i < this.loadedResumeUser.skills.length; i++) {
                            const thisSkill = this.loadedResumeUser.skills[i]
                            if (typeof thisSkill !== "undefined") {
                                this.skills.push(thisSkill)
                            }
                        }
                    }

                }
            },

            loadExperiences() {
                if (this.loadedResumeUser) {

                    this.experiences = []

                    if (this.loadedResumeUser.experiences.length > 0) {

                        for (let i = 0; i < this.loadedResumeUser.experiences.length; i++) {
                            const thisExperience = this.loadedResumeUser.experiences[i]
                            if (typeof thisExperience !== "undefined") {
                                this.experiences.push(thisExperience)
                            }
                        }
                    }

                }
            },

            loadEducations() {
                if (this.loadedResumeUser) {

                    this.educations = []

                    if (this.loadedResumeUser.educations.length > 0) {

                        for (let i = 0; i < this.loadedResumeUser.educations.length; i++) {
                            const thisEducation = this.loadedResumeUser.educations[i]
                            if (typeof thisEducation !== "undefined") {
                                this.educations.push(thisEducation)
                            }
                        }
                    }

                }
            },

            loadWorkExamples() {
                if (this.loadedResumeUser) {

                    this.workExamples = []

                    if (this.loadedResumeUser.workExamples.length > 0) {

                        for (let i = 0; i < this.loadedResumeUser.workExamples.length; i++) {
                            const thisWorkExample = this.loadedResumeUser.workExamples[i]
                            if (typeof thisWorkExample !== "undefined") {
                                this.workExamples.push(thisWorkExample)
                            }
                        }
                    }

                }
            },

            addSkill() {
                const resumeSkill = {
                    name: this.newSkillForm.name,
                    years: this.newSkillForm.years,
                    months: this.newSkillForm.months,
                }

                this.axios
                    .post(
                        this.route('api.v1.resume-user.resume-skill.store', [this.loadedResumeUser.id]),
                        resumeSkill,
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleCreateResumeSkillSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            updateSkill(id) {
                const resumeSkill = this.skills.filter(skill => { return skill.id === id})[0]

                this.axios
                    .put(
                        this.route('api.v1.resume-user.resume-skill.update', [this.loadedResumeUser.id, resumeSkill.id]),
                        resumeSkill,
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleUpdateResumeSkillSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            deleteSkill(id) {
                this.axios
                    .delete(
                        this.route('api.v1.resume-user.resume-skill.destroy', [this.loadedResumeUser.id, id]),
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleDeleteResumeSkillSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            addWorkExample() {
                const resumeWorkExample = {
                    url: this.newWorkExampleForm.url,
                    title: this.newWorkExampleForm.title,
                }

                this.axios
                    .post(
                        this.route('api.v1.resume-user.resume-work-example.store', [this.loadedResumeUser.id]),
                        resumeWorkExample,
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleCreateResumeWorkExampleSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            updateWorkExample(id) {
                const resumeWorkExample = this.workExamples.filter(workExample => { return workExample.id === id})[0]

                this.axios
                    .put(
                        this.route('api.v1.resume-user.resume-work-example.update', [this.loadedResumeUser.id, resumeWorkExample.id]),
                        resumeWorkExample,
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleUpdateResumeWorkExampleSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            deleteWorkExample(id) {
                this.axios
                    .delete(
                        this.route('api.v1.resume-user.resume-work-example.destroy', [this.loadedResumeUser.id, id]),
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleDeleteResumeWorkExampleSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            addExperience() {
                const resumeExperience = {
                    company_name: this.newExperienceForm.company_name,
                    title: this.newExperienceForm.title,
                    city: this.newExperienceForm.city,
                    state: this.newExperienceForm.state,
                    started_at: this.newExperienceForm.started_at,
                    ended_at: this.newExperienceForm.ended_at,
                    present: this.newExperienceForm.present ? 1 : 0,
                    description: this.newExperienceForm.description,
                }

                this.axios
                    .post(
                        this.route('api.v1.resume-user.resume-experience.store', [this.loadedResumeUser.id]),
                        resumeExperience,
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleCreateResumeExperienceSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            updateExperience(id) {
                const resumeExperience = this.experiences.filter(experience => { return experience.id === id})[0]
                resumeExperience.present = resumeExperience.present ? 1 : 0
                resumeExperience.ended_at = resumeExperience.present ? null : resumeExperience.ended_at
                resumeExperience.hidden = resumeExperience.hidden ? 1 : 0

                this.axios
                    .put(
                        this.route('api.v1.resume-user.resume-experience.update', [this.loadedResumeUser.id, resumeExperience.id]),
                        resumeExperience,
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleUpdateResumeExperienceSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            deleteExperience(id) {
                this.axios
                    .delete(
                        this.route('api.v1.resume-user.resume-experience.destroy', [this.loadedResumeUser.id, id]),
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleDeleteResumeExperienceSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            addEducation() {
                const resumeEducation = {
                    school: this.newEducationForm.school,
                    degree: this.newEducationForm.degree,
                    city: this.newEducationForm.city,
                    state: this.newEducationForm.state,
                    started_at: this.newEducationForm.started_at,
                    ended_at: this.newEducationForm.ended_at,
                    description: this.newEducationForm.description,
                }

                this.axios
                    .post(
                        this.route('api.v1.resume-user.resume-education.store', [this.loadedResumeUser.id]),
                        resumeEducation,
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleCreateResumeEducationSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            updateEducation(id) {
                const resumeEducation = this.educations.filter(education => { return education.id === id})[0]

                this.axios
                    .put(
                        this.route('api.v1.resume-user.resume-education.update', [this.loadedResumeUser.id, resumeEducation.id]),
                        resumeEducation,
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleUpdateResumeEducationSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            deleteEducation(id) {
                this.axios
                    .delete(
                        this.route('api.v1.resume-user.resume-education.destroy', [this.loadedResumeUser.id, id]),
                        {
                            headers: this.tokenHeader()
                        }
                    )
                    .then(this.handleDeleteResumeEducationSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            updateResumeUser() {
                this.validationErrors = {};

                const formData = new FormData();
                formData.append('_method', 'PATCH');
                formData.append('name', this.resumeUserForm.name);
                formData.append('email', this.resumeUserForm.email);
                formData.append('profile', this.resumeUserForm.profile);
                formData.append('phone', this.resumeUserForm.phone);
                formData.append('github_profile', this.resumeUserForm.github_profile);
                formData.append('linked_in_profile', this.resumeUserForm.linked_in_profile);
                formData.append('resume', this.resumeUserForm.resume);

                this.$bus.$emit('isloading', true);

                this.axios
                    .post(
                        this.route('api.v1.resume-user.update', [this.resumeUserForm.id]),
                        formData,
                        {
                            headers: this.tokenHeader(),
                            'Content-Type': 'multipart/form-data'
                        }
                    )
                    .then(this.handleUpdateResumeUserSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {
                        this.$bus.$emit('isloading', false)
                    })
            },

            createResumeUser() {
                this.validationErrors = {};

                const formData = new FormData();
                formData.append('name', this.resumeUserForm.name);
                formData.append('email', this.resumeUserForm.email);
                formData.append('profile', this.resumeUserForm.profile);
                formData.append('phone', this.resumeUserForm.phone);
                formData.append('github_profile', this.resumeUserForm.github_profile);
                formData.append('linked_in_profile', this.resumeUserForm.linked_in_profile);
                formData.append('resume', this.resumeUserForm.resume);

                this.axios
                    .post(
                        this.route('api.v1.resume-user.store', []),
                        formData,
                        {
                            headers: this.tokenHeader(),
                            'Content-Type': 'multipart/form-data'
                        }
                    )
                    .then(this.handleCreateResumeUserSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                    })
                    .finally(() => {})
            },

            fieldError(field) {
                if (this.validationErrors && this.validationErrors[field]) {
                    return this.validationErrors[field]
                }

                return null
            },

            handleCreateResumeUserSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume user was created successfully")
            },

            handleUpdateResumeUserSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume user was updated successfully")
            },

            handleCreateResumeSkillSuccess(response) {
                this.newSkillForm.name = null
                this.newSkillForm.years = 0
                this.newSkillForm.months = 0
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume skill was added successfully")
            },

            handleUpdateResumeSkillSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume skill was updated successfully")
            },

            handleDeleteResumeSkillSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume skill was deleted successfully")
            },

            handleCreateResumeWorkExampleSuccess(response) {
                this.newWorkExampleForm.url = null
                this.newWorkExampleForm.title = null
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume work example was added successfully")
            },

            handleUpdateResumeWorkExampleSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume work example was updated successfully")
            },

            handleDeleteResumeWorkExampleSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume work example was deleted successfully")
            },

            handleCreateResumeExperienceSuccess(response) {
                this.newExperienceForm = {
                    company_name: null,
                    title: null,
                    city: null,
                    state: null,
                    started_at: null,
                    ended_at: null,
                    present: false,
                    description: null,
                }
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume experience was added successfully")
            },

            handleUpdateResumeExperienceSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume experience was updated successfully")
            },

            handleDeleteResumeExperienceSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume experience was deleted successfully")
            },

            handleCreateResumeEducationSuccess(response) {
                this.newEducationForm = {
                    school: null,
                    degree: null,
                    city: null,
                    state: null,
                    started_at: null,
                    ended_at: null,
                    description: null,
                }
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume education was added successfully")
            },

            handleUpdateResumeEducationSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume education was updated successfully")
            },

            handleDeleteResumeEducationSuccess(response) {
                this.loadedResumeUser = response.data.resumeUser
                this.refreshResumeUser(response.data.resumeUser)
                this.$toasted.success("The resume education was deleted successfully")
            },
        },
    }
</script>

<style scoped>

</style>
