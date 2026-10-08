<script setup lang="ts">
import type { Offer } from '@/types';
import ListingPrice from '@/components/ListingPrice.vue';

defineProps<{
    offers: Offer[];
}>();
</script>

<template>
    <div
        v-if="offers.length"
        class="border-border rounded-lg border px-5 py-4"
    >
        <p class="text-muted-foreground text-sm">Your offers</p>

        <ul class="mt-2 space-y-1.5 text-sm">
            <li
                v-for="offer in offers"
                :key="offer.id"
                class="flex items-center justify-between"
            >
                <span class="text-muted-foreground tabular-nums">
                    {{ new Date(offer.created_at).toLocaleDateString('pl-PL') }}
                </span>
                <ListingPrice :price="offer.amount" />
            </li>
        </ul>
    </div>
</template>
