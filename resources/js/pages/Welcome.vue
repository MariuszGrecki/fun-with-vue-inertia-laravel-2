<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    message: string;
}>();
</script>

<template>
    <Head title="Start" />

    <main class="mx-auto max-w-xl px-1 py-8">
        <h1 class="text-foreground text-3xl font-bold tracking-tight">Witaj</h1>
        <p class="text-muted-foreground mt-3">
            To jest strona główna aplikacji.
        </p>
        <Link
            href="/hello"
            class="text-muted-foreground hover:text-foreground mt-3 inline-block text-sm underline-offset-4 transition-colors hover:underline"
        >
            Linkt to Show
        </Link>
    </main>
    <div class="text-muted-foreground mx-auto max-w-xl px-1 text-sm">
        The message is : {{ props.message }}
    </div>
</template>
