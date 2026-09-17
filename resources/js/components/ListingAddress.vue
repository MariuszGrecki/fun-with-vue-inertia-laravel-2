<script setup lang="ts">
    import type { Listing } from '@/types';

    const props = defineProps<{
        listing: Listing;
    }>();
</script>

<template>
    <span>
        {{ listing.street}}
        {{ listing.street_nr}} 
        {{ listing.city }} , for
        {{ listing.price }}
    </span>
</template>