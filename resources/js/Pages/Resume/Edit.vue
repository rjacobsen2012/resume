<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateResumeForm from "@/Pages/Resume/Partials/UpdateResumeForm.vue";

const props = defineProps({
    resume: [Array, Object],
});

const title = props.resume.name + "'s Resume"

const pageLinks = [
    { name: title, active: true },
];

</script>

<template>
    <AppLayout :title="title" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateResumeForm :user="$page.props.auth.user"/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>