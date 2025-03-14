<script setup>
import {
    MoreHorizontalCircle01Icon,
    Delete02Icon,
    TrelloIcon,
    DashboardSquare01Icon,
    LayoutTable02Icon,
    Edit01Icon,
    FilterHorizontalIcon,
    Add01Icon,
} from '@hugeicons/core-free-icons';
import { HugeiconsIcon } from '@hugeicons/vue';
import DropdownLink from '@/Components/ui/DropdownLink.vue';
import Dropdown from '@/Components/ui/Dropdown.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import KanbanBoard from '@/Components/KanbanBoard.vue';
import CreateColumn from '@/Components/CreateColumn.vue';
import { ref } from 'vue';

defineProps({
    columns: {
        type: Object,
        required: true,
    },
});

const creatingColumn = ref(false);

function openCreatingColumnModal() {
    creatingColumn.value = true;
}

function closeCreatingColumnModal() {
    creatingColumn.value = false;
}
</script>

<template>
    <AppLayout title="Kanban">
        <div
            class="inline-flex w-full items-center justify-between gap-3 border-b border-gray-200 px-5 py-2.5"
        >
            <h1 class="text-sm font-semibold text-gray-800">Design Kanban</h1>

            <Dropdown align="right">
                <template #trigger>
                    <span>
                        <button
                            class="rounded-lg p-1 text-gray-500 hover:bg-slate-50"
                        >
                            <HugeiconsIcon
                                class="size-4 shrink-0"
                                :icon="MoreHorizontalCircle01Icon"
                                :stroke-width="2"
                            />
                        </button>
                    </span>
                </template>

                <template #content>
                    <DropdownLink :href="route('profile.edit')">
                        <HugeiconsIcon
                            class="size-4 shrink-0"
                            :icon="Edit01Icon"
                            :stroke-width="2"
                        />
                        Rename Board
                    </DropdownLink>

                    <DropdownLink
                        :href="route('profile.edit')"
                        class="text-red-500"
                    >
                        <HugeiconsIcon
                            class="size-4 shrink-0"
                            :icon="Delete02Icon"
                            :stroke-width="2"
                        />
                        Delete Board
                    </DropdownLink>
                </template>
            </Dropdown>
        </div>

        <div
            class="flex flex-col justify-between overflow-y-auto border-b border-gray-200 bg-gray-50 px-5 md:flex-row md:gap-8"
        >
            <div class="flex shrink-0 gap-5 *:py-3">
                <div
                    class="inline-flex items-center gap-2 text-sm text-gray-600"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="DashboardSquare01Icon"
                        :stroke-width="2"
                    />
                    Overview
                </div>

                <div
                    class="inline-flex items-center gap-2 border-b-2 border-gray-800 text-sm font-semibold text-gray-800"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="TrelloIcon"
                        :stroke-width="2"
                    />
                    Board
                </div>

                <div
                    class="inline-flex items-center gap-2 text-sm text-gray-600"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="LayoutTable02Icon"
                        :stroke-width="2"
                    />
                    List
                </div>
            </div>

            <div class="inline-flex items-center gap-x-1 py-1">
                <a
                    class="focus:outline-hidden inline-flex items-center justify-center gap-x-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600 hover:bg-white/70 focus:bg-white/70 disabled:pointer-events-none disabled:opacity-50"
                    href="#"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="FilterHorizontalIcon"
                        :stroke-width="2"
                    />
                    Filter
                </a>

                <hr class="w-4 rotate-90" />

                <button
                    @click="openCreatingColumnModal"
                    class="focus:outline-hidden inline-flex items-center justify-center gap-x-2 rounded-lg border-blue-500 bg-gradient-to-l from-blue-500 to-blue-600 px-3 py-2 text-xs font-medium text-white transition-colors hover:bg-blue-700 hover:bg-gradient-to-r focus:bg-blue-700 disabled:pointer-events-none disabled:opacity-50"
                >
                    Add List
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="Add01Icon"
                        :stroke-width="2"
                    />
                </button>

                <CreateColumn
                    :show="creatingColumn"
                    @close="closeCreatingColumnModal"
                />
            </div>
        </div>

        <div class="relative overflow-hidden">
            <KanbanBoard />
        </div>
    </AppLayout>
</template>
