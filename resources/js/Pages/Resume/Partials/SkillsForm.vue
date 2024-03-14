<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import Skill from "@/Pages/Resume/Partials/Skill.vue";
import PlainSection from "@/Components/PlainSection.vue";

const emit = defineEmits([
    'updated',
    'errors',
]);

const props = defineProps({
    resume: [Array, Object],
    newModel: [Array, Object, null],
});

const form = useForm({
    skills: usePage().props.resume.skills
});

const updated = (data) => {
    emit('updated', data);
}

</script>

<template>
    <PlainSection>
        <template #title>
            Work Skills
        </template>

        <template #description>
            Past and present skills.
        </template>

        <template #content>
            <div class="px-4 py-3 dark:bg-gray-800 sm:p-6 shadow sm:rounded-md">
                <table class="table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-white-50 uppercase bg-transparent">
                        <tr>
                            <th scope="col" class="px-2 py-3 columns-1">Skill</th>
                            <th scope="col" class="px-1 py-3">Years</th>
                            <th scope="col" class="px-1 py-3">Months</th>
                            <th scope="col" class="px-1 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="resume.skills.length > 0"
                            v-for="(skill, index) in resume.skills"
                            :key="skill.id"
                            class="dark:bg-gray-800">
                            <Skill :resume="resume" :model-value="resume.skills[index]" @updated="updated"/>
                        </tr>
                        <tr class="dark:bg-gray-800">
                            <Skill :resume="resume" :model-value="newModel" @updated="updated"/>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </PlainSection>
</template>

<style scoped>

</style>
