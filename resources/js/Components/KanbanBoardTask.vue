<script setup>
import {
    Calendar01Icon,
    CheckmarkCircle01Icon,
    Delete02Icon,
    Edit01Icon,
} from '@hugeicons/core-free-icons';
import { HugeiconsIcon } from '@hugeicons/vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    task: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div
        :key="task.name"
        class="group relative space-y-2 rounded-lg border border-slate-200/70 bg-white p-2 text-sm text-gray-700 transition-all"
    >
        <p>
            {{ task.column_id }} {{ task.id }} {{ task.name }}
            {{ task.position }}
        </p>
        <hr class="border-transparent" />
        <div class="flex items-center justify-between transition-all">
            <div class="inline-flex items-center gap-2">
                <Link
                    :href="route('tasks.complete', task.id)"
                    method="PATCH"
                    as="button"
                    v-if="!task.completed_at"
                    class="rounded-lg bg-white p-1 text-gray-500 hover:bg-green-100"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="CheckmarkCircle01Icon"
                        :stroke-width="2"
                    />
                </Link>

                <Link
                    :href="route('tasks.delete', task.id)"
                    method="DELETE"
                    as="button"
                    v-else
                    class="rounded-lg bg-white p-1 text-gray-500 hover:bg-red-100"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="Delete02Icon"
                        :stroke-width="2"
                    />
                </Link>

                <button
                    class="rounded-lg bg-white p-1 text-gray-500 hover:bg-slate-100"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="Edit01Icon"
                        :stroke-width="2"
                    />
                </button>
            </div>

            <div
                v-if="task.due_date"
                class="inline-flex items-center gap-2 text-gray-500"
            >
                <HugeiconsIcon
                    class="size-4 shrink-0"
                    :icon="Calendar01Icon"
                    :stroke-width="2"
                />
                {{ task.short_due_date }}
            </div>
        </div>
    </div>
</template>
