<script setup>
import { nanoid } from 'nanoid';
import draggable from 'vuedraggable';
import { ref, watch } from 'vue';
import TrelloBoardTask from '@/Components/TrelloBoardTask.vue';
import {
    Add01Icon,
    Delete02Icon,
    Edit01Icon,
    MoreHorizontalCircle01Icon,
} from '@hugeicons/core-free-icons';
import Dropdown from '@/Components/Dropdown.vue';
import { HugeiconsIcon } from '@hugeicons/vue';
import DropdownLink from '@/Components/DropdownLink.vue';
const columns = ref([
    {
        id: nanoid(),
        title: 'Backlog',
        tasks: [
            {
                id: nanoid(),
                title: 'Create marketing landing page',
                created: new Date(),
            },
            {
                id: nanoid(),
                title: 'Develop cool new feature',
                created: new Date(),
            },
            {
                id: nanoid(),
                title: 'Fix page nav bug',
                created: new Date(),
            },
            {
                id: nanoid(),
                title: 'Create marketing landing page',
                created: new Date(),
            },
            {
                id: nanoid(),
                title: 'Develop cool new feature',
                created: new Date(),
            },
            {
                id: nanoid(),
                title: 'Fix page nav bug',
                created: new Date(),
            },
        ],
    },
    {
        id: nanoid(),
        title: 'Work In Progress',
        tasks: [],
    },
    {
        id: nanoid(),
        title: 'Complete',
        tasks: [],
    },
]);

watch(
    columns,
    function (newColumns) {
        console.log(newColumns);
    },
    {
        deep: true,
    },
);
</script>

<template>
    <div>
        <draggable
            v-model="columns"
            group="columns"
            item-key="id"
            class="flex gap-3 overflow-y-auto px-3 py-3"
        >
            <template #item="{ element: board }">
                <div
                    class="h-fit w-64 shrink-0 rounded-lg border border-gray-200 bg-gray-50 p-1"
                >
                    <div class="flex items-center justify-between gap-2 p-2">
                        <div
                            class="inline-flex items-center gap-1.5 text-sm text-gray-700"
                        >
                            {{ board.title }}
                            <span class="text-gray-500">
                                {{ board.tasks.length }}
                            </span>
                        </div>

                        <div
                            class="inline-flex items-center gap-1 text-sm text-gray-700"
                        >
                            <Dropdown align="right">
                                <template #trigger>
                                    <span>
                                        <button
                                            class="rounded-lg p-1 text-gray-500 hover:bg-slate-100"
                                        >
                                            <HugeiconsIcon
                                                class="size-4 shrink-0"
                                                :icon="
                                                    MoreHorizontalCircle01Icon
                                                "
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
                                        Rename List
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
                                        Delete List
                                    </DropdownLink>
                                </template>
                            </Dropdown>

                            <button
                                class="rounded-lg p-1 text-gray-500 hover:bg-slate-100"
                            >
                                <HugeiconsIcon
                                    class="size-4 shrink-0"
                                    :icon="Add01Icon"
                                    :stroke-width="2"
                                />
                            </button>
                        </div>
                    </div>

                    <draggable
                        v-model="board.tasks"
                        group="tasks"
                        item-key="id"
                        class="grid grid-cols-1 gap-1"
                    >
                        <template #item="{ element: task }">
                            <TrelloBoardTask :task />
                        </template>
                    </draggable>
                </div>
            </template>
        </draggable>
    </div>
</template>
