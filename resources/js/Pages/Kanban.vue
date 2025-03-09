<script setup>
import { Head } from '@inertiajs/vue3';
import grain from '@/Assets/grain.jpg';
import TrelloBoard from '@/Components/TrelloBoard.vue';
</script>

<template>
    <Head title="Kanban" />

    <div
        class="overflow-hidden p-6 after:pointer-events-none after:absolute after:inset-0 after:z-10 after:rounded-3xl after:outline after:outline-2 after:-outline-offset-2 after:outline-white/20 after:content-['']"
    >
        <div
            class="absolute inset-0 -z-10 opacity-5"
            :style="`background-image: url(${grain})`"
        ></div>

        <TrelloBoard />
    </div>
</template>
