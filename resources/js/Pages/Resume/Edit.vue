<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateResumeForm from "@/Pages/Resume/Partials/UpdateResumeForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import EducationsForm from "@/Pages/Resume/Partials/EducationsForm.vue";
import ExamplesForm from "@/Pages/Resume/Partials/ExamplesForm.vue";
import ExperiencesForm from "@/Pages/Resume/Partials/ExperiencesForm.vue";
import SkillsForm from "@/Pages/Resume/Partials/SkillsForm.vue";
import {useForm} from "@inertiajs/vue3";
import {flashSuccess} from "@/Composables/flash.js";

const props = defineProps({
    resume: [Array, Object],
});

const title = props.resume.name + "'s 𝓡𝓮𝓼𝓾𝓶𝓮"

const pageLinks = [
    { name: title, active: true },
];

const form = useForm({
    id: props.resume.id,
    name: props.resume.name,
    email: props.resume.email,
    profile: props.resume.profile,
    linked_in_profile: props.resume.linked_in_profile,
    github_profile: props.resume.github_profile,
    phone: props.resume.phone,
    skills: props.resume.skills,
    experiences: props.resume.experiences,
    educations: props.resume.educations,
    pdf_resume: null,
    word_resume: null,
});

function updateForm(resume) {
    form.name = resume.name
    form.email = resume.email
    form.profile = resume.profile
    form.linked_in_profile = resume.linked_in_profile
    form.github_profile = resume.github_profile
    form.phone = resume.phone
    form.skills = resume.skills
    form.experiences = resume.experiences
    form.educations = resume.educations
}

const newExperienceForm = useForm({
    id: null,
    resume_id: form.id,
    company_name: '',
    title: '',
    city: '',
    state: '',
    started_at: '',
    ended_at: '',
    present: false,
    description: '',
    hidden: false,
});

const newEducationForm = useForm({
    id: null,
    resume_id: form.id,
    school: '',
    city: '',
    state: '',
    degree: '',
    started_at: '',
    ended_at: '',
    description: '',
});

const newExampleForm = useForm({
    id: null,
    title: '',
    url: '',
    resume_id: form.id,
});

const newSkillForm = useForm({
    id: null,
    name: '',
    years: 0,
    months: 0,
    resume_id: form.id,
});

function resetNewExperienceForm() {
    newExperienceForm.id = null;
    newExperienceForm.resume_id = form.id;
    newExperienceForm.company_name = '';
    newExperienceForm.title = '';
    newExperienceForm.city = '';
    newExperienceForm.state = '';
    newExperienceForm.started_at = '';
    newExperienceForm.ended_at = '';
    newExperienceForm.present = false;
    newExperienceForm.description = '';
    newExperienceForm.hidden = false;
}

function resetNewEducationForm() {
    newExperienceForm.id = null;
    newExperienceForm.resume_id = form.id;
    newExperienceForm.school = '';
    newExperienceForm.city = '';
    newExperienceForm.state = '';
    newExperienceForm.degree = '';
    newExperienceForm.started_at = '';
    newExperienceForm.ended_at = '';
    newExperienceForm.description = '';
}

function resetNewSkillForm() {
    newSkillForm.id = null;
    newSkillForm.name = '';
    newSkillForm.years = 0;
    newSkillForm.months = 0;
    newSkillForm.resume_id = form.id;
}

const updated = (data) => {
    updateForm(data.resume);
    resetNewSkillForm();
    resetNewExperienceForm();
    resetNewEducationForm();

    let status = data.status ?? data.props.status

    if (status) {
        flashSuccess(status)
    }
}

</script>

<template>
    <AppLayout :title="title" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateResumeForm :user="$page.props.auth.user"/>

                <SectionBorder />
            </div>
            <div class="max-w-7xl mx-auto py-1 sm:px-6 lg:px-8">
                <EducationsForm :new-model="newEducationForm"
                                :resume="resume"
                                @updated="updated"/>

                <SectionBorder />
            </div>
            <div class="max-w-7xl mx-auto py-1 sm:px-6 lg:px-8">
                <ExamplesForm :new-model="newExampleForm"
                              :resume="resume"
                              @updated="updated"/>

                <SectionBorder />
            </div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <ExperiencesForm :new-model="newExperienceForm"
                                 :resume="resume"
                                 @updated="updated"/>

                <SectionBorder />
            </div>
            <div class="max-w-7xl mx-auto py-1 sm:px-6 lg:px-8">
                <SkillsForm :new-model="newSkillForm"
                            :resume="resume"
                            @updated="updated"/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
