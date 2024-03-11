<script setup>

import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import {router, useForm} from "@inertiajs/vue3";
import CustomButton from "@/Components/CustomButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useToast} from "vue-toast-notification";

const props = defineProps({
    user: Object,
    status: {
        type: String,
        default: null,
    },
});

const form = useForm({
    first_name: null,
    last_name: null,
    email: null,
});

const cancel = () => {
    router.get(route('user.index'))
}

const createUser = () => {
    form.post(route('user.store'), {
        errorBag: 'createUser',
        preserveScroll: true,
        onSuccess: (response) => {
            success(response.props.status)
        },
        onError: (response) => {
            error(response[Object.keys(response)[0]])
        },
    })
}

const success = (status) => {
    const $toast = useToast();
    $toast.success(status)
}

const error = (status) => {
    const $toast = useToast();
    $toast.error(status);
}

</script>

<template>
    <FormSection @submitted="createUser">
        <template #title>
            New User Details
        </template>

        <template #description>
            Add the user data.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="first_name" value="First Name" />
                <TextInput
                    id="first_name"
                    v-model="form.first_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="first_name"
                />
                <InputError :message="form.errors.first_name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="last_name" value="Last Name" />
                <TextInput
                    id="last_name"
                    v-model="form.last_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="last_name"
                />
                <InputError :message="form.errors.last_name" class="mt-2" />
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
        </template>

        <template #actions>
            <CustomButton type="button"
                          class="btn-danger"
                          @click="cancel"
                          :disabled="form.processing">
                Cancel
            </CustomButton>

            <PrimaryButton :class="[form.processing ? 'opacity-25' : '', 'ms-2']" classes="btn-primary" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<style scoped>

</style>