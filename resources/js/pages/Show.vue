<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Show" />

    <main class="mx-auto max-w-xl px-1 py-8">
        <h1 class="text-foreground text-3xl font-bold tracking-tight">Show</h1>
        <Link
            href="/"
            class="text-muted-foreground hover:text-foreground mt-3 inline-block text-sm underline-offset-4 transition-colors hover:underline"
        >
            Link to hello
        </Link>
    </main>
</template>
