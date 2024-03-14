<script setup>
import {useForm, usePage} from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import Checkbox from "@/Components/Checkbox.vue";
import {updateThemeInformation} from "@/Composables/themeSwitcher.js";
import {ref} from "vue";
import {MoonIcon, SunIcon} from "@heroicons/vue/20/solid/index.js";

const option = ref(usePage().props.dark_theme ? 'dark' : 'light');

const form = useForm({
    _method: 'PUT',
    dark_theme: option.value === 'dark',
});

const setOption = () => {
    option.value = form.dark_theme ? 'dark' : 'light';
    updateThemeInformation(form, props.user, option.value);
}

const props = defineProps({
    user: Object,
});
</script>

<template>
    <FormSection>
        <template #title>
            Site Theme Information
        </template>

        <template #description>
            Choose to use dark or light mode.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.dark_theme" @change="setOption" name="dark_theme" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Use Dark Theme</span>
                    <SunIcon
                        v-if="form.dark_theme"
                        class="ms-2 h-6 w-6 text-gray-600 dark:text-gray-400"
                        aria-hidden="true"
                    />
                    <MoonIcon
                        v-else
                        class="ms-2 h-6 w-6 text-gray-600 dark:text-gray-400"
                        aria-hidden="true"
                    />
                </label>
            </div>
        </template>
    </FormSection>
</template>
