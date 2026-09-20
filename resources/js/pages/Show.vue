<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Show" />

    <main class="mx-auto max-w-xl px-1 py-8">
        <h1 class="text-3xl font-bold tracking-tight text-neutral-900">Show</h1>
        <Link
            href="/"
            class="mt-3 inline-block text-sm text-neutral-500 underline-offset-4 transition-colors hover:text-neutral-900 hover:underline"
        >
            Link to hello
        </Link>
    </main>
</template>
