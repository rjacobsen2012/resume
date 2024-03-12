<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import {onMounted, reactive, ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import CustomButton from "@/Components/CustomButton.vue";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "vue-toast-notification";

import DataTable from "primevue/datatable";
import Column from "primevue/column";

const ApiUrl = import.meta.env.VITE_APP_API_URL

const props = defineProps({
    status: {
        type: String,
        default: null,
    },
});

onMounted(() => {
    getUsers();
});

const loading = ref(true);
const total_rows = ref(0);
const params = reactive({
    current_page: 1,
    pagesize: 10,
    sort_column: 'id',
    sort_direction: 'asc',
});
const rows = ref(null);

const getUsers = async () => {
    try {
        loading.value = true;

        const response = await fetch(`${ApiUrl}/users?${new URLSearchParams(params)}`);

        const data = await response.json();

        rows.value = data?.data;
        total_rows.value = data?.recordsTotal;
    } catch {
    }

    loading.value = false;
};

const newUser = () => {
    router.get(route('user.create'))
}

const editUser = (user_id) => {
    router.get(route('user.edit', [user_id]))
}

const confirm = useConfirm();
const userToDelete = ref(null);

const deleteUser = () => {
    axios.delete(route('user.destroy', [userToDelete.value])).then((response) => {
        success(response.data.status)
        router.get(route('user.index'))
    })
}

const success = (status) => {
    const $toast = useToast();
    $toast.success(status)
}

const confirmDelete = (user_id) => {
    userToDelete.value = user_id;
    confirm.require({
        message: 'Are you sure you want to delete the user?',
        header: 'Remove User',
        icon: 'icon-delete',
        rejectLabel: 'No',
        rejectClass: 'btn-success',
        acceptLabel: 'Yes',
        acceptClass: 'btn-danger',
        accept: deleteUser,
    });
}

const pageLinks = [
    { name: 'Users', active: true },
];
</script>

<template>
    <AppLayout title="Users" :links="pageLinks">
        <template #right-links>
            <CustomButton type="button"
                          class="btn btn-success"
                          @click="newUser">
                Add User
            </CustomButton>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-400 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <DataTable :value="rows"
                               stripedRows
                               paginator
                               :rows="10"
                               :rows-per-page-options="[10, 20, 50]"
                               table-style="min-width: 50rem">
                        <Column field="id" sortable header="Id"/>
                        <Column field="first_name" sortable header="First Name"/>
                        <Column field="last_name" sortable header="Last Name"/>
                        <Column field="email" sortable header="Email"/>
                        <Column field="created_at" sortable header="Created"/>
                        <Column field="user_id">
                            <template #body="{ data }">
                                <div class="flex items-center justify-end gap-2">
                                    <CustomButton type="button" class="btn btn-primary" @click="editUser(data.id)">Edit</CustomButton>
                                    <CustomButton type="button" class="btn btn-danger" @click="confirmDelete(data.id)">Delete</CustomButton>
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>