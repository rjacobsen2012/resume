<script setup>
import { useForm } from '@inertiajs/vue3'
import { flashError } from '@/Composables/flash.js'

const emit = defineEmits(['updated'])

const props = defineProps({
    resume: [Array, Object],
    skill: [Array, Object],
})

// A new range. An empty end date means the skill is still in use.
const form = useForm({
    started_on: null,
    ended_on: null,
})

const addPeriod = () => {
    form.post(route('resume.skill.period.store', [props.resume.id, props.skill.id]), {
        errorBag: 'addPeriod',
        preserveScroll: true,
        onSuccess: (response) => {
            form.reset()
            emit('updated', response.props)
        },
        onError: (response) => flashError(response[Object.keys(response)[0]]),
    })
}

const removePeriod = (period) => {
    useForm({}).delete(
        route('resume.skill.period.destroy', [props.resume.id, props.skill.id, period.id]),
        {
            preserveScroll: true,
            onSuccess: (response) => emit('updated', response.props),
            onError: (response) => flashError(response[Object.keys(response)[0]]),
        },
    )
}

// "2000-01-01" reads as "Jan 1, 2000"
const pretty = (value) => {
    if (! value) return 'now'

    return new Date(value + 'T00:00:00').toLocaleDateString(undefined, {
        year: 'numeric', month: 'short', day: 'numeric',
    })
}

const inputClass =
    'bg-gray-50 border-0 border-gray-300 text-gray-900 text-sm rounded-lg px-2 py-1 ' +
    'dark:bg-gray-700 dark:border-gray-600 dark:text-white'
</script>

<template>
    <div class="space-y-1">
        <div
            v-for="period in skill.periods"
            :key="period.id"
            class="flex items-center gap-2 text-xs"
        >
            <span class="whitespace-nowrap">
                {{ pretty(period.started_on) }} &mdash; {{ pretty(period.ended_on) }}
            </span>
            <button
                type="button"
                class="text-red-500 hover:text-red-400"
                :title="'Remove ' + pretty(period.started_on) + ' to ' + pretty(period.ended_on)"
                @click="removePeriod(period)"
            >
                remove
            </button>
        </div>

        <p v-if="! skill.periods || skill.periods.length === 0" class="text-xs italic">
            No dates yet.
        </p>

        <form class="flex items-center gap-2 pt-1" @submit.prevent="addPeriod">
            <input v-model="form.started_on" type="date" :class="inputClass" required>
            <span class="text-xs">to</span>
            <!-- left empty, this means the skill is still in use -->
            <input v-model="form.ended_on" type="date" :class="inputClass" placeholder="still using">
            <button type="submit" class="text-xs text-blue-400 hover:text-blue-300" :disabled="form.processing">
                add dates
            </button>
        </form>
    </div>
</template>
