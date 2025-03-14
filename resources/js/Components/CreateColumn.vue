<script setup>
import Modal from '@/Components/ui/Modal.vue';
import { nextTick, ref, watchEffect } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import InputLabel from '@/Components/ui/InputLabel.vue';
import TextInput from '@/Components/ui/TextInput.vue';
import InputError from '@/Components/ui/InputError.vue';

const emit = defineEmits(['close']);
const columnNameInput = ref(null);

const props = defineProps({
    show: Boolean,
});

watchEffect(() => {
    if (props.show) {
        nextTick(() => columnNameInput.value.focus());
    }
});

const closeModal = () => {
    emit('close');
};

const columnForm = useForm({
    name: '',
});

const saveColumn = () => {
    columnForm.post(route('columns.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            closeModal();
            toast.success('Column has been created');
            columnForm.reset();
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
                        New Column
                    </h2>
                </div>

                <div class="px-6 py-4">
                    <div class="">
                        <InputLabel
                            class="font-normal text-gray-700"
                            for="column_name"
                            value="Name"
                        />

                        <TextInput
                            id="column_name"
                            ref="columnNameInput"
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
        </teleport>
    </div>
</template>
