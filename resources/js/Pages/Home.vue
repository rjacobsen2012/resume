<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {onMounted, reactive, ref} from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import IconField from "primevue/iconfield";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputIcon from "primevue/inputicon";
import { FilterMatchMode, FilterOperator } from "primevue/api";
// import CustomButton from "@/Components/CustomButton.vue";
import {Link, router} from "@inertiajs/vue3";

// const props = defineProps({
//     resumes: [Array, Object]
// });

// const classes = ref([]);
//
// for (let i = 0; i < props.resumes.length; i++) {
//     classes.value.push(getBgColor)
// }

// const randomStyle = (numbers) => {
//     return Object.entries(numbers)[Math.floor(Math.random()*Object.entries(numbers).length)][1]
// }

// function getBgColor() {
//     return randomStyle(styles.value);
// }

// const styles = ref({
//     blue: 'bg-blue-300',
//     amber: 'bg-amber-300',
//     cyan: 'bg-cyan-300',
//     emerald: 'bg-emerald-300',
//     fuchsia: 'bg-fuchsia-300',
//     green: 'bg-green-300',
//     indigo: 'bg-indigo-300',
//     lime: 'bg-lime-300',
//     orange: 'bg-orange-300',
//     pink: 'bg-pink-300',
//     purple: 'bg-purple-300',
// });

const ApiUrl = import.meta.env.VITE_APP_API_URL;
const loading = ref(true);
const total_rows = ref(0);
const filterResumes = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
})
const params = reactive({
    current_page: 1,
    pagesize: 10,
    sort_column: 'name',
    sort_direction: 'asc',
});

const rows = ref(null);

const clearFilter = () => {
    filterResumes.global.value = null;
};

const getResumes = async () => {
    try {
        loading.value = true;

        const response = await fetch(`${ApiUrl}/resume/data?${new URLSearchParams(params)}`);

        const data = await response.json();

        rows.value = data?.data;
        total_rows.value = data?.recordsTotal;
    } catch {
    }

    loading.value = false;
};

const viewResume = (id) => {
    router.get(route('resume.show', [id]))
}

onMounted(() => {
    getResumes();
});

</script>

<template>
    <AppLayout title="Home">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-gray-400 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <span v-if="rows && ! rows.length">No resumes have been added yet.</span>
                <DataTable v-else
                           :value="rows"
                           stripedRows
                           paginator
                           :rows="10"
                           :rows-per-page-options="[10, 20, 50]"
                           v-model:filters="filterResumes"
                           showGridlines
                           dataKey="id"
                           responsive-layout="stack"
                           table-class="text-xs"
                           filterDisplay="menu" :loading="loading" :globalFilterFields="['name', 'title', 'email', 'city', 'state', 'country']">
                    <template #header>
                        <div class="flex justify-content-between">
                            <Button type="button" class="btn-light text-xs" icon="pi pi-filter-slash" label="Clear" outlined @click="clearFilter()" />
                            <IconField iconPosition="left">
                                <InputIcon>
                                    <i class="pi pi-search" />
                                </InputIcon>
                                <InputText class="form-control text-xs" v-model="filterResumes.global.value" placeholder="Keyword Search" />
                            </IconField>
                        </div>
                    </template>
                    <template #empty> No resumes found. </template>
                    <template #loading> Loading resumes data. Please wait. </template>
                    <Column field="name" sortable header="Name">
                        <template #body="{ data }">
                            <div class="flex align-items-center gap-2">
                                <img :alt="data.gravatar" :src="data.gravatar" style="width: 32px" class="rounded-full" />
                                <span>{{ data.name }}</span>
                            </div>
                        </template>
                    </Column>
                    <Column field="email" sortable header="Email"/>
                    <Column field="title" sortable header="Title"/>
                    <Column field="city" sortable header="City"/>
                    <Column field="state" sortable header="State"/>
                    <Column field="country" sortable header="Country"/>
                    <Column>
                        <template #body="{ data }">
                            <div class="flex items-center justify-end gap-2">
                                <Link :href="route('resume.show', [data.id])" as="button" class="btn-light text-nowrap rounded-full">
                                    <i class="fa fa-external-link-alt"/>
                                </Link>
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
