<script setup>

const props = defineProps({
    resume: [Array, Object],
});
</script>

<template>
    <div :class="['max-w-sm', 'rounded', 'overflow-hidden', 'shadow-lg', 'bg-blue-200']">
        <div class="px-6 py-4">
            <div class="flex flex-row justify-content-between align-top">
                <div class="flex flex-col justify-content-center">
                    <img :src="resume.user.gravatar" :alt="resume.name" class="rounded-full"/>
                </div>
                <div class="flex flex-col justify-content-start flex-grow ms-4">
                    <div class="font-bold text-xl mb-2">{{ resume.name }}</div>
                    <div class="text-sm mb-2">
                        <ul>
                            <li>{{ resume.email }}</li>
                            <li>{{ resume.phone }}</li>
                            <li><a :href="resume.profile" target="_blank">Profile</a></li>
                            <li><a :href="resume.linked_in_profile" target="_blank">LinkedIn</a></li>
                            <li><a :href="resume.github_profile" target="_blank">Github</a></li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col justify-content-end">Test</div>
            </div>
<!--            <p class="text-gray-700 text-base">-->
<!--                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.-->
<!--            </p>-->
        </div>
        <div class="px-6 pt-4 pb-2 text-xs">
            <span v-for="skill in resume.skills"
                  :key="skill.id"
                  class="inline-block bg-blue-600 text-white rounded-full px-3 py-1 font-semibold text-gray-700 mr-2 mb-2">
                {{ skill.name }}
            </span>
<!--            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 font-semibold text-gray-700 mr-2 mb-2">#photography</span>-->
<!--            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 font-semibold text-gray-700 mr-2 mb-2">#travel</span>-->
<!--            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 font-semibold text-gray-700 mr-2 mb-2">#winter</span>-->
        </div>
    </div>
</template>

<style scoped>

</style>
