<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import NewRoleForm from "@/Pages/Spatie/Role/Partials/NewRoleForm.vue";

const pageLinks = [
    { name: 'Roles', active: false, href: route('role.index') },
    { name: 'Create Role', active: true }
];

</script>

<template>
    <AppLayout title="Role Create" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <NewRoleForm/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>