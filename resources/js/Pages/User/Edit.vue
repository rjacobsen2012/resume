<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import EditUserForm from "@/Pages/User/Partials/EditUserForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import EditUserRolesForm from "@/Pages/User/Partials/EditUserRolesForm.vue";

const pageLinks = [
    { name: 'Users', active: false, href: route('user.index') },
    { name: 'User', active: true }
];

</script>

<template>
    <AppLayout title="User Edit" :links="pageLinks">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditUserForm :user="$page.props.user"/>

                <SectionBorder />

                <EditUserRolesForm :user="$page.props.user" :roles="$page.props.roles"/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>