<script setup>
defineProps({
    task: {},
});
</script>

<template>
    <div
        :title="task.created.toLocaleDateString"
        class="mb-2 max-w-[250px] rounded bg-white p-2 shadow-sm"
    >
        <span>{{ task.title }}</span>
    </div>
</template>
