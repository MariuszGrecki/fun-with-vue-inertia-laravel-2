<script setup lang="ts">
    import { Head, Link } from '@inertiajs/vue3';
    import type { Listing } from '@/types';
    import ListingAddress from '@/components/ListingAddress.vue';

    const props = defineProps<{
        listings: Listing[];
    }>();
</script>

<template>
    <div v-for="listing in listings" :key="listing.id">
        <Link :href="`/listing/${listing.id}`">
            <ListingAddress :listing="listing"/>
        </Link>
    </div>
</template>