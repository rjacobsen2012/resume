<script setup>

import ALink from "@/Components/ALink.vue";
import ResumeTileProfile from "@/Pages/Resume/Partials/ResumeTileProfile.vue";

const props = defineProps({
    resume: [Array, Object],
});
</script>

<template>
    <div :class="['max-w-sm', 'rounded-full', 'overflow-hidden', 'shadow-lg', 'resume-card-tile']">
        <div class="px-3 py-4">
            <div class="flex flex-row justify-center items-center">
                <div v-if="resume.user.gravatar" class="flex flex-col justify-content-center">
                    <img :src="resume.user.gravatar" :alt="resume.name" class="rounded-full"/>
                </div>
                <div class="flex flex-row justify-center ms-1 me-2">
                    <resume-tile-profile :resume="resume"/>
                </div>
                <div class="flex flex-row justify-end">
                    <a-link :href="route('resume.show', [resume.id])"
                            :title="`${resume.name}' Resume`"
                    >
                        <i class="fa fa-external-link-alt"/>
                    </a-link>
                </div>
            </div>
<!--            <p class="text-gray-700 text-base">-->
<!--                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.-->
<!--            </p>-->
        </div>
<!--        <div class="px-6 pt-4 pb-2 text-xs">-->
<!--            <span v-for="skill in resume.skills"-->
<!--                  :key="skill.id"-->
<!--                  class="inline-block bg-blue-600 text-white rounded-full px-3 py-1 font-semibold text-gray-700 mr-2 mb-2">-->
<!--                {{ skill.name }}-->
<!--            </span>-->
<!--            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 font-semibold text-gray-700 mr-2 mb-2">#photography</span>-->
<!--            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 font-semibold text-gray-700 mr-2 mb-2">#travel</span>-->
<!--            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 font-semibold text-gray-700 mr-2 mb-2">#winter</span>-->
<!--        </div>-->
    </div>
</template>

<style scoped>

</style>
