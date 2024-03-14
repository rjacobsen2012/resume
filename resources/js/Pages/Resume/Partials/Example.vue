<script setup>

import {useForm} from "@inertiajs/vue3";
import {flashError, flashSuccess} from "@/Composables/flash.js";
import CustomButton from "@/Components/CustomButton.vue";
import {useConfirm} from "primevue/useconfirm";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

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
    url: props.modelValue?.url ?? null,
    title: props.modelValue?.title ?? null,
});

const addExample = () => {
    form.post(route('resume.example.store', [props.resume.id]), {
        errorBag: 'addExample',
        preserveScroll: true,
        onSuccess: (response) => {
            form.id = null;
            form.url = null;
            form.title = null;
            emit('updated', response.props)
        },
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const updateExample = () => {
    form.put(route('resume.example.update', [props.resume.id, form.id]), {
        errorBag: 'updateExample',
        preserveScroll: true,
        onSuccess: (response) => emit('updated', response.props),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleteExample = () => {
    form.delete(route('resume.example.destroy', [props.resume.id, form.id]), {
        errorBag: 'deleteExample',
        preserveScroll: true,
        onSuccess: (response) => deleted(response.props),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleted = (data) => {
    flashSuccess(data.status)
}

const confirm = useConfirm();

const confirmDeleteExample = () => {
    confirm.require({
        message: 'Are you sure you want to remove the example?',
        header: 'Remove Example',
        icon: 'icon-delete',
        rejectLabel: 'No',
        rejectClass: 'btn btn-success',
        acceptLabel: 'Yes',
        acceptClass: 'btn btn-danger',
        accept: deleteExample,
    });
};

</script>

<template>
    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'title' + form.id" value="Title" />
        <TextInput
            :id="'title' + form.id"
            ref="form.title"
            v-model="form.title"
            type="text"
            class="mt-1 block w-full"
            autocomplete="title"
        />
        <InputError :message="form.errors.title" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel :for="'url' + form.id" value="Url" />
        <TextInput
            :id="'url' + form.id"
            ref="form.url"
            v-model="form.url"
            type="text"
            class="mt-1 block w-full"
            autocomplete="url"
        />
        <InputError :message="form.errors.url" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4 flex items-center justify-end px-1 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-1 sm:rounded-bl-md sm:rounded-br-md">

        <CustomButton v-if="! form.id"
                      @click="addExample"
                      :class="{ 'opacity-25': form.processing }"
                      type="button"
                      :disabled="form.processing"
                      class="btn-light">
            Add
        </CustomButton>

        <CustomButton v-if="form.id"
                      @click="updateExample"
                      :class="{ 'opacity-25': form.processing }"
                      type="button"
                      :disabled="form.processing"
                      class="btn-light">
            Update
        </CustomButton>

        <CustomButton v-if="form.id" @click="confirmDeleteExample" type="button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ms-2 btn-danger">
            Delete
        </CustomButton>
    </div>
</template>

<style scoped>

</style>
