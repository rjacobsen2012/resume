<script setup xmlns="http://www.w3.org/1999/html">
import { onMounted, ref } from 'vue';
// import SelectButton from "primevue/selectbutton";

const props = defineProps({
    modelValue: {
        type: String,
        default: null,
    },
    selectText: {
        type: String,
        default: 'Select one',
    },
    textValue: {
        type: String,
        default: 'name',
    },
    rows: {
        type: [Array, Object]
    },
});

const emit = defineEmits([
    'selectedRole',
]);

const select = ref(null);

onMounted(() => {
    console.log(props.rows)
    // if (select.value.hasAttribute('autofocus')) {
    //     select.value.focus();
    // }
});

// defineExpose({ focus: () => select.value.focus() });
</script>

<template>
<!--    <SelectButton></SelectButton>-->
<!--    <select-->
<!--        ref="select"-->
<!--        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"-->
<!--        :value="modelValue"-->
<!--        @input="$emit('update:modelValue', $event.target.value)"-->
<!--        @change="$emit('update:modelValue', $event.target.value)"-->
<!--    >-->
<!--        <option selected>Choose a country</option>-->
<!--        <option v-for="item in rows" :key="item.id" :selected="modelValue && modelValue === item.id ? 'selected' : ''">{{ item[textValue] }}</option>-->
<!--    </select>-->
<!--    <form class="max-w-sm mx-auto">-->
<!--        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>-->
        <select id="countries"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                @change="$emit('selectedRole', $event.target.value)"
        >
            <option selected disabled>{{ selectText }}</option>
            <option v-for="item in rows" :key="item.id" :value="item.id">{{ item[textValue] }}</option>
<!--            <option value="US">United States</option>-->
<!--            <option value="CA">Canada</option>-->
<!--            <option value="FR">France</option>-->
<!--            <option value="DE">Germany</option>-->
        </select>
<!--    </form>-->
</template>
