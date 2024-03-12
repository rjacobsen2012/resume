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

const props = defineProps({
    user: Object,
});

const form = useForm({
    id: null,
    name: props.user.name,
    email: props.user.email,
    profile: null,
    linked_in_profile: null,
    github_profile: null,
    phone: null,
    pdf_resume: null,
    word_resume: null,
    is_hidden: null,
});

const submit = () => {
    form.post(route('resume.store'));
};

function store() {
    // let formData = new FormData();
    // formData.append('name', form.name);
    // formData.append('email', form.email);
    // formData.append('profile', form.profile);
    // formData.append('linked_in_profile', form.linked_in_profile);
    // formData.append('github_profile', form.github_profile);
    // formData.append('phone', form.phone);
    // formData.append('pdf', form.pdf_resume);
    // formData.append('word', form.word_resume);
    // formData.append('is_hidden', form.is_hidden);

    form.post(route('resume.store'), {
        errorBag: 'createResume',
        preserveScroll: true,
        onSuccess: (response) => created(response.props.status),
        onError: (response) => errors(response[Object.keys(response)[0]]),
    });

    // axios.post(
    //     route('resume.store'),
    //     formData,
    //     {
    //         headers: {
    //             'Content-Type': 'multipart/form-data'
    //         }
    //     },
    // )
    //     .then(response => created(response.data))
    //     .catch(error => errors(error.response.data));
}

function created(data) {
    const $toast = useToast();

    if (data.error) {
        $toast.error(data.error);
    } else {
        $toast.success(data.message);
    }
}

function errors(data) {
    const $toast = useToast();
    $toast.error(data.message);
}

</script>

<template>
    <FormSection @submitted="store">
        <template #title>
            Resume Information
        </template>

        <template #description>
            Create the initial profile for your resume.
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
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<style scoped>

</style>