<script setup>

import ALink from "@/Components/ALink.vue";
import ResumeTileProfile from "@/Pages/Resume/Partials/ResumeTileProfile.vue";

const props = defineProps({
    resume: [Array, Object],
});
</script>

<template>
    <div class="max-w-sm overflow-hidden rounded-xl shadow resume-card-tile']">
        <div class="px-4 py-4">
            <div class="flex flex-row justify-start items-end">
                <div v-if="resume.user.gravatar">
                    <img :src="resume.user.gravatar" :alt="resume.name" class="rounded-full"/>
                </div>
                <div class="ps-2">
                    <div class="font-bold text-xl">{{ resume.name }}</div>
                    <div class="font-bold text-md text-gray-600 text-nowrap">{{ resume.title }}</div>
                    <div class="font-bold text-sm text-nowrap">
                        {{ resume.city }}, {{ resume.state }}
                    </div>
                    <div class="font-bold text-sm">
                        {{ resume.country }}
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-between pt-2">
                <div class="flex flex-row justify-center ms-1 me-2">
<!--                    <resume-tile-profile :resume="resume"/>-->
                </div>
                <div class="flex flex-row justify-end">
                    <a-link :href="route('resume.show', [resume.id])"
                            :title="`${resume.name}' Resume`"
                    >
                        <i class="fa fa-external-link-alt"/>
                    </a-link>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
