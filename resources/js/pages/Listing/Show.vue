<script setup lang="ts">
import type { Listing } from '@/types';
import ListingAddress from '@/components/ListingAddress.vue';

const props = defineProps<{
    listing: Listing;
}>();
</script>

<template>
    <ListingAddress
        :listing="listing"
        class="mx-auto mt-6 block max-w-2xl rounded-lg border border-neutral-200 px-5 py-4 text-lg"
    />
</template>
