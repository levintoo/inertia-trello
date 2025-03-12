<script setup>
import { useForm } from '@inertiajs/vue3';
import TrelloBoard from '@/Components/TrelloBoard.vue';
import {
    MoreHorizontalCircle01Icon,
    Delete02Icon,
    TrelloIcon,
    DashboardSquare01Icon,
    LayoutTable02Icon,
    Add01Icon,
    Edit01Icon,
    FilterHorizontalIcon,
} from '@hugeicons/core-free-icons';
import { HugeiconsIcon } from '@hugeicons/vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { nextTick, ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import { toast } from 'vue-sonner';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    columns: {
        type: Object,
        required: true,
    },
});

const creatingColumn = ref(false);
const nameInput = ref(null);

const openCreatingColumnModal = () => {
    creatingColumn.value = true;

    nextTick(() => nameInput.value.focus());
};

const closeModal = () => {
    creatingColumn.value = false;
};

const columnForm = useForm({
    name: '',
});

const saveColumn = () => {
    columnForm.post(route('columns.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            toast.success('Column has been created');
        },
        onError: () => nameInput.value.focus(),
        onFinish: () => columnForm.reset(),
    });
};
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

                <Modal maxWidth="xl" :show="creatingColumn" @close="closeModal">
                    <div class="border-b border-slate-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-sm font-semibold text-gray-700">
                            New Column
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
                                @keyup.enter="saveColumn"
                                v-model="columnForm.name"
                            />

                            <InputError
                                :message="columnForm.errors.name"
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
                                @click="saveColumn"
                                class="focus:outline-hidden ms-3 inline-flex items-center justify-center gap-x-2 rounded-lg border-blue-500 bg-gradient-to-l from-blue-500 to-blue-600 px-3 py-2 text-xs font-medium text-white transition-colors hover:bg-blue-700 hover:bg-gradient-to-r focus:bg-blue-700 disabled:pointer-events-none disabled:opacity-50"
                            >
                                Save
                            </button>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>

        <div class="relative overflow-hidden">
            <TrelloBoard />
        </div>
    </AppLayout>
</template>
