<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Paginated } from '@/types';

defineProps<{
    paginator: Paginated<unknown>;
}>();

</script>

<template>
    <nav
        v-if="paginator.last_page > 1"
        class="mx-auto mt-6 flex max-w-2xl flex-wrap items-center justify-center gap-1"
    >
        <component
            :is="link.url ? Link : 'span'"
            v-for="(link, i) in paginator.links"
            :key="i"
            :href="link.url ?? undefined"
            preserve-scroll
            class="inline-flex h-8 min-w-8 items-center justify-center rounded-md border px-3 text-sm font-medium transition-colors"
            :class="
                link.active
                    ? 'border-foreground bg-foreground text-background'
                    : link.url
                      ? 'border-border text-foreground hover:bg-accent hover:text-accent-foreground'
                      : 'border-transparent text-muted-foreground'
            "
            v-html="link.label"
        />
    </nav>
</template>