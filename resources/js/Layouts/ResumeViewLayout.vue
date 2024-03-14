<script setup>
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import ApplicationMark from "@/Components/ApplicationMark.vue";
import NavLink from "@/Components/NavLink.vue";
import ThemeSwitchButton from "@/Components/ThemeSwitchButton.vue";
import ALink from "@/Components/ALink.vue";
import Icon from "@/Components/Icon.vue";

const props = defineProps({
    resume: [Array, Object],
    title: String,
});
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            <nav class="dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700 shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-row justify-between align-items-center h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <img :src="resume.user.gravatar" class="rounded-full"/>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-3">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <div class="flex justify-end items-center">
                                    <a-link :href="`mailto:${resume.email}`" :title="Email">
                                        <icon class="me-2" icon-class="fa fa-envelope"/>{{ resume.email }}
                                    </a-link>

                                    <a-link :href="`tel:${resume.phone}`" :title="Call" class="ms-2">
                                        <icon class="me-2" icon-class="fa fa-phone-square"/>{{ resume.phone }}
                                    </a-link>

                                    <a-link v-if="resume.pdf_resume" :href="route('resume.download', [resume.id, 'pdf'])" title="Download PDF Resume" class="ms-2">
                                        <icon icon-class="fa fa-file-pdf"/>
                                    </a-link>

                                    <a-link v-if="resume.word_resume" :href="route('resume.download', [resume.id, 'word'])" title="Download Word Resume" class="ms-2">
                                        <icon icon-class="fa fa-file-word"/>
                                    </a-link>

                                    <ThemeSwitchButton class="ms-2"/>
                                </div>
                            </div>
                        </div>

                        <!-- Hamburger -->
<!--                        <div class="-me-2 flex items-center sm:hidden">-->
<!--                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">-->
<!--                                <svg-->
<!--                                    class="h-6 w-6"-->
<!--                                    stroke="currentColor"-->
<!--                                    fill="none"-->
<!--                                    viewBox="0 0 24 24"-->
<!--                                >-->
<!--                                    <path-->
<!--                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"-->
<!--                                        stroke-linecap="round"-->
<!--                                        stroke-linejoin="round"-->
<!--                                        stroke-width="2"-->
<!--                                        d="M4 6h16M4 12h16M4 18h16"-->
<!--                                    />-->
<!--                                    <path-->
<!--                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"-->
<!--                                        stroke-linecap="round"-->
<!--                                        stroke-linejoin="round"-->
<!--                                        stroke-width="2"-->
<!--                                        d="M6 18L18 6M6 6l12 12"-->
<!--                                    />-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                        </div>-->
                    </div>
                </div>
            </nav>
        </div>
    </div>
</template>

<style scoped>

</style>
