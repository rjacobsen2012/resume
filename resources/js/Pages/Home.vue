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
        <div class="flex flex-row justify-start flex-wrap gap-4 mt-4 mx-4">
            <ResumeTileCard v-for="(resume, index) in resumes"
                            :key="resume.id"
                            :resume="resume"
                            v-bind:class="getBgColor()"
            />
        </div>
    </AppLayout>
</template>
