<script setup lang="ts">
import type { Listing } from '@/types';

const props = defineProps<{
    listing: Listing;
}>();
</script>

<template>
    <span class="text-foreground">
        {{ listing.street }} {{ listing.street_nr }},
        <span class="text-muted-foreground">{{ listing.city }}</span>
        <span class="ml-1 font-semibold tabular-nums">{{ listing.price }} zł</span>
    </span>
</template>
