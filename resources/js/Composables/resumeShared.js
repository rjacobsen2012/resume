import {ref} from "vue";

export const labels = ref({
    name: 'Full Name',
    email: 'Contact Email',
    profile: 'Profile Url',
    title: 'Job Title',
    city: 'City',
    state: 'State',
    country: 'Country',
    linked_in_profile: 'LinkedIn Profile Url',
    github_profile: 'Github Profile Url',
    phone: 'Contact Number',
});

export const notRequiredFields = ref([
    'profile',
    'title',
    'city',
    'state',
    'country',
    'linked_in_profile',
    'github_profile',
    'phone',
]);

export function isRequired(field) {
    return ! notRequiredFields.value.includes(field);
}
