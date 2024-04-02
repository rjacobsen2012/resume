<script setup>
import {ref, onMounted, watch} from 'vue';
import {SunIcon, MoonIcon} from '@heroicons/vue/20/solid';
import { usePrimeVue } from "primevue/config";
import {useForm, usePage} from "@inertiajs/vue3";

const props = defineProps({
    title: String,
    links: {
        type: Array,
        default: [],
    },
    modelValue: String,
    customClass: [String, null],
});

defineEmits(['setOption']);

// const themes = ref({
//     light: 'aura-light-blue',
//     dark: 'aura-dark-blue',
// })
//
// // set default theme folder-name to currentTheme
// const currentTheme = ref('aura-dark-blue');
//
// const PrimeVue = usePrimeVue();
//
// const setUserTheme = ref(usePage().props?.dark_theme !== null ? usePage().props?.dark_theme : null);
// const storageTheme = ref(localStorage.getItem('option'));
// const userTheme = ref(setUserTheme.value !== null ? (setUserTheme.value === true ? 'dark' : 'light') : (storageTheme.value !== null ? storageTheme.value : 'dark'))
// const option = ref(userTheme.value);
//
// const form = useForm({
//     _method: 'PUT',
//     dark_theme: option.value === 'dark',
// });
//
// const setOption = (selectedOption) => {
//     localStorage.setItem('option', selectedOption);
//     option.value = selectedOption;
//     form.dark_theme = option.value === 'dark';
//     // setTheme();
//     updateThemeInformation(form, usePage().props.auth?.user);
// }
//
// const setTheme = () => {
//     // option.value === 'dark' ? setDarkTheme() : setLightTheme();
// };
//
// const setDarkTheme = () => {
//     let theme = 'dark';
//     toggleDarkClass(theme);
//     togglePrimeVueTheme(theme);
// }
//
// const setLightTheme = () => {
//     let theme = 'light';
//     toggleDarkClass(theme);
//     togglePrimeVueTheme(theme);
// }
//
// const togglePrimeVueTheme = (theme) => {
//     let from;
//     let to;
//
//     if (theme === 'light') {
//         if (currentTheme.value !== themes.value.dark) {
//             currentTheme.value = themes.value.dark;
//         }
//
//         from = themes.value.dark;
//         to = themes.value.light;
//     } else {
//         if (currentTheme.value !== themes.value.light) {
//             currentTheme.value = themes.value.light;
//         }
//
//         from = themes.value.light;
//         to = themes.value.dark;
//     }
//
//     // console.log('from: ' + from + ', to: ' + to);
//     PrimeVue.changeTheme(from, to, 'theme-link', () => {});
//
//     // So current theme now:
//     currentTheme.value = to;
// }
//
// const updateThemeInformation = (form, user) => {
//     if (user) {
//         form.post(route('user-theme.update', [user.id]), {
//             errorBag: 'updateThemeInformation',
//             preserveScroll: true,
//         });
//     }
// }
//
// const toggleDarkClass = (className) => {
//     if (className === 'dark') {
//         document.documentElement.classList.add('dark');
//     } else {
//         document.documentElement.classList.remove('dark');
//     }
// };
//
// watch(option, setTheme);
// onMounted(() => {
    // console.log('called??');
    // setTheme();
// });
</script>

<template>
    <div :class="customClass">
        <button
            v-if="modelValue === 'dark'"
            title="Light Theme"
            class="theme-text flex text-md border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
            @click="$emit('setOption', 'light')"
        >
            <SunIcon
                class="h-6 w-6"
                aria-hidden="true"
            />
        </button>
        <button
            v-if="modelValue === 'light'"
            title="Dark Theme"
            class="theme-text flex text-md border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
            @click="$emit('setOption', 'dark')"
        >
            <MoonIcon
                class="h-6 w-6"
                aria-hidden="true"
            />
        </button>
    </div>
</template>

<style scoped>

</style>
