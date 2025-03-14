<script setup>
import Modal from '@/Components/ui/Modal.vue';
import { nextTick, ref, watchEffect } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/ui/InputError.vue';
import InputLabel from '@/Components/ui/InputLabel.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import { toast } from 'vue-sonner';

const emit = defineEmits(['close']);

const nameInput = ref(null);

const props = defineProps({
    show: Boolean,
    columnId: Number,
    columns: Object,
});

const taskForm = useForm({
    name: '',
    column_id: props.columnId ?? '',
    due_date: '',
});

watchEffect(() => {
    if (props.show) {
        nextTick(() => nameInput.value.focus());
        if (props.columnId) taskForm.column_id = props.columnId;
    }
});

function closeModal() {
    emit('close');
}

const save = () => {
    taskForm.post(route('tasks.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            closeModal();
            taskForm.reset();
            toast.success('Task has been created');
        },
        onError: () => nameInput.value.focus(),
    });
};
</script>

<template>
    <div>
        <teleport to="#modals">
            <Modal maxWidth="xl" :show="show" @close="closeModal">
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
                            for="task_name"
                            value="Name"
                            required
                        />

                        <TextInput
                            id="task_name"
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
    </div>
</template>
