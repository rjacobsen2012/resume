<script setup>

import {useForm} from "@inertiajs/vue3";
import {flashError, flashSuccess} from "@/Composables/flash.js";
import CustomButton from "@/Components/CustomButton.vue";
import {useConfirm} from "primevue/useconfirm";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Textarea from "primevue/textarea";

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
    school: props.modelValue?.school ?? null,
    city: props.modelValue?.city ?? null,
    state: props.modelValue?.state ?? null,
    degree: props.modelValue?.degree ?? null,
    started_at: props.modelValue?.started_at ?? null,
    ended_at: props.modelValue?.ended_at ?? null,
    description: props.modelValue?.description ?? null,
});

const addEducation = () => {
    form.post(route('resume.education.store', [props.resume.id]), {
        errorBag: 'addEducation',
        preserveScroll: true,
        onSuccess: (response) => {
            form.id = null
            form.school = null
            form.city = null
            form.state = null
            form.degree = null
            form.started_at = null
            form.ended_at = null
            form.description = null
            emit('updated', response.props)
        },
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const updateEducation = () => {
    form.put(route('resume.education.update', [props.resume.id, form.id]), {
        errorBag: 'updateEducation',
        preserveScroll: true,
        onSuccess: (response) => emit('updated', response.props),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleteEducation = () => {
    form.delete(route('resume.education.destroy', [props.resume.id, form.id]), {
        errorBag: 'deleteEducation',
        preserveScroll: true,
        onSuccess: (response) => deleted(response.props),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleted = (data) => {
    flashSuccess(data.status)
}

const confirm = useConfirm();

const confirmDeleteEducation = () => {
    confirm.require({
        message: 'Are you sure you want to remove the education?',
        header: 'Remove Education',
        icon: 'icon-delete',
        rejectLabel: 'No',
        rejectClass: 'btn btn-success',
        acceptLabel: 'Yes',
        acceptClass: 'btn btn-danger',
        accept: deleteEducation,
    });
};

</script>

<template>
    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'school' + form.id" value="School" />
        <TextInput
            :id="'school' + form.id"
            ref="form.school"
            v-model="form.school"
            type="text"
            class="mt-1 block w-full"
            autocomplete="school"
        />
        <InputError :message="form.errors.school" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'city' + form.id" value="City" />
        <TextInput
            :id="'city' + form.id"
            ref="form.city"
            v-model="form.city"
            type="text"
            class="mt-1 block w-full"
            autocomplete="city"
        />
        <InputError :message="form.errors.city" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'state' + form.id" value="State" />
        <TextInput
            :id="'state' + form.id"
            ref="form.state"
            v-model="form.state"
            type="text"
            class="mt-1 block w-full"
            autocomplete="state"
        />
        <InputError :message="form.errors.state" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'degree' + form.id" value="Degree" />
        <TextInput
            :id="'degree' + form.id"
            ref="form.degree"
            v-model="form.degree"
            type="text"
            class="mt-1 block w-full"
            autocomplete="degree"
        />
        <InputError :message="form.errors.degree" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'started_at' + form.id" value="Started" />
        <TextInput
            :id="'started_at' + form.id"
            ref="form.started_at"
            v-model="form.started_at"
            type="date"
            class="mt-1 block w-full"
            autocomplete="started_at"
        />
        <InputError :message="form.errors.started_at" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'ended_at' + form.id" value="Ended" />
        <TextInput
            :id="'ended_at' + form.id"
            ref="form.ended_at"
            v-model="form.ended_at"
            type="date"
            class="mt-1 block w-full"
            autocomplete="ended_at"
        />
        <InputError :message="form.errors.ended_at" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'description' + form.id" value="Description" />
        <Textarea class="block p-2.5 mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  v-model="form.description"
                  rows="6"
                  required/>
        <InputError :message="form.errors.description" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4 flex items-center justify-end px-1 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-1 sm:rounded-bl-md sm:rounded-br-md">

        <CustomButton v-if="! form.id"
                      @click="addEducation"
                      :class="{ 'opacity-25': form.processing }"
                      type="button"
                      :disabled="form.processing"
                      class="btn-light">
            Add
        </CustomButton>

        <CustomButton v-if="form.id"
                      @click="updateEducation"
                      :class="{ 'opacity-25': form.processing }"
                      type="button"
                      :disabled="form.processing"
                      class="btn-light">
            Update
        </CustomButton>

        <CustomButton v-if="form.id" @click="confirmDeleteEducation" type="button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ms-2 btn-danger">
            Delete
        </CustomButton>
    </div>
</template>

<style scoped>

</style>
