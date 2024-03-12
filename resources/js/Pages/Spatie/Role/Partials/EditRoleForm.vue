<script setup>

import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import {router, useForm} from "@inertiajs/vue3";
import CustomButton from "@/Components/CustomButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {flashSuccess} from "@/Composables/flash.js";
import {flashError} from "@/Composables/flash.js";

const props = defineProps({
    role: Object,
    status: {
        type: String,
        default: null,
    },
});

const form = useForm({
    _method: 'PUT',
    name: props.role.name,
    guard_name: props.role.guard_name,
});

const cancel = () => {
    router.get(route('role.index'))
}

const updateRole = () => {
    form.put(route('role.update', [props.role.id]), {
        errorBag: 'updateRole',
        preserveScroll: true,
        onSuccess: (response) => flashSuccess(response.props.status),
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    })
}

</script>

<template>
    <FormSection @submitted="updateRole">
        <template #title>
            Role Details
        </template>

        <template #description>
            Update the role data.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Name" />
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
                <InputLabel for="guard_name" value="Guard Name" />
                <TextInput
                    id="guard_name"
                    v-model="form.guard_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="guard_name"
                />
                <InputError :message="form.errors.guard_name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <CustomButton type="button"
                          class="btn-danger"
                          @click="cancel"
                          :disabled="form.processing">
                Cancel
            </CustomButton>

            <PrimaryButton :class="[form.processing ? 'opacity-25' : '', 'ms-2']" class="btn-primary" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<style scoped>

</style>
