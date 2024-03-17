<script setup>
import {onMounted, ref, watch} from 'vue';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ConfirmDialog from "primevue/confirmdialog";
import AppLogo from "@/Components/AppLogo.vue";
import ThemeSwitchButton from "@/Components/ThemeSwitchButton.vue";

defineProps({
    title: String,
    links: {
        type: Array,
        default: [],
    },
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            <nav class="dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700 shadow">

                <!-- Primary Navigation Menu -->
                <div v-if="! $page.props.auth.user" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-row justify-between align-items-center h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <a class="navbar-brand flex flex-row justify-start items-center" href="">
                                <Link :href="route('home.index')">
                                    <app-logo/>
                                </Link>
                            </a>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-3">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <div class="flex justify-end items-center">
                                    <NavLink :href="route('login')" :active="route().current('login')">
                                        Login
                                    </NavLink>

                                    <NavLink :href="route('register')" class="ms-2" :active="route().current('register')">
                                        Register
                                    </NavLink>

                                    <theme-switch-button class="ms-4"/>
                                </div>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>

                            <theme-switch-button class="ms-2"/>
                        </div>
                    </div>
                </div>

                <div v-if="$page.props.auth.user" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-row justify-between align-items-center h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="ps-3 sm:ps-4 pe-2 sm:pe-4">
                                <a class="navbar-brand flex flex-row justify-start items-center" href="">
                                    <Link :href="route('home.index')">
                                        <app-logo/>
                                    </Link>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('home.index')" :active="route().current('home.index')">
                                    Home
                                </NavLink>

                                <NavLink v-if="$page.props.user.resume" :href="route('resume.show', [$page.props.user.resume.id])" :active="route().current('resume.show')">
                                    View Resume
                                </NavLink>

                                <NavLink v-if="$page.props.user.resume" :href="route('resume.edit', [$page.props.user.resume.id])" :active="route().current('resume.edit')">
                                    Edit Resume
                                </NavLink>

                                <NavLink v-if="! $page.props.user.resume" :href="route('resume.create')" :active="route().current('resume.create')">
                                    Create Resume
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-3">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="nav-dropdown-button">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')" :active="route().current('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.user.resume" :href="route('resume.show', [$page.props.user.resume.id])" :active="route().current('resume.show')">
                                            View Resume
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.user.resume" :href="route('resume.edit', [$page.props.user.resume.id])" :active="route().current('resume.edit')">
                                            Edit Resume
                                        </DropdownLink>

                                        <DropdownLink v-if="! $page.props.user.resume" :href="route('resume.create')" :active="route().current('resume.create')">
                                            Create Resume
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <DropdownLink :href="route('spark.portal')">
                                            Billing
                                        </DropdownLink>

                                        <div v-if="$page.props.auth.user.is_admin" class="border-t border-gray-200 dark:border-gray-600" />

                                        <div v-if="$page.props.auth.user.is_admin" class="block px-4 py-2 text-xs text-gray-400">
                                            Administration
                                        </div>

                                        <DropdownLink v-if="$page.props.auth.user.is_admin" :href="route('role.index')">
                                            Roles
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.auth.user.is_admin" :href="route('permission.index')">
                                            Permissions
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.auth.user.is_admin" :href="route('user.index')">
                                            Users
                                        </DropdownLink>

                                        <div class="border-t border-gray-200 dark:border-gray-600" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>

                            <div class="ms-2"><img :src="$page.props.auth.user.gravatar" :alt="$page.props.auth.user.name" width="35" class="rounded-full"/></div>

                            <ThemeSwitchButton custom-class="ms-4"/>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div v-if="! $page.props.auth.user" :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('login')" :active="route().current('login')">
                            Login
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('register')" :active="route().current('register')">
                            Register
                        </ResponsiveNavLink>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div v-if="$page.props.auth.user" :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('home.index')" :active="route().current('home.index')">
                            Home
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.user.resume" :href="route('resume.show', [$page.props.user.resume.id])" :active="route().current('resume.show')">
                                View Resume
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.user.resume" :href="route('resume.edit', [$page.props.user.resume.id])" :active="route().current('resume.edit')">
                                Edit Resume
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="! $page.props.user.resume" :href="route('resume.create')" :active="route().current('resume.create')">
                                Create Resume
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>
                        </div>
                    </div>

                    <!-- Responsive Admin Options -->
                    <div v-if="$page.props.auth.user.is_admin" class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center px-4">
                            <div>
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                    Administration
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('role.index')" :active="route().current('role.index')">
                                Roles
                            </ResponsiveNavLink>

                            <ResponsiveNavLink :href="route('permission.index')" :active="route().current('permission.index')">
                                Permissions
                            </ResponsiveNavLink>

                            <ResponsiveNavLink :href="route('user.index')" :active="route().current('user.index')">
                                Users
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="links.length > 0" class="dark:bg-gray-800 bg-gray-200 shadow">
                <div class="flex justify-between">
                    <div class="flex flex-row justify-content-start items-center">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <slot v-if="links.length === 0" name="header" />
                            <Breadcrumb :links="links"/>
                        </div>
                    </div>
                    <div class="flex flex-row justify-content-end items-center">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <slot name="right-links" />
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
    <ConfirmDialog/>
</template>
