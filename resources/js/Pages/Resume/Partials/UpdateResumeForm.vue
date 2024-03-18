<script setup>
import {useForm} from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputGroupButton from "@/Components/InputGroupButton.vue";
import {usePage} from "@inertiajs/vue3";
import {flashSuccess} from "@/Composables/flash.js";
import {flashError} from "@/Composables/flash.js";
import CustomButton from "@/Components/CustomButton.vue";
import {useConfirm} from "primevue/useconfirm";
import {ref} from "vue";
import InputLabelError from "@/Components/InputLabelError.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: usePage().props.user.resume.name,
    email: usePage().props.user.resume.email,
    profile: usePage().props.user.resume.profile,
    title: usePage().props.user.resume.title,
    city: usePage().props.user.resume.city,
    state: usePage().props.user.resume.state,
    country: usePage().props.user.resume.country,
    linked_in_profile: usePage().props.user.resume.linked_in_profile,
    github_profile: usePage().props.user.resume.github_profile,
    phone: usePage().props.user.resume.phone,
    pdf_file: usePage().props.user.resume.pdf_resume ?? 'Click to add pdf resume',
    word_file: usePage().props.user.resume.word_resume ?? 'Click to add word resume',
    pdf_resume: null,
    word_resume: null,
    is_hidden: usePage().props.user.resume.is_hidden,
    has_word_resume: usePage().props.user.resume.pdf_resume !== null,
    has_pdf_resume: usePage().props.user.resume.word_resume !== null,
});

const fields = ref({
    text: [
        'name',
        'email',
        'profile',
        'title',
        'city',
        'state',
        'country',
        'linked_in_profile',
        'github_profile',
        'phone',
    ],
});

const update = () => {
    form.post(route('resume.update', [usePage().props.user.resume.id]), {
        errorBag: 'updateResume',
        preserveScroll: true,
        onSuccess: (response) => flashSuccess(response.props.status),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    });
};

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

const confirm = useConfirm();

const confirmDelete = () => {
    confirm.require({
        message: 'Are you sure you want to delete the resume? This cannot be undone.',
        header: 'Remove Resume',
        icon: 'icon-delete',
        rejectLabel: 'No',
        rejectClass: 'btn-success',
        acceptLabel: 'Yes',
        acceptClass: 'btn-danger',
        accept: deleteResume,
    });
}

const deleteResume = () => {
    form.delete(route('resume.destroy', [usePage().props.user.resume.id]), {
        onSuccess: (response) => flashSuccess(response.props.status),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    })
}

</script>

<template>
    <FormSection @submitted="update">
        <template #title>
            Profile
        </template>

        <template #description>
            Add contact details.
        </template>

        <template #form>
            <div v-for="(field, index) in fields.text" :key="index" class="col-span-6 sm:col-span-4">
                <InputLabelError :field="field" v-model="form[field]" :error="form.errors[field]"/>
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

            <div v-if="! $page.props.auth?.user?.is_subscribed" class="col-span-6 sm:col-span-4">
                <label class="flex items-center">
                    <span class="ms-2 text-sm text-indigo-700 dark:text-indigo-400">*NOTE: In order for your resume to become public for employers to view, you must <a href="/billing" class="font-semibold underline">subscribe</a>.</span>
                </label>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </PrimaryButton>

            <CustomButton @click="confirmDelete" type="button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ms-2 btn-danger">
                Delete Resume
            </CustomButton>
        </template>
    </FormSection>
</template>

<style scoped>

</style>
