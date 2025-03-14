<script setup>
import draggable from 'vuedraggable';
import { ref, watch, toRaw, watchEffect } from 'vue';
import {
    Add01Icon,
    Delete02Icon,
    Edit01Icon,
    MoreHorizontalCircle01Icon,
} from '@hugeicons/core-free-icons';
import Dropdown from '@/Components/ui/Dropdown.vue';
import { HugeiconsIcon } from '@hugeicons/vue';
import DropdownLink from '@/Components/ui/DropdownLink.vue';
import { router, usePage } from '@inertiajs/vue3';
import KanbanBoardTask from '@/Components/KanbanBoardTask.vue';
import CreateColumnTask from '@/Components/CreateColumnTask.vue';
import UpdateColumn from '@/Components/UpdateColumn.vue';
import DropdownButton from '@/Components/ui/DropdownButton.vue';
import { cloneDeep } from 'lodash';
import _ from 'lodash';

const page = usePage();
const columns = ref(cloneDeep(page.props.columns));
const initialColumns = ref(cloneDeep(page.props.columns));

watchEffect(() => {
    columns.value = cloneDeep(page.props.columns);
    initialColumns.value = cloneDeep(page.props.columns);
});

function detectMovedColumn(oldColumns, newColumns) {
    if (!oldColumns || !newColumns) return null;
    const oldOrder = _.map(toRaw(oldColumns), 'id');
    const newOrder = _.map(toRaw(newColumns), 'id');
    const movedId = _.find(
        newOrder,
        (id) => _.indexOf(oldOrder, id) !== _.indexOf(newOrder, id),
    );
    if (!movedId) return null;
    const newIndex = _.indexOf(newOrder, movedId);
    const prev = newColumns[newIndex - 1] || null;
    const next = newColumns[newIndex + 1] || null;
    let newPosition;
    if (newIndex === 0 && next) newPosition = next.position / 2;
    else if (prev && next) newPosition = (prev.position + next.position) / 2;
    else if (prev) newPosition = prev.position + 1000;
    else return null;
    return { id: movedId, position: newPosition };
}

function computeTaskNewPosition(tasks, index) {
    const prev = tasks[index - 1]?.position ?? 0;
    const next = tasks[index + 1]?.position ?? prev + 100;
    return (prev + next) / 2;
}

function detectMovedTask(oldColumns, newColumns) {
    const oldPositions = new Map();

    oldColumns.forEach((col) =>
        col.tasks.forEach((task, idx) =>
            oldPositions.set(task.id, {
                columnId: col.id,
                index: idx,
                position: task.position,
            }),
        ),
    );

    for (const col of newColumns) {
        for (let idx = 0; idx < col.tasks.length; idx++) {
            const task = col.tasks[idx];
            const old = oldPositions.get(task.id);

            if (!old || (old.columnId === col.id && old.index === idx))
                continue;

            const newPosition = computeTaskNewPosition(col.tasks, idx);
            return { id: task.id, position: newPosition, columnId: col.id };
        }
    }

    return null;
}

watch(
    columns,
    (newColumns, oldColumns) => {
        const movedColumn = detectMovedColumn(oldColumns, newColumns);
        if (movedColumn) {
            console.log([movedColumn]);
            router.patch(route('columns.reorder', movedColumn['id']), {
                ...movedColumn,
            });
        }

        const movedTask = detectMovedTask(
            toRaw(initialColumns.value),
            newColumns,
        );
        if (movedTask) {
            console.log([movedTask]);
            router.patch(route('tasks.reorder', movedTask['id']), {
                ...movedTask,
            });
        }
    },
    { deep: true },
);

const columnId = ref(0);
const creatingTask = ref(false);

const openCreatingTaskModal = (id) => {
    columnId.value = id;
    creatingTask.value = true;
};

const closeModal = () => {
    creatingTask.value = false;
};

const updatingColumn = ref(false);

const openUpdatingColumnModal = (id) => {
    columnId.value = id;
    updatingColumn.value = true;
};

const closeUpdatingColumnModal = () => {
    updatingColumn.value = false;
};
</script>

<template>
    <div>
        <CreateColumnTask
            :columns
            :columnId
            :show="creatingTask"
            @close="closeModal"
        />

        <UpdateColumn
            :columnId
            :show="updatingColumn"
            @close="closeUpdatingColumnModal"
        />

        <draggable
            v-model="columns"
            group="columns"
            item-key="id"
            class="flex gap-3 overflow-y-auto px-3 py-3"
        >
            <template #item="{ element: column }">
                <div
                    class="h-fit w-64 shrink-0 rounded-lg border border-gray-200 bg-gray-50 p-1"
                >
                    <div class="flex items-center justify-between gap-2 p-2">
                        <div
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700"
                        >
                            {{ column.id }} {{ column.name }}
                            {{ column.position }}
                            <span class="text-gray-500">
                                {{ column.tasks.length }}
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
                                    <DropdownButton
                                        @click="
                                            openUpdatingColumnModal(column.id)
                                        "
                                    >
                                        <HugeiconsIcon
                                            class="size-4 shrink-0"
                                            :icon="Edit01Icon"
                                            :stroke-width="2"
                                        />
                                        Rename Column
                                    </DropdownButton>

                                    <DropdownLink
                                        as="button"
                                        method="DELETE"
                                        :href="
                                            route('columns.delete', column.id)
                                        "
                                        class="text-red-500"
                                    >
                                        <HugeiconsIcon
                                            class="size-4 shrink-0"
                                            :icon="Delete02Icon"
                                            :stroke-width="2"
                                        />
                                        Delete Column
                                    </DropdownLink>
                                </template>
                            </Dropdown>

                            <button
                                @click="openCreatingTaskModal(column.id)"
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
                        v-model="column.tasks"
                        group="tasks"
                        item-key="id"
                        class="grid grid-cols-1 gap-1"
                    >
                        <template #item="{ element: task }">
                            <KanbanBoardTask :task />
                        </template>
                    </draggable>
                </div>
            </template>
        </draggable>
    </div>
</template>
