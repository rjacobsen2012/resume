<script setup>
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import ApplicationMark from "@/Components/ApplicationMark.vue";
import NavLink from "@/Components/NavLink.vue";
import ThemeSwitchButton from "@/Components/ThemeSwitchButton.vue";
import ALink from "@/Components/ALink.vue";
import Icon from "@/Components/Icon.vue";
import AppLogo from "@/Components/AppLogo.vue";

const props = defineProps({
    resume: [Array, Object],
    title: String,
});
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="theme-bg theme-text">
            <nav class="top-nav navbar navbar-expand ps-3 sm:ps-4 pe-2 sm:pe-4 shadow-md nav-bg pb-1 pt-1">
                <a class="navbar-brand flex flex-row justify-start items-center" href="">
                    <Link :href="route('home.index')">
                        <app-logo :small="true"/>
                    </Link>
                </a>

                <ul class="navbar-nav ms-auto notifications pr-2">

<!--                    <li class="nav-item hidden sm:flex sm:items-center sm:ms-3">-->
<!--                        <a-link :href="'mailto:' + resume.email" target="_blank" title="Email" class="link-text">-->
<!--                            <i class="fa fa-envelope"/>{{ resume.email }}-->
<!--                        </a-link>-->
<!--                    </li>-->

<!--                    <li class="nav-item sm:hidden">-->
<!--                        <a-link :href="'mailto:' + resume.email" target="_blank" title="Email" class="link-text py-2">-->
<!--                            <i class="fa fa-envelope"/>-->
<!--                        </a-link>-->
<!--                    </li>-->

<!--                    <li class="nav-item hidden sm:flex sm:items-center sm:ms-3">-->
<!--                        <a-link :href="'tel:' + resume.phone"-->
<!--                                target="_blank" title="Phone" class="link-text ms-2">-->
<!--                            <i class="fa fa-phone-square"/>{{ resume.phone }}-->
<!--                        </a-link>-->
<!--                    </li>-->

<!--                    <li class="nav-item sm:hidden">-->
<!--                        <a-link :href="'tel:' + resume.phone"-->
<!--                                target="_blank" title="Phone" class="link-text ms-2 py-2">-->
<!--                            <i class="fa fa-phone-square"/>-->
<!--                        </a-link>-->
<!--                    </li>-->

<!--                    <li v-if="resume.pdf_resume !== null" class="nav-item">-->
<!--                        <a-link :href="route('resume.download', [resume.id, 'pdf'])"-->
<!--                                target="_blank" title="Download PDF Resume" class="link-icon ms-2">-->
<!--                            <i class="fa fa-file-pdf fa-lg"/>-->
<!--                        </a-link>-->
<!--                    </li>-->

<!--                    <li v-if="resume.word_resume !== null" class="nav-item">-->
<!--                        <a-link :href="route('resume.download', [resume.id, 'word'])"-->
<!--                                target="_blank" title="Download Word Resume" class="link-icon ms-2">-->
<!--                            <i class="fa fa-file-word fa-lg"/>-->
<!--                        </a-link>-->
<!--                    </li>-->

                    <li v-if="$page.props.auth.user && resume.user_id === $page.props.auth.user.id" class="nav-item">
                        <a-link :href="route('resume.edit', [resume.id])" title="Edit Resume" class="link-icon ms-2 sm:ms-10 py-2">
                            <i class="fa fa-pencil"/>
                        </a-link>
                    </li>

                    <li class="nav-item">
                        <a-link :href="route('home.index')" title="Home" class="link-icon ms-2 py-2">
                            <i class="fa fa-home"/>
                        </a-link>
                    </li>

                    <li v-if="! $page.props.auth.user" title="Login">
                        <a-link :href="route('login')" title="Login" class="link-icon ms-2 py-2">
                            <i class="fa fa-key"/>
                        </a-link>
                    </li>

                    <li v-if="$page.props.auth.user"
                        title="Logout"
                        class="nav-item">
                        <Link :href="route('logout')" method="post" as="button" class="link-icon py-1 ms-2">
                            <i class="fa fa-sign-out-alt"/>
                        </Link>
                    </li>

                    <li class="nav-item ms-2">
                        <theme-switch-button/>
                    </li>

                </ul>
            </nav>

            <!-- Page Heading -->
            <header class="dark:bg-gray-700 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="px-2.5 py-3">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>

</style>
