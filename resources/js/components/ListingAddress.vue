<script setup lang="ts">
import type { Listing } from '@/types';

const props = defineProps<{
    listing: Listing;
}>();
</script>

<template>
    <span class="text-neutral-900">
        {{ listing.street }} {{ listing.street_nr }},
        <span class="text-neutral-500">{{ listing.city }}</span>
        <span class="ml-1 font-semibold tabular-nums">{{ listing.price }} zł</span>
    </span>
</template>
