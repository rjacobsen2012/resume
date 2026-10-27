<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { flashError } from '@/Composables/flash.js'

const emit = defineEmits(['updated'])

const props = defineProps({
    resume: [Array, Object],
    skill: [Array, Object],
})

/**
 * Rows the user has added but not filled in yet. They live only in the browser:
 * an empty range is not a range, so nothing is written until a start date exists.
 */
const drafts = ref([])

// Saved rows come from the server. Clearing the drafts when they change stops a
// just-saved draft lingering as a duplicate empty row.
watch(() => props.skill.periods, () => { drafts.value = [] })

const addDraft = () => drafts.value.push({ started_on: '', ended_on: '' })

const dropDraft = (index) => drafts.value.splice(index, 1)

const onDraftChanged = (draft, index) => {
    // Nothing to save yet. The row stays on screen until it has a start date.
    if (! draft.started_on) {
        return
    }

    router.post(
        route('resume.skill.period.store', [props.resume.id, props.skill.id]),
        { started_on: draft.started_on, ended_on: draft.ended_on || null },
        {
            preserveScroll: true,
            onSuccess: (response) => {
                dropDraft(index)
                emit('updated', response.props)
            },
            onError: (response) => flashError(response[Object.keys(response)[0]]),
        },
    )
}

const onSavedChanged = (period) => {
    // A saved row always has a start date, so an empty one is the user clearing it
    // rather than an edit to persist.
    if (! period.started_on) {
        return
    }

    router.put(
        route('resume.skill.period.update', [props.resume.id, props.skill.id, period.id]),
        { started_on: period.started_on, ended_on: period.ended_on || null },
        {
            preserveScroll: true,
            onSuccess: (response) => emit('updated', response.props),
            onError: (response) => flashError(response[Object.keys(response)[0]]),
        },
    )
}

const removeSaved = (period) => {
    router.delete(
        route('resume.skill.period.destroy', [props.resume.id, props.skill.id, period.id]),
        {
            preserveScroll: true,
            onSuccess: (response) => emit('updated', response.props),
            onError: (response) => flashError(response[Object.keys(response)[0]]),
        },
    )
}

const inputClass =
    'bg-gray-50 border-0 text-gray-900 text-xs rounded px-1.5 py-0.5 ' +
    'dark:bg-gray-700 dark:text-white'
</script>

<template>
    <div class="space-y-1">
        <!-- saved ranges, editable in place -->
        <div
            v-for="period in skill.periods"
            :key="period.id"
            class="flex items-center gap-1"
        >
            <input
                v-model="period.started_on"
                type="date"
                :class="inputClass"
                @change="onSavedChanged(period)"
            >
            <span class="text-xs opacity-60">to</span>
            <!-- left empty, this means the skill is still in use -->
            <input
                v-model="period.ended_on"
                type="date"
                :class="inputClass"
                @change="onSavedChanged(period)"
            >
            <button
                type="button"
                class="text-xs text-red-400 hover:text-red-300 px-1"
                @click="removeSaved(period)"
            >
                remove
            </button>
        </div>

        <!-- rows added but not yet filled in. Nothing is saved until a start date -->
        <div
            v-for="(draft, index) in drafts"
            :key="'draft-' + index"
            class="flex items-center gap-1"
        >
            <input
                v-model="draft.started_on"
                type="date"
                :class="inputClass"
                @change="onDraftChanged(draft, index)"
            >
            <span class="text-xs opacity-60">to</span>
            <input
                v-model="draft.ended_on"
                type="date"
                :class="inputClass"
                @change="onDraftChanged(draft, index)"
            >
            <button
                type="button"
                class="text-xs text-red-400 hover:text-red-300 px-1"
                @click="dropDraft(index)"
            >
                remove
            </button>
        </div>

        <p
            v-if="(! skill.periods || skill.periods.length === 0) && drafts.length === 0"
            class="text-xs italic opacity-60"
        >
            No dates yet
        </p>

        <button
            type="button"
            class="text-xs text-blue-400 hover:text-blue-300"
            @click="addDraft"
        >
            + add dates
        </button>
    </div>
</template>
