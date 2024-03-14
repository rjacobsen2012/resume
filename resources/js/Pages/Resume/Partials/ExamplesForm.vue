<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import PlainSection from "@/Components/PlainSection.vue";
import Example from "@/Pages/Resume/Partials/Example.vue";

const emit = defineEmits([
    'updated',
    'errors',
]);

const props = defineProps({
    resume: [Array, Object],
    newModel: [Array, Object, null],
});

const form = useForm({
    examples: usePage().props.resume.examples
});

const updated = (data) => {
    emit('updated', data);
}

</script>

<template>
    <PlainSection>
        <template #title>
            Work Examples
        </template>

        <template #description>
            Work examples of past employers or businesses.
        </template>

        <template #content>
            <div>
                <div v-if="resume.examples.length > 0"
                     v-for="(example, index) in resume.examples"
                     :key="example.id"
                     class="px-4 py-3 dark:bg-gray-800 sm:p-6 shadow sm:rounded-md mb-16">
                    <div class="grid grid-cols-1 gap-6">
                        <Example :resume="resume" :model-value="resume.examples[index]" @updated="updated"/>
                    </div>
                </div>
                <div class="px-4 py-3 dark:bg-gray-800 sm:p-6 shadow sm:rounded-md">
                    <div class="grid grid-cols-1 gap-6">
                        <Example :resume="resume" :model-value="newModel" @updated="updated"/>
                    </div>
                </div>
            </div>
        </template>
    </PlainSection>
</template>

<style scoped>

</style>
