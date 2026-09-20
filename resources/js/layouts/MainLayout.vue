<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Toaster } from '@/components/ui/sonner';
import { useAppearance } from '@/composables/useAppearance';

const { resolvedAppearance, updateAppearance } = useAppearance();


</script>

<template>
    <div
        class="bg-background text-foreground mx-auto min-h-screen max-w-4xl px-6 py-6"
    >
        <button
            type="button"
            class="border-border hover:bg-accent hover:text-accent-foreground ml-6 inline-flex h-8 items-center rounded-md border px-3 text-sm font-medium transition-colors"
            @click="updateAppearance(resolvedAppearance === 'dark' ? 'light' : 'dark')"
        >
            {{ resolvedAppearance === 'dark' ? 'Light' : 'Dark' }}
        </button>

        <Link
            href="/"
            class="text-muted-foreground hover:text-foreground mr-5 text-sm font-medium transition-colors"
        >
            Link to MainPage
        </Link>
        <Link
            href="/hello"
            class="text-muted-foreground hover:text-foreground mr-5 text-sm font-medium transition-colors"
        >
            Link to Show Page
        </Link>
        <Link
            href="/listing"
            class="text-muted-foreground hover:text-foreground text-sm font-medium transition-colors"
        >
            Link to Listing Page
        </Link>

        <slot>Default</slot>

        <Toaster />
    </div>
</template>
