<script setup>

import ALink from "@/Components/ALink.vue";

const props = defineProps({
    resume: [Array, Object],
});
</script>

<template>
    <div class="flex flex-col justify-start flex-grow">
        <div class="text-xs mb-2">
            <ul>
                <li>
                    <a-link :href="`mailto:${resume.email}`" title="Email" target="_blank">
                        <i class="fa fa-envelope"/>{{ resume.email }}
                    </a-link>
                </li>
                <li>
                    <a-link :href="`tel:${resume.phone}`" title="Phone" target="_blank">
                        <i class="fa fa-phone-square"/>{{ resume.phone }}
                    </a-link>
                </li>
                <li>
                    <a-link :href="resume.profile" title="Profile" target="_blank">
                        <i class="fa fa-user-alt"/>Profile
                    </a-link>
                </li>
                <li>
                    <a-link :href="resume.linked_in_profile" title="LinkedIn Profile" target="_blank">
                        <i class="fa-brands fa-linkedin"/>LinkedIn
                    </a-link>
                </li>
                <li>
                    <a-link :href="resume.github_profile" title="Github Profile" target="_blank">
                        <i class="fa-brands fa-github-alt"/>Github
                    </a-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>

</style>
