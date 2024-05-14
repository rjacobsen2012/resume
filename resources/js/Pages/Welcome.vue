<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <AppLayout title="Welcome">
        <h3 class="mb-4 text-1xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-3xl dark:text-white">
            Your Resume
        </h3>

        <p class="mb-3 text-gray-500 dark:text-gray-400">
            Welcome to your personal tool to present yourself to the world! Simply login with the account credentials you
            put in the .env, and build your online resume. When done, create a domain for yourself, and you have an online
            resume.
        </p>
    </AppLayout>
</template>

<style>

</style>
