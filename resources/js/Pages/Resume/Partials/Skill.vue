<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import {flashError, flashSuccess} from "@/Composables/flash.js";
import TextInput from "@/Components/TextInput.vue";
import CustomButton from "@/Components/CustomButton.vue";
import {useConfirm} from "primevue/useconfirm";

const props = defineProps({
    resume: [Array, Object],
    modelValue: {
        type: [Array,Object],
        default: null,
    },
});

const form = useForm({
    id: props.modelValue?.id,
    name: props.modelValue?.name ?? null,
    years: props.modelValue?.years ?? 0,
    months: props.modelValue?.months ?? 0,
});

const addSkill = () => {
    form.post(route('resume.skill.store', [props.resume.id]), {
        errorBag: 'addSkill',
        preserveScroll: true,
        onSuccess: (response) => {
            form.id = null
            form.name = null
            form.years = 0
            form.months = 0
            flashSuccess(response.props.status)
        },
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const updateSkill = () => {
    form.post(route('resume.skill.update', [props.resume.id, form.id]), {
        errorBag: 'updateSkill',
        preserveScroll: true,
        onSuccess: (response) => flashSuccess(response.props.status),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleteSkill = () => {
    form.delete(route('resume.skill.destroy', [props.resume.id, form.id]), {
        errorBag: 'deleteSkill',
        preserveScroll: true,
        onSuccess: (response) => flashSuccess(response.props.status),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const confirm = useConfirm();

const confirmDeleteSkill = () => {
    confirm.require({
        message: 'Are you sure you want to remove the skill?',
        header: 'Remove Skill',
        icon: 'icon-delete',
        rejectLabel: 'No',
        rejectClass: 'btn btn-success',
        acceptLabel: 'Yes',
        acceptClass: 'btn btn-danger',
        accept: deleteSkill,
    });
};

const incrementYears = () => {
    form.years += 1;
}

const decrementYears = () => {
    if (form.years) {
        form.years -= 1;
    }
}

const incrementMonths = () => {
    form.months += 1;
}

const decrementMonths = () => {
    if (form.months) {
        form.months -= 1;
    }
}

</script>

<template>
    <td class="px-1 py-2">
        <div class="ms-3">
            <input type="text" id="name" v-model="form.name" class="bg-gray-50 w-40 border-0 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>
    </td>
    <td class="px-2 py-2">
        <div class="flex items-center">
            <button @click="decrementYears" class="inline-flex items-center justify-center p-1 text-sm font-medium h-6 w-6 text-gray-500 bg-white border-0 border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                <span class="sr-only">Quantity button</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                </svg>
            </button>
            <div class="ms-3">
                <input type="number" id="years" v-model="form.years" class="bg-gray-50 w-14 border-0 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1" required />
            </div>
            <button @click="incrementYears" class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border-0 border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                <span class="sr-only">Quantity button</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
            </button>
        </div>
    </td>
    <td class="px-2 py-2">
        <div class="flex items-center">
            <button @click="decrementMonths" class="inline-flex items-center justify-center p-1 text-sm font-medium h-6 w-6 text-gray-500 bg-white border-0 border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                <span class="sr-only">Quantity button</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                </svg>
            </button>
            <div class="ms-3">
                <input type="number" id="months" v-model="form.months" class="bg-gray-50 w-14 border-0 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1" required />
            </div>
            <button @click="incrementMonths" class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border-0 border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                <span class="sr-only">Quantity button</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
            </button>
        </div>
<!--        <TextInput-->
<!--            id="months"-->
<!--            v-model="form.months"-->
<!--            type="number"-->
<!--            step="1"-->
<!--            min="0"-->
<!--            class="mt-1 block w-full"-->
<!--            required-->
<!--            autocomplete="months"-->
<!--        />-->
    </td>
    <td class="px-6 py-4 d-flex flex-row justify-content-end gap-2">
        <CustomButton v-if="! form.id" @click="addSkill" type="button" class="btn-success">
            <i class="fa fa-add"></i>
        </CustomButton>

        <CustomButton v-if="form.id" @click="updateSkill" type="button" class="btn-success">
            <i class="fa fa-save"></i>
        </CustomButton>

        <CustomButton v-if="form.id" @click="confirmDeleteSkill" type="button" class="btn-success">
            <i class="fa fa-add"></i>
        </CustomButton>
    </td>
</template>

<style scoped>

</style>