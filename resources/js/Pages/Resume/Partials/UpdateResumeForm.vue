<script setup>
import {useToast} from "vue-toast-notification";
import {useForm} from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: usePage().props.user.resume.name,
    email: usePage().props.user.resume.email,
    profile: usePage().props.user.resume.profile,
    linked_in_profile: usePage().props.user.resume.linked_in_profile,
    github_profile: usePage().props.user.resume.github_profile,
    phone: usePage().props.user.resume.phone,
    pdf_resume: null,
    word_resume: null,
    is_hidden: usePage().props.user.resume.is_hidden,
});

const submit = () => {
    form.post(route('resume.update', [usePage().props.user.resume.id]), {
        errorBag: 'updateResume',
        preserveScroll: true,
        onSuccess: (response) => updated(response.props),
        onError: (response) => errors(response[Object.keys(response)[0]]),
    });
};

function updated(data) {
    const $toast = useToast();

    if (data.error) {
        $toast.error(data.error);
    } else {
        $toast.success(data.status);
    }
}

function errors(data) {
    const $toast = useToast();
    $toast.error(data.message);
}

</script>

<template>
    <FormSection @submitted="submit">
        <template #title>
            Resume Information
        </template>

        <template #description>
            Update and build your resume.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Full Name" />
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
                <InputLabel for="email" value="Email" />
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
                <InputLabel for="profile" value="Profile Url" />
                <TextInput
                    id="profile"
                    v-model="form.profile"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="profile"
                />
                <InputError :message="form.errors.profile" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="phone" value="Phone Number" />
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="phone"
                />
                <InputError :message="form.errors.phone" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="linked_in_profile" value="LinkedIn Profile" />
                <TextInput
                    id="linked_in_profile"
                    v-model="form.linked_in_profile"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="linked_in_profile"
                />
                <InputError :message="form.errors.linked_in_profile" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="github_profile" value="Github Profile" />
                <TextInput
                    id="github_profile"
                    v-model="form.github_profile"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="github_profile"
                />
                <InputError :message="form.errors.github_profile" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="pdf_resume" value="Pdf Resume" />
                <input
                    id="pdf"
                    ref="form.pdf_resume"
                    type="file"
                    v-on:input="form.pdf_resume = $event.target.files[0]"
                    class="mt-1 block w-full font-medium text-sm text-gray-700 dark:text-gray-300"
                    accept="application/pdf"
                />
                <InputError :message="form.errors.pdf_resume" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="word_resume" value="Word Resume" />
                <input
                    id="pdf"
                    ref="form.word_resume"
                    type="file"
                    v-on:input="form.word_resume = $event.target.files[0]"
                    class="mt-1 block w-full font-medium text-sm text-gray-700 dark:text-gray-300"
                    accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                />
                <InputError :message="form.errors.word_resume" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.is_hidden" name="is_hidden" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Resume Hidden</span>
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
        </template>
    </FormSection>
</template>

<style scoped>

</style>