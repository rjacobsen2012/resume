<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import EditPermissionForm from "@/Pages/Spatie/Permission/Partials/EditPermissionForm.vue";

const pageLinks = [
    { name: 'Permissions', active: false, href: route('permission.index') },
    { name: 'Permission', active: true }
];

</script>

<template>
    <AppLayout title="Permission Edit" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditPermissionForm :permission="$page.props.permission"/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>