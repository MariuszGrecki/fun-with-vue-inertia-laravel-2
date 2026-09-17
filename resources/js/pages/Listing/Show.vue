<script setup lang="ts">
    import type { Listing } from '@/types';
    import ListingAddress from '@/components/ListingAddress.vue';

    const props = defineProps<{
        listing: Listing;
    }>();
</script>

<template>
    <ListingAddress :listing="listing"/>
</template>