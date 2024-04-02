<script setup>

import {useForm} from "@inertiajs/vue3";
import {flashError, flashSuccess} from "@/Composables/flash.js";
import CustomButton from "@/Components/CustomButton.vue";
import {useConfirm} from "primevue/useconfirm";

const emit = defineEmits([
    'updated',
    'errors',
]);

const props = defineProps({
    resume: [Array, Object],
    modelValue: {
        type: [Array,Object],
        default: null,
    },
});

const form = useForm({
    id: props.modelValue?.id ?? null,
    name: props.modelValue?.name ?? null,
    years: props.modelValue?.years ?? 0,
    months: props.modelValue?.months ?? 0,
});

const addSkill = () => {
    form.post(route('resume.skill.store', [props.resume.id]), {
        errorBag: 'addSkill',
        preserveScroll: true,
        onSuccess: (response) => {
            form.id = null;
            form.name = null;
            form.years = null;
            form.months = null;
            emit('updated', response.props)
        },
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const updateSkill = () => {
    form.put(route('resume.skill.update', [props.resume.id, form.id]), {
        errorBag: 'updateSkill',
        preserveScroll: true,
        onSuccess: (response) => emit('updated', response.props),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleteSkill = () => {
    form.delete(route('resume.skill.destroy', [props.resume.id, form.id]), {
        errorBag: 'deleteSkill',
        preserveScroll: true,
        onSuccess: (response) => deleted(response.props),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleted = (data) => {
    flashSuccess(data.status)
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

</script>

<template>
    <td class="px-1 py-1">
        <input type="text" :id="'name' + form.id" v-model="form.name" class="bg-gray-50 w-28 border-0 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
    </td>
    <td class="px-1 py-1">
        <input type="number" :id="'years' + form.id" v-model="form.years" class="bg-gray-50 w-14 border-0 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1" required />
    </td>
    <td class="px-1 py-1">
        <input type="number" :id="'months' + form.id" v-model="form.months" class="bg-gray-50 w-14 border-0 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1" required />
    </td>
    <td class="px-3 py-2 flex flex-row items-center gap-2">
        <CustomButton v-if="! form.id" @click="addSkill" type="button" class="btn btn-light px-1 py-1 rounded-full">
            <span class="ps-0.5 d-none d-sm-table-cell">Add</span>
            <span class="ps-0.5 d-table-cell d-sm-none"><i class="fa fa-floppy-disk fa-xl"></i></span>
        </CustomButton>

        <CustomButton v-if="form.id" @click="updateSkill" type="button" class="btn btn-light px-1 py-1 rounded-full">
            <span class="ps-0.5 d-none d-sm-table-cell">Update</span>
            <span class="ps-0.5 d-table-cell d-sm-none"><i class="fa fa-floppy-disk fa-xl"></i></span>
        </CustomButton>

        <CustomButton v-if="form.id" @click="confirmDeleteSkill" type="button" class="btn btn-danger px-1 py-1 rounded-full">
            <span class="ps-0.5 d-none d-sm-table-cell">Delete</span>
            <span class="ps-0.5 d-table-cell d-sm-none"><i class="fa fa-minus fa-xl"></i></span>
        </CustomButton>
    </td>
</template>

<style scoped>

</style>
