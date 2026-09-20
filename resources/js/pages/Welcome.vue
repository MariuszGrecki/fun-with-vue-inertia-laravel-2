<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    message: string;
}>();
</script>

<template>
    <Head title="Start" />

    <main class="mx-auto max-w-xl px-1 py-8">
        <h1 class="text-3xl font-bold tracking-tight text-neutral-900">Witaj</h1>
        <p class="mt-3 text-neutral-600">To jest strona główna aplikacji.</p>
        <Link
            href="/hello"
            class="mt-3 inline-block text-sm text-neutral-500 underline-offset-4 transition-colors hover:text-neutral-900 hover:underline"
        >
            Linkt to Show
        </Link>
    </main>
    <div class="mx-auto max-w-xl px-1 text-sm text-neutral-500">
        The message is : {{ props.message }}
    </div>
</template>
