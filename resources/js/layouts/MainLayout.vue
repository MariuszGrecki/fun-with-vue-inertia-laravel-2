<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Toaster } from '@/components/ui/sonner';

</script>

<template>
    <div
        class="mx-auto min-h-screen max-w-4xl bg-white px-6 py-6 text-neutral-900"
    >
        <Link
            href="/"
            class="mr-5 text-sm font-medium text-neutral-500 transition-colors hover:text-neutral-900"
        >
            Link to MainPage
        </Link>
        <Link
            href="/hello"
            class="mr-5 text-sm font-medium text-neutral-500 transition-colors hover:text-neutral-900"
        >
            Link to Show Page
        </Link>
        <Link
            href="/listing"
            class="text-sm font-medium text-neutral-500 transition-colors hover:text-neutral-900"
        >
            Link to Listing Page
        </Link>

        <slot>Default</slot>

        <Toaster />
    </div>
</template>
