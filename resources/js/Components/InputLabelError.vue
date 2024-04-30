<script setup>

import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    field: String,
    modelValue: String,
    error: [String, null],
    notRequired: {
        type: Array,
        default: [],
    },
});

defineEmits(['update:modelValue']);
</script>

<template>
    <InputLabel :for="field" :value="field" class="capitalize" />
    <TextInput
        v-if="notRequired.includes(field)"
        :id="field"
        :value="modelValue"
        type="text"
        class="mt-1 block w-full"
        :autocomplete="field"
        @input="$emit('update:modelValue', $event.target.value)"
    />
    <TextInput
        v-else
        :id="field"
        :value="modelValue"
        type="text"
        class="mt-1 block w-full"
        required
        :autocomplete="field"
        @input="$emit('update:modelValue', $event.target.value)"
    />
    <InputError :message="error" class="mt-2" />
</template>

<style scoped>

</style>
