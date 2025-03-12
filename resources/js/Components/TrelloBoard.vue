<script setup>
import draggable from 'vuedraggable';
import { computed, nextTick, ref, watch } from 'vue';
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
import { useForm, usePage } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import { toast } from 'vue-sonner';

const page = usePage();

const columns = computed(() => page.props.columns);

watch(
    columns,
    function (newColumns) {
        console.log(newColumns);
    },
    {
        deep: true,
    },
);

const creatingTask = ref(false);
const nameInput = ref(null);
const taskForm = useForm({
    name: '',
    column_id: '',
    due_date: '',
});

const openCreatingTaskModal = (columnId) => {
    taskForm.column_id = columnId;
    creatingTask.value = true;

    nextTick(() => nameInput.value.focus());
};

const closeModal = () => {
    creatingTask.value = false;
};

const save = () => {
    taskForm.post(route('tasks.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            toast.success('Task has been created');
        },
        onError: () => nameInput.value.focus(),
        onFinish: () => taskForm.reset(),
    });
};
</script>

<template>
    <div>
        <teleport to="#modals">
            <Modal maxWidth="xl" :show="creatingTask" @close="closeModal">
                <div class="border-b border-slate-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-sm font-semibold text-gray-700">
                        New
                        {{
                            columns.find((col) => col.id === taskForm.column_id)
                                ?.name ?? ''
                        }}
                        Task
                    </h2>
                </div>

                <div class="px-6 py-4">
                    <div class="">
                        <InputLabel
                            class="font-normal text-gray-700"
                            for="name"
                            value="Name"
                        />

                        <TextInput
                            id="name"
                            ref="nameInput"
                            type="text"
                            autocomplete="none"
                            class="mt-1 block w-full rounded-lg text-sm text-gray-700 shadow-none"
                            placeholder="To-Do"
                            @keyup.enter="save"
                            v-model="taskForm.name"
                        />

                        <input
                            type="hidden"
                            aria-hidden="true"
                            autocomplete="none"
                            @keyup.enter="save"
                            v-model="taskForm.column_id"
                        />

                        <InputError
                            :message="taskForm.errors.name"
                            class="mt-2"
                        />
                    </div>

                    <div class="mt-3">
                        <InputLabel
                            class="font-normal text-gray-700"
                            for="due_date"
                            value="Due Date"
                        />

                        <TextInput
                            id="due_date"
                            ref="dueDateInput"
                            type="date"
                            autocomplete="none"
                            class="mt-1 block w-full rounded-lg text-sm text-gray-700 shadow-none"
                            placeholder="12 May 2024"
                            @keyup.enter="save"
                            v-model="taskForm.due_date"
                        />

                        <InputError
                            :message="taskForm.errors.due_date"
                            class="mt-2"
                        />

                        <InputError
                            :message="taskForm.errors.column_id"
                            class="mt-2"
                        />
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button
                            @click="closeModal"
                            class="focus:outline-hidden inline-flex items-center justify-center gap-x-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-600 hover:bg-white/70 focus:bg-white/70 disabled:pointer-events-none disabled:opacity-50"
                        >
                            Cancel
                        </button>

                        <button
                            @click="save"
                            class="focus:outline-hidden ms-3 inline-flex items-center justify-center gap-x-2 rounded-lg border-blue-500 bg-gradient-to-l from-blue-500 to-blue-600 px-3 py-2 text-xs font-medium text-white transition-colors hover:bg-blue-700 hover:bg-gradient-to-r focus:bg-blue-700 disabled:pointer-events-none disabled:opacity-50"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </Modal>
        </teleport>

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
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700"
                        >
                            {{ board.name }}
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
                                @click="openCreatingTaskModal(board.id)"
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
