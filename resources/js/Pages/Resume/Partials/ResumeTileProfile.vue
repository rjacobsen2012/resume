<script setup>

import ALink from "@/Components/ALink.vue";

const props = defineProps({
    resume: [Array, Object],
});
</script>

<template>
    <div class="flex flex-col justify-start flex-grow ms-3 me-2">
        <div class="font-bold text-xl mb-2">{{ resume.name }}</div>
        <div class="text-xs mb-2">
            <ul>
                <li>{{ resume.email }}</li>
                <li>{{ resume.phone }}</li>
                <li><a-link :href="resume.profile" title="Profile" target="_blank">
                    <i class="fa fa-user-alt"/>Profile
                </a-link></li>
                <li><a-link :href="resume.linked_in_profile" title="LinkedIn Profile" target="_blank">
                    <i class="fa-brands fa-linkedin"/>LinkedIn
                </a-link></li>
                <li><a-link :href="resume.github_profile" title="Github Profile" target="_blank">
                    <i class="fa-brands fa-github-alt"/>Github
                </a-link></li>
            </ul>
        </div>
    </div>
</template>

<style scoped>

</style>
