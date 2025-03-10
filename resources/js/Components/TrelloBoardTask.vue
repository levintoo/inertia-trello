<script setup>
import {
    Calendar01Icon,
    CheckmarkCircle01Icon,
    Delete02Icon,
    Edit01Icon,
} from '@hugeicons/core-free-icons';
import { HugeiconsIcon } from '@hugeicons/vue';

defineProps({
    task: {},
});
</script>

<template>
    <div
        :key="task.title"
        class="group relative space-y-2 rounded-lg border border-gray-200/70 bg-white p-2 text-sm text-gray-700 transition-all"
    >
        <p>
            {{ task.title }}
        </p>
        <hr class="border-transparent" />
        <div class="flex items-center justify-between transition-all">
            <div class="inline-flex items-center gap-2">
                <button
                    class="rounded-lg bg-white p-1 text-gray-500 hover:bg-slate-100"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="CheckmarkCircle01Icon"
                        :stroke-width="2"
                    />
                </button>

                <button
                    class="hidden rounded-lg bg-white p-1 text-red-500 hover:bg-red-100"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="Delete02Icon"
                        :stroke-width="2"
                    />
                </button>

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

            <div class="inline-flex items-center gap-2 text-gray-500">
                <HugeiconsIcon
                    class="size-4 shrink-0"
                    :icon="Calendar01Icon"
                    :stroke-width="2"
                />
                {{
                    task.created
                        .toLocaleDateString('en-GB', {
                            day: 'numeric',
                            month: 'long',
                        })
                        .replace(/\b(\d{1,2})\b/, (match) => {
                            const suffixes = ['th', 'st', 'nd', 'rd'];
                            const v = match % 100;
                            const suffix =
                                suffixes[(v - 20) % 10] ||
                                suffixes[v] ||
                                suffixes[0];
                            return match + suffix;
                        })
                }}
            </div>
        </div>
    </div>
</template>
