<script setup>

import FormSection from "@/Components/FormSection.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import Skill from "@/Pages/Resume/Partials/Skill.vue";

const props = defineProps({
    resume: [Array, Object],
    skills: [Array, Object],
});

const form = useForm({
    _method: 'PUT',
    skills: usePage().props.skills
});
</script>

<template>
    <FormSection>
        <template #title>
            Work Skills
        </template>

        <template #description>
            Past and present skills.
        </template>

        <template #form>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Skill</th>
                        <th scope="col" class="px-6 py-3">Years</th>
                        <th scope="col" class="px-6 py-3">Months</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="form.skills.length > 0"
                        v-for="(skill, index) in form.skills"
                        :key="skill.id"
                        class="border-b dark:bg-gray-800 dark:border-gray-700">
                        <Skill :resume="resume" :model-value="skill"/>
                    </tr>
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700">
                        <Skill :resume="resume"/>
                    </tr>
                </tbody>
            </table>
        </template>
    </FormSection>
</template>

<style scoped>

</style>