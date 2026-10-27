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

/**
 * "2000-01-01" reads as "Jan 1, 2000". An empty end date means still in use.
 *
 * ⚠️ Takes the first ten characters rather than trusting the shape. The model
 * serialises these as plain dates now, but a full ISO timestamp used to arrive here
 * and rendered as "Invalid Date" across the whole editor, in production. Being
 * forgiving about the input costs nothing.
 */
const pretty = (value) => {
    if (! value) return 'now'

    const [year, month, day] = String(value).slice(0, 10).split('-').map(Number)

    if (! year || ! month || ! day) return String(value)

    return new Date(year, month - 1, day).toLocaleDateString(undefined, {
        year: 'numeric', month: 'short', day: 'numeric',
    })
}

const inputClass =
    'bg-gray-50 border-0 text-gray-900 text-xs rounded px-1.5 py-0.5 ' +
    'dark:bg-gray-700 dark:text-white'
</script>

<template>
    <div class="space-y-0.5">
        <div
            v-for="period in skill.periods"
            :key="period.id"
            class="flex items-center gap-2 text-xs leading-5"
        >
            <span class="whitespace-nowrap tabular-nums">
                {{ pretty(period.started_on) }} &ndash; {{ pretty(period.ended_on) }}
            </span>
            <button
                type="button"
                class="text-red-400 hover:text-red-300"
                :aria-label="'Remove ' + pretty(period.started_on) + ' to ' + pretty(period.ended_on)"
                @click="removePeriod(period)"
            >
                &times;
            </button>
        </div>

        <p v-if="! skill.periods || skill.periods.length === 0" class="text-xs italic opacity-60">
            No dates yet
        </p>

        <form class="flex items-center gap-1 pt-0.5" @submit.prevent="addPeriod">
            <input v-model="form.started_on" type="date" :class="inputClass" required>
            <span class="text-xs opacity-60">to</span>
            <!-- left empty, this means the skill is still in use -->
            <input v-model="form.ended_on" type="date" :class="inputClass">
            <button
                type="submit"
                class="text-xs text-blue-400 hover:text-blue-300 whitespace-nowrap"
                :disabled="form.processing"
            >
                add
            </button>
        </form>
    </div>
</template>
