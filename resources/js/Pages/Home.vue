<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ResumeTileCard from "@/Components/ResumeTileCard.vue";
import {ref} from "vue";

const props = defineProps({
    resumes: [Array, Object]
});

const colorNumbers = ref([
    100,
    200,
    300,
    400,
    500,
    600,
])

const colorNames = ref([
    'blue',
    'amber',
    'cyan',
    'emerald',
    'fuchsia',
    'green',
    'indigo',
    'lime',
    'orange',
    'pink',
    'purple',
])

// const getBgColor = () => {
//     let numbers = colorNumbers.value;
//     let number = numbers[Math.floor(Math.random()*numbers.length)];
//     let colors = colorNames.value;
//     let color = colors[Math.floor(Math.random()*colors.length)];
//     return 'bg-' + color + '-' + number;
// }

function getBgColor() {
    let numbers = colorNumbers.value;
    let number = numbers[Math.floor(Math.random()*numbers.length)];
    let colors = colorNames.value;
    let color = colors[Math.floor(Math.random()*colors.length)];
    return 'bg-' + color + '-' + number;
}

</script>

<template>
    <AppLayout title="Home">
        {{ $page.props.user.resume }}
        <div class="flex flex-row justify-content-center flex-wrap gap-4 p-5">
            <div v-for="resume in resumes" :key="resume.id">
                <ResumeTileCard :resume="resume"></ResumeTileCard>
            </div>
        </div>

<!--        <template #header>-->
<!--            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">-->
<!--                Dashboard-->
<!--            </h2>-->
<!--        </template>-->

<!--        <div class="py-12">-->
<!--            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">-->
<!--                <div class="bg-dark dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">-->
<!--                    <Welcome />-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </AppLayout>
</template>
