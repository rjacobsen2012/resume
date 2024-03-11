<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import EditRoleForm from "@/Pages/Spatie/Role/Partials/EditRoleForm.vue";

const pageLinks = [
    { name: 'Roles', active: false, href: route('role.index') },
    { name: 'Role', active: true }
];

</script>

<template>
    <AppLayout title="Role Edit" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditRoleForm :role="$page.props.role"/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>