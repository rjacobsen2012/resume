<script setup>

import FormSection from "@/Components/FormSection.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import Skill from "@/Pages/Resume/Partials/Skill.vue";

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
    <FormSection>
        <template #title>
            Work Skills
        </template>

        <template #description>
            Past and present skills.
        </template>

        <template #form>
            <div class="relative overflow-x-auto">
                <table class="table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-2 py-3 columns-1">Skill</th>
                            <th scope="col" class="px-1 py-3">Years</th>
                            <th scope="col" class="px-1 py-3">Months</th>
                            <th scope="col" class="px-1 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-if="form.skills.length > 0"
                        v-for="(skill, index) in resume.skills"
                        :key="skill.id"
                        class="border-b dark:bg-gray-800 dark:border-gray-700">
                        <Skill :resume="resume" :model-value="resume.skills[index]" @updated="updated"/>
                    </tr>
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700">
                        <Skill :resume="resume" :model-value="newModel" @updated="updated"/>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </FormSection>
</template>

<style scoped>

</style>
