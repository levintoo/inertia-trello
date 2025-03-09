<script setup>
import { nanoid } from 'nanoid';
import draggable from 'vuedraggable';
import { ref, watch } from 'vue';
import TrelloBoardTask from '@/Components/TrelloBoardTask.vue';
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
        title: 'Selected for Dev',
        tasks: [],
    },
    {
        id: nanoid(),
        title: 'In Progress',
        tasks: [],
    },
    {
        id: nanoid(),
        title: 'QA',
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
            class="flex items-start gap-4 overflow-x-auto"
        >
            <template #item="{ element: board }">
                <div class="min-w-[250px] rounded bg-gray-200 p-5">
                    <header class="mb-4 font-medium">
                        {{ board.title }}
                    </header>

                    <draggable
                        v-model="board.tasks"
                        group="tasks"
                        item-key="id"
                    >
                        <template #item="{ element: task }">
                            <TrelloBoardTask :task />
                        </template>
                    </draggable>
                    <footer class="text-gray-500">+ add a card</footer>
                </div>
            </template>
        </draggable>

        <pre>{{ columns }}</pre>
    </div>
</template>
