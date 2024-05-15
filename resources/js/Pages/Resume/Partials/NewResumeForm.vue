<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputGroupButton from "@/Components/InputGroupButton.vue";
import {flashSuccess} from "@/Composables/flash.js";
import {flashError} from "@/Composables/flash.js";
import {labels} from "@/Composables/resumeShared.js";

const props = defineProps({
    user: Object,
});

const form = useForm({
    title: props.user.title,
    name: props.user.name,
    email: props.user.email,
    profile: null,
    linked_in_profile: null,
    github_profile: null,
    phone: null,
    city: null,
    state: null,
    country: null,
    pdf_file: 'Click to add pdf resume',
    word_file: 'Click to add word resume',
    pdf_resume: null,
    word_resume: null,
    is_hidden: null,
    has_word_resume: false,
    has_pdf_resume: false,
});

const store = () => {
    form.post(route('resume.store'), {
        errorBag: 'createResume',
        preserveScroll: true,
        onSuccess: (response) => flashSuccess(response.props.status),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
}

const chooseResume = (id) => {
    document.getElementById(id).click();
};

const selectedResume = (file, type) => {
    form[type + '_resume'] = file;
    form[type + '_file'] = file.name;
    form['has_' + type + '_resume'] = true;
}

const clearResume = (type) => {
    form[type + '_resume'] = null;
    form[type + '_file'] = 'Click to add ' + type + ' resume';
    form['has_' + type + '_resume'] = false;
}

</script>

<template>
    <FormSection @submitted="store">
        <template #title>
            Resume Profile
        </template>

        <template #description>
            Build your resume profile.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="title" :value="labels.title"/>
                <TextInput
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="title"
                />
                <InputError :message="form.errors.title" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" :value="labels.name"/>
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="name"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" :value="labels.email"/>
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="email"
                />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="profile" :value="labels.profile" />
                <TextInput
                    id="profile"
                    v-model="form.profile"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="profile"
                />
                <InputError :message="form.errors.profile" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="phone" :value="labels.phone" />
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="phone"
                />
                <InputError :message="form.errors.phone" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="city" :value="labels.city" />
                <TextInput
                    id="city"
                    v-model="form.city"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="city"
                />
                <InputError :message="form.errors.city" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="state" :value="labels.state" />
                <TextInput
                    id="state"
                    v-model="form.state"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="state"
                />
                <InputError :message="form.errors.state" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="country" :value="labels.country" />
                <TextInput
                    id="country"
                    v-model="form.country"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="country"
                />
                <InputError :message="form.errors.country" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="linked_in_profile" :value="labels.linked_in_profile" />
                <TextInput
                    id="linked_in_profile"
                    v-model="form.linked_in_profile"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="linked_in_profile"
                />
                <InputError :message="form.errors.linked_in_profile" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="github_profile" :value="labels.github_profile" />
                <TextInput
                    id="github_profile"
                    v-model="form.github_profile"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="github_profile"
                />
                <InputError :message="form.errors.github_profile" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <input class="d-none"
                       aria-describedby="file_input_help"
                       ref="form.pdf_resume"
                       id="pdf_resume"
                       v-on:input="selectedResume($event.target.files[0], 'pdf')"
                       accept="application/pdf"
                       type="file">
                <InputLabel for="pdf_file" value="Pdf Resume" />
                <InputGroupButton
                    element-id="pdf_file"
                    v-model="form.pdf_file"
                    :click-action="chooseResume"
                    click-param="pdf_resume"
                    :action="clearResume"
                    action-param="pdf"
                    action-label="Remove Pdf Resume"
                    :empty-check="! form.has_pdf_resume"
                />
                <InputError :message="form.errors.pdf_file" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <input class="d-none"
                       aria-describedby="file_input_help"
                       ref="form.word_resume"
                       id="word_resume"
                       v-on:input="selectedResume($event.target.files[0], 'word')"
                       accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                       type="file">
                <InputLabel for="word_file" value="Word Resume" />
                <InputGroupButton
                    element-id="word_file"
                    v-model="form.word_file"
                    :click-action="chooseResume"
                    click-param="word_resume"
                    :action="clearResume"
                    action-param="word"
                    action-label="Remove Word Resume"
                    :empty-check="! form.has_word_resume"
                />
                <InputError :message="form.errors.word_file" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.is_hidden" name="is_hidden" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Hide Resume <span class="text-xs text-gray-500 italic">(If this is checked, the resume will be hidden from the public)</span></span>
                </label>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<style scoped>

</style>
