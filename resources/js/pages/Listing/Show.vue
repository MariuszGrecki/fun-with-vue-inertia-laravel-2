<script setup lang="ts">

import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import type { Listing } from '@/types';
import ListingPrice from '@/components/ListingPrice.vue';
import ListingOffer from '@/components/ListingOffer.vue';

const props = defineProps<{
    listing: Listing;
}>();

</script>

<template>
    <Head title="Ogłoszenie" />

    <div class="mt-6 grid gap-4 lg:grid-cols-[2fr_1fr]">
        <div
            class="border-border text-muted-foreground flex min-h-64 items-center justify-center rounded-lg border text-sm"
        >
            No images
        </div>

        <div class="grid content-start gap-4">
            <div class="border-border rounded-lg border px-5 py-4">
                <p class="text-muted-foreground text-sm">Basic info</p>

                <ListingPrice :price="listing.price" class="mt-1 block text-2xl" />

                <p class="text-foreground mt-1 text-sm">
                    <span class="font-semibold">{{ listing.beds }}</span> bds
                    <span class="text-muted-foreground mx-1">|</span>
                    <span class="font-semibold">{{ listing.baths }}</span> ba
                    <span class="text-muted-foreground mx-1">|</span>
                    <span class="font-semibold">{{ listing.area }}</span> m²
                </p>

                <p class="text-muted-foreground mt-2 text-sm">
                    {{ listing.street }} {{ listing.street_nr }},
                    {{ listing.code }} {{ listing.city }}
                </p>
            </div>

            <ListingOffer :price="listing.price"/>
        </div>
    </div>
</template>
