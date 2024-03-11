<script setup>

import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Select from "@/Components/Select.vue";
import {router, useForm} from "@inertiajs/vue3";
import CustomButton from "@/Components/CustomButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useToast} from "vue-toast-notification";
import {onMounted} from "vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    user: Object,
    status: {
        type: String,
        default: null,
    },
    roles: {
        type: [Array, Object]
    },
});

onMounted(() => {
    props.user.roles.forEach(function (role, index) {
        form.roles.push(role.id)
    })
})

const form = useForm({
    _method: 'PUT',
    first_name: props.user.first_name,
    last_name: props.user.last_name,
    email: props.user.email,
    roles: [],
});

const cancel = () => {
    router.get(route('user.index'))
}

const updateUser = () => {
    form.put(route('user.update', [props.user.id]), {
        errorBag: 'updateUser',
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

const addRole = (role_id) => {
    console.log(role_id)
}

const updateFormRoles = (checked, role_id) => {
    const index = form.roles.indexOf(role_id)

    if (index < 0 && checked) {
        form.roles.push(role_id)
    } else if (index >= 0 && ! checked) {
        form.roles.splice(index, 1)
    }

    axios.put(route('user.update-roles', [props.user.id]), {
        'roles': form.roles
    }).then((response) => {
        success(response.data.status)
    }).catch((response) => {
        error(response.response.data.message)
    })
}

</script>

<template>
    <FormSection @submitted="updateUser">
        <template #title>
            User Roles
        </template>

        <template #description>
            Update the roles assigned to the user.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4 flex flex-row justify-content-start">
                <div class="block mt-4">
                    <label v-for="(role, index) in roles" :key="role.id" :class="['flex', 'items-center', index > 0 ? 'mt-4' : '']">
                        <Checkbox :checked="user.roles.filter(userRole => userRole.id === role.id).length > 0"
                                  name="roles[]"
                                  :value="role.id"
                                  @update:checked="updateFormRoles"
                        />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ role.name }}</span>
                    </label>
                </div>
            </div>
        </template>
    </FormSection>
</template>

<style scoped>

</style>