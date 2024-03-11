<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import NewPermissionForm from "@/Pages/Spatie/Permission/Partials/NewPermissionForm.vue";

const pageLinks = [
    { name: 'Permissions', active: false, href: route('permission.index') },
    { name: 'Create Permission', active: true }
];

</script>

<template>
    <AppLayout title="Permission Create" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <NewPermissionForm/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>