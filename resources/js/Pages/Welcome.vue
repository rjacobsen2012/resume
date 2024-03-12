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
        {{ $page.props.auth.user?.resume }}
        Hello World!
    </AppLayout>
</template>

<style>

</style>
