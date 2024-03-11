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
    getPermissions();
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

const getPermissions = async () => {
    try {
        loading.value = true;

        const response = await fetch(`${ApiUrl}/permissions?${new URLSearchParams(params)}`);

        const data = await response.json();

        rows.value = data?.data;
        total_rows.value = data?.recordsTotal;
    } catch {
    }

    loading.value = false;
};

const newPermission = () => {
    router.get(route('permission.create'))
}

const editPermission = (permission_id) => {
    router.get(route('permission.edit', [permission_id]))
}

const confirm = useConfirm();
const permissionToDelete = ref(null);

const deletePermission = () => {
    axios.delete(route('permission.destroy', [permissionToDelete.value])).then((response) => {
        success(response.data.status)
        router.get(route('permission.index'))
    })
}

const success = (status) => {
    const $toast = useToast();
    $toast.success(status)
}

const confirmDelete = (permission_id) => {
    permissionToDelete.value = permission_id;
    confirm.require({
        message: 'Are you sure you want to delete the permission?',
        header: 'Remove Permission',
        icon: 'icon-delete',
        rejectLabel: 'No',
        rejectClass: 'btn-success',
        acceptLabel: 'Yes',
        acceptClass: 'btn-danger',
        accept: deletePermission,
    });
}

const pageLinks = [
    { name: 'Permissions', active: true },
];
</script>

<template>
    <AppLayout title="Dashboard" :links="pageLinks">
        <template #right-links>
            <CustomButton type="button"
                          class="btn-success"
                          @click="newPermission">
                Add Permission
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
                        <Column field="name" sortable header="Name"/>
                        <Column field="guard_name" sortable header="Guard"/>
                        <Column field="created_at" sortable header="Created"/>
                        <Column field="permission_id">
                            <template #body="{ data }">
                                <div class="flex items-center justify-end gap-2">
                                    <CustomButton type="button" classes="btn-primary" @click="editPermission(data.id)">Edit</CustomButton>
                                    <CustomButton v-if="! data.has_users && ! data.belongs_to_role" type="button" classes="btn-danger" @click="confirmDelete(data.id)">Delete</CustomButton>
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