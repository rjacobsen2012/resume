<script setup>
import {ref, onMounted, watch} from 'vue';
import {SunIcon, MoonIcon} from '@heroicons/vue/20/solid';

const option = ref(localStorage.getItem('option') ?? 'light');

const setOption = (selectedOption) => {
    localStorage.setItem('option', selectedOption);
    option.value = selectedOption;
}

const setTheme = () => {
    option.value === 'dark' ? toggleDarkClass('dark') : toggleDarkClass('light')
};

const toggleDarkClass = (className) => {
    if (className === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};
watch(option, setTheme);
onMounted(() => {
    setTheme();
});
</script>

<template>
    <button
        v-if="option === 'dark'"
        title="Light Theme"
        class="theme-text flex text-md border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
        @click="setOption('light')"
    >
        <SunIcon
            class="h-6 w-6"
            aria-hidden="true"
        />
    </button>
    <button
        v-if="option === 'light'"
        title="Dark Theme"
        class="theme-text flex text-md border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
        @click="setOption('dark')"
    >
        <MoonIcon
            class="h-6 w-6"
            aria-hidden="true"
        />
    </button>
</template>

<style scoped>

</style>
