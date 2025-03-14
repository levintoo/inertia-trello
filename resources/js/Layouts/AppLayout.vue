<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import {
    AddTeamIcon,
    ArrowDown01Icon,
    BoardMathIcon,
    ClipboardIcon,
    Clock01Icon,
    GlobalIcon,
    Home01Icon,
    InformationDiamondIcon,
    Note02Icon,
    UserAdd02Icon,
    HelpCircleIcon,
    Logout04Icon,
    UserIcon,
} from '@hugeicons/core-free-icons';
import { HugeiconsIcon } from '@hugeicons/vue';
import DropdownLink from '@/Components/ui/DropdownLink.vue';
import Dropdown from '@/Components/ui/Dropdown.vue';
import { Toaster } from 'vue-sonner';

const page = usePage();

defineProps({
    title: {
        type: String,
        required: false,
    },
});

const navLinks = [
    {
        label: 'Docs',
        icon: Note02Icon,
        href: '/',
    },
    {
        label: 'Dashboard',
        icon: Home01Icon,
        href: '/',
    },
    {
        label: 'Snapshots',
        icon: Clock01Icon,
        href: '/',
    },
    {
        label: 'Clips',
        icon: ClipboardIcon,
        href: '/',
    },
    {
        label: 'More',
        icon: InformationDiamondIcon,
        href: '/',
    },
];

const secondaryNav = [
    {
        label: 'Everything',
        icon: GlobalIcon,
        href: '/',
    },
    {
        label: 'Team Space',
        icon: AddTeamIcon,
        href: '/',
    },
    {
        label: 'Product Requirements',
        icon: BoardMathIcon,
        href: '/',
    },
];
</script>

<template>
    <Head v-if="title" :title="title" />

    <div class="relative">
        <aside
            class="left-0 top-0 hidden h-screen flex-col overflow-y-auto p-3 pr-2 md:fixed md:flex md:w-64"
        >
            <Dropdown align="left">
                <template #trigger>
                    <span>
                        <button
                            class="flex w-full justify-between gap-3 rounded-lg p-2 hover:bg-slate-50"
                        >
                            <span
                                class="inline-flex flex-1 items-center justify-start gap-2"
                            >
                                <span
                                    class="grid size-7 place-content-center rounded-lg bg-blue-100 p-2 font-semibold text-blue-500"
                                >
                                    {{ page.props.auth.user.name[0] }}
                                </span>
                                <span
                                    class="line-clamp-1 text-start text-sm font-medium"
                                >
                                    {{ page.props.auth.user.name }}
                                </span>
                            </span>

                            <span
                                class="grid size-7 place-content-center rounded-lg text-slate-500"
                            >
                                <HugeiconsIcon
                                    class="size-5"
                                    :icon="ArrowDown01Icon"
                                    :stroke-width="2"
                                />
                            </span>
                        </button>
                    </span>
                </template>

                <template #content>
                    <DropdownLink :href="route('profile.edit')">
                        <HugeiconsIcon
                            class="size-4 shrink-0"
                            :icon="UserIcon"
                            :stroke-width="2"
                        />
                        Profile
                    </DropdownLink>
                    <DropdownLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        <HugeiconsIcon
                            class="size-4 shrink-0"
                            :icon="Logout04Icon"
                            :stroke-width="2"
                        />
                        Log Out
                    </DropdownLink>
                </template>
            </Dropdown>

            <div class="mt-3 rounded-lg bg-gray-50 p-1">
                <ul class="flex flex-col gap-1">
                    <li v-for="link in navLinks" :key="link.label">
                        <a
                            class="focus:outline-hidden flex items-center gap-x-3.5 rounded-lg px-2.5 py-2 text-sm text-gray-700 hover:bg-gray-200/60 focus:bg-gray-100"
                            href="#"
                            target="_parent"
                        >
                            <HugeiconsIcon
                                class="size-4 shrink-0"
                                :icon="link.icon"
                                :stroke-width="2"
                            />
                            {{ link.label }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mt-3 flex-1 rounded-lg bg-gray-50 p-1">
                <p class="px-2.5 py-2 text-sm text-gray-500">Your Boards</p>
                <ul class="flex flex-col gap-1">
                    <li v-for="link in secondaryNav" :key="link.label">
                        <a
                            class="focus:outline-hidden flex items-center gap-x-3.5 rounded-lg px-2.5 py-2 text-sm text-gray-700 hover:bg-gray-200/60 focus:bg-gray-100"
                            href="#"
                            target="_parent"
                        >
                            <HugeiconsIcon
                                class="size-4 shrink-0"
                                :icon="link.icon"
                                :stroke-width="2"
                            />
                            {{ link.label }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mt-3 grid grid-cols-2 gap-x-2">
                <a
                    class="focus:outline-hidden inline-flex items-center justify-center gap-x-2 rounded-lg border-blue-500 bg-gradient-to-l from-blue-500 to-blue-600 px-3 py-2 text-xs font-medium text-white transition-colors hover:bg-blue-700 hover:bg-gradient-to-r focus:bg-blue-700 disabled:pointer-events-none disabled:opacity-50"
                    href="#"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="UserAdd02Icon"
                        :stroke-width="2"
                    />
                    Invite
                </a>

                <a
                    class="focus:outline-hidden inline-flex items-center justify-center gap-x-2 rounded-lg border border-slate-200 bg-transparent px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-100 focus:bg-slate-100 disabled:pointer-events-none disabled:opacity-50"
                    href="#"
                >
                    <HugeiconsIcon
                        class="size-4 shrink-0"
                        :icon="HelpCircleIcon"
                        :stroke-width="2"
                    />
                    Help
                </a>
            </div>
        </aside>

        <main class="min-h-screen md:ml-64 md:p-2 md:pl-1">
            <div
                class="min-h-[calc(100vh-1rem)] md:rounded-xl md:border md:shadow-sm"
            >
                <slot />
            </div>
        </main>
    </div>

    <Toaster richColors closeButton />
</template>
