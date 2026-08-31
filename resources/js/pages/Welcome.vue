<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    message: string;
}>();
</script>

<template>
        <Head title="Start" />

        <main class="mx-auto max-w-xl p-8">
            <h1 class="text-3xl font-bold">Witaj</h1>
            <p class="mt-3">To jest strona główna aplikacji.</p>
            <Link href="/hello"> Linkt to Show</Link>
        </main>
        <div>The message is : {{ props.message }}</div>
</template>
