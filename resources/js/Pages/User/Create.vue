<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import NewUserForm from "@/Pages/User/Partials/NewUserForm.vue";

const pageLinks = [
    { name: 'Users', active: false, href: route('user.index') },
    { name: 'Create User', active: true }
];

</script>

<template>
    <AppLayout title="User Create" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <NewUserForm/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>