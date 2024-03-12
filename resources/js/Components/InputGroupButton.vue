<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    action: Function,
    actionParam: String,
    clickAction: Function,
    clickParam: String,
    actionLabel: String,
    elementId: String,
    emptyCheck: Boolean,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="flex rounded-lg shadow-sm mt-1">
        <input type="text"
               ref="input"
               :value="modelValue"
               readonly
               @input="$emit('update:modelValue', $event.target.value)"
               :id="elementId"
               @click="clickAction(clickParam)"
               :name="elementId"
               class="block w-full border-gray-200 shadow-sm rounded-s-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
        <button v-if="! emptyCheck" type="button"
                v-on:click="action(actionParam)"
                class="py-3 px-4 inline-flex justify-center text-nowrap items-center gap-x-2 text-xs uppercase font-semibold rounded-e-md border-0 border-transparent bg-red-700 text-white hover:bg-red-800 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-red-900">
            {{ actionLabel }}
        </button>
        <button v-else type="button"
                disabled
                class="py-3 px-4 inline-flex justify-center disabled text-nowrap items-center gap-x-2 text-xs uppercase font-semibold rounded-e-md border-0 border-transparent bg-red-700 text-white hover:bg-red-800 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-red-900">
            {{ actionLabel }}
        </button>
    </div>
</template>
