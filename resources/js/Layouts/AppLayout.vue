<script setup>
import {onMounted, ref} from 'vue';
import {Head, Link, router, usePage, useForm} from '@inertiajs/vue3';
import ConfirmDialog from "primevue/confirmdialog";
import { usePrimeVue } from "primevue/config";
import ThemeSwitchButton from "@/Components/ThemeSwitchButton.vue";
import ALink from "@/Components/ALink.vue";

defineProps({
    title: String,
    links: {
        type: Array,
        default: [],
    },
    resume: [Array, Object, null],
});

const themes = ref({
    light: 'aura-light-blue',
    dark: 'aura-dark-blue',
});

const currentTheme = ref('aura-dark-blue');

const PrimeVue = usePrimeVue();

const setUserTheme = ref(usePage().props?.dark_theme !== null ? usePage().props?.dark_theme : null);
const storageTheme = ref(localStorage.getItem('option'));
const userTheme = ref(setUserTheme.value !== null ? (setUserTheme.value === true ? 'dark' : 'light') : (storageTheme.value !== null ? storageTheme.value : 'dark'))
const option = ref(userTheme.value);

const form = useForm({
    _method: 'PUT',
    dark_theme: option.value === 'dark',
});

const updateThemeInformation = (form, user) => {
    if (user) {
        form.post(route('user-theme.update', [user.id]), {
            errorBag: 'updateThemeInformation',
            preserveScroll: true,
        });
    }
};

const setTheme = () => {
    option.value === 'dark' ? setDarkTheme() : setLightTheme();
};

const toggleDarkClass = (className) => {
    if (className === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

const setDarkTheme = () => {
    let theme = 'dark';
    toggleDarkClass(theme);
    togglePrimeVueTheme(theme);
}

const setLightTheme = () => {
    let theme = 'light';
    toggleDarkClass(theme);
    togglePrimeVueTheme(theme);
}

const togglePrimeVueTheme = (theme) => {
    let from;
    let to;

    if (theme === 'light') {
        if (currentTheme.value !== themes.value.dark) {
            currentTheme.value = themes.value.dark;
        }

        from = themes.value.dark;
        to = themes.value.light;
    } else {
        if (currentTheme.value !== themes.value.light) {
            currentTheme.value = themes.value.light;
        }

        from = themes.value.light;
        to = themes.value.dark;
    }

    // console.log('from: ' + from + ', to: ' + to);
    PrimeVue.changeTheme(from, to, 'theme-link', () => {});

    // So current theme now:
    currentTheme.value = to;
}

const setOption = (selectedOption) => {
    localStorage.setItem('option', selectedOption);
    option.value = selectedOption;
    form.dark_theme = option.value === 'dark';
    setTheme();
    updateThemeInformation(form, usePage().props.auth?.user);
}

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};

onMounted(() => {
    setTheme();
});
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="theme-bg theme-text">
            <nav class="top-nav navbar navbar-expand ps-3 sm:ps-4 pe-2 sm:pe-4 shadow-md nav-bg pb-1 pt-1">
                <ul class="navbar-nav ms-auto notifications pr-2 flex items-center">

                    <li v-if="$page.props.auth.user && ! route().current('resume.edit')" class="nav-item">
                        <a-link :href="route('resume.edit')" title="Edit Resume" class="link-icon ms-2 sm:ms-10 py-2">
                            <i class="fa fa-pencil"/>
                        </a-link>
                    </li>

                    <li v-if="! route().current('resume.index')" class="nav-item">
                        <a-link :href="route('resume.index')" title="Home" class="link-icon ms-2 py-2">
                            <i class="fa fa-home"/>
                        </a-link>
                    </li>

                    <li v-if="! $page.props.auth.user && ! route().current('login')" title="Login">
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

                    <li class="nav-item ms-4">
                        <theme-switch-button v-model="option" @set-option="setOption"/>
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
    <ConfirmDialog/>
</template>
