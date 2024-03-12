<script setup>

import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import {router, useForm} from "@inertiajs/vue3";
import CustomButton from "@/Components/CustomButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import {useToast} from "vue-toast-notification";

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