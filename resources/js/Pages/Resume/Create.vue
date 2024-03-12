<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import NewResumeForm from "@/Pages/Resume/Partials/NewResumeForm.vue";

const title = 'New Resume'

const pageLinks = [
    { name: title, active: true },
];

</script>

<template>
    <AppLayout :title="title" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <NewResumeForm :user="$page.props.auth.user"/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>