<script setup>

import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {isRequired} from "@/Composables/resumeShared.js";

const props = defineProps({
    field: String,
    label: String,
    modelValue: String,
    error: [String, null],
});

defineEmits(['update:modelValue']);
</script>

<template>
    <InputLabel :for="field" :value="label" class="capitalize" :required="isRequired(field)" />
    <TextInput
        v-if="! isRequired(field)"
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
