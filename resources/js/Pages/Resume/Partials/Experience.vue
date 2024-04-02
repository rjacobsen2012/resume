<script setup>

import {useForm} from "@inertiajs/vue3";
import {flashError, flashSuccess} from "@/Composables/flash.js";
import CustomButton from "@/Components/CustomButton.vue";
import {useConfirm} from "primevue/useconfirm";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Textarea from "primevue/textarea";
import {ref} from "vue";

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

const isPresent = ref(props.modelValue.present);
const isHidden = ref(props.modelValue.is_hidden);

const updatePresent = () => {
    isPresent.value = form.present
}

const updateHidden = () => {
    isHidden.value = form.is_hidden
}

const form = useForm({
    id: props.modelValue?.id ?? null,
    company_name: props.modelValue?.company_name ?? null,
    title: props.modelValue?.title ?? null,
    city: props.modelValue?.city ?? null,
    state: props.modelValue?.state ?? null,
    started_at: props.modelValue?.started_at ?? null,
    ended_at: props.modelValue?.ended_at ?? null,
    present: props.modelValue?.present ?? null,
    description: props.modelValue?.description ?? null,
    is_hidden: props.modelValue?.is_hidden ?? null,
});

const addExperience = () => {
    form.post(route('resume.experience.store', [props.resume.id]), {
        errorBag: 'addExperience',
        preserveScroll: true,
        onSuccess: (response) => {
            form.id = null
            form.company_name = null
            form.title = null
            form.city = null
            form.state = null
            form.started_at = null
            form.ended_at = null
            form.present = null
            form.description = null
            form.is_hidden = null
            emit('updated', response.props)
        },
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const updateExperience = () => {
    form.put(route('resume.experience.update', [props.resume.id, form.id]), {
        errorBag: 'updateExperience',
        preserveScroll: true,
        onSuccess: (response) => emit('updated', response.props),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleteExperience = () => {
    form.delete(route('resume.experience.destroy', [props.resume.id, form.id]), {
        errorBag: 'deleteExperience',
        preserveScroll: true,
        onSuccess: (response) => deleted(response.props),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const deleted = (data) => {
    flashSuccess(data.status)
}

const confirm = useConfirm();

const confirmDeleteExperience = () => {
    confirm.require({
        message: 'Are you sure you want to remove the experience?',
        header: 'Remove Experience',
        icon: 'icon-delete',
        rejectLabel: 'No',
        rejectClass: 'btn btn-success',
        acceptLabel: 'Yes',
        acceptClass: 'btn btn-danger',
        accept: deleteExperience,
    });
};

</script>

<template>
    <div class="px-4 py-3 sm:p-6 shadow sm:rounded-md" :class="! isHidden ? 'dark:bg-gray-800' : 'dark:bg-gray-700'">
        <div class="grid grid-cols-1 gap-6">
            <div v-if="isHidden" class="col-span-6 sm:col-span-4 uppercase text-white flex justify-center">
                ****** This experience is hidden from the public resume ******
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel :for="'company_name' + form.id" value="Company Name" />
                <TextInput
                    :id="'company_name' + form.id"
                    ref="form.company_name"
                    v-model="form.company_name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="company_name"
                />
                <InputError :message="form.errors.company_name" class="mt-2" />
            </div>

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

            <div v-if="! isPresent" class="col-span-6 sm:col-span-4">
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
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.present" @change="updatePresent" name="present" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Present Experience</span>
                </label>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel :for="'description' + form.id" value="Description" />
                <Textarea class="block p-2.5 mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                          v-model="form.description"
                          rows="6"
                          required/>
                <InputError :message="form.errors.description" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.is_hidden" @change="updateHidden" name="is_hidden" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Hide Experience <span class="text-xs text-gray-500 italic">(If this is checked, the experience will be hidden from the public resume)</span></span>
                </label>
            </div>

            <div class="col-span-6 sm:col-span-4 flex items-center justify-end px-1 py-3 text-end sm:px-1 sm:rounded-bl-md sm:rounded-br-md">

                <CustomButton v-if="! form.id"
                              @click="addExperience"
                              :class="{ 'opacity-25': form.processing }"
                              type="button"
                              :disabled="form.processing"
                              class="btn-light">
                    Add
                </CustomButton>

                <CustomButton v-if="form.id"
                              @click="updateExperience"
                              :class="{ 'opacity-25': form.processing }"
                              type="button"
                              :disabled="form.processing"
                              class="btn-light">
                    Update
                </CustomButton>

                <CustomButton v-if="form.id" @click="confirmDeleteExperience" type="button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ms-2 btn-danger">
                    Delete
                </CustomButton>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
