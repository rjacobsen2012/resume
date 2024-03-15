<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ResumeTileCard from "@/Components/ResumeTileCard.vue";
import {ref} from "vue";

const props = defineProps({
    resumes: [Array, Object]
});

const classes = ref([]);

for (let i = 0; i < props.resumes.length; i++) {
    classes.value.push(getBgColor)
}

const randomStyle = (numbers) => {
    return Object.entries(numbers)[Math.floor(Math.random()*Object.entries(numbers).length)][1]
}

function getBgColor() {
    return randomStyle(styles.value);
}

const styles = ref({
    blue: 'bg-blue-300',
    amber: 'bg-amber-300',
    cyan: 'bg-cyan-300',
    emerald: 'bg-emerald-300',
    fuchsia: 'bg-fuchsia-300',
    green: 'bg-green-300',
    indigo: 'bg-indigo-300',
    lime: 'bg-lime-300',
    orange: 'bg-orange-300',
    pink: 'bg-pink-300',
    purple: 'bg-purple-300',
});

</script>

<template>
    <AppLayout title="Home">
        <div class="flex flex-row justify-content-center flex-wrap gap-4 p-5">
            <ResumeTileCard v-for="(resume, index) in resumes"
                            :key="resume.id"
                            :resume="resume"
                            v-bind:class="getBgColor()"
            />
<!--            <div v-for="resume in resumes" :key="resume.id">-->
<!--                <ResumeTileCard :resume="resume"></ResumeTileCard>-->
<!--            </div>-->
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
