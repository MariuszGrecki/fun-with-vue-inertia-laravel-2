<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import type { Listing, Offer } from '@/types';
import ListingPrice from '@/components/ListingPrice.vue';
import { Button } from '@/components/ui/button';
import { accept } from '@/routes/realtor/listing/offer';

const props = defineProps<{
    listing: Listing;
    offers: Offer[];
}>();

const isSold = computed(() => props.offers.some((offer) => offer.accepted_at));
const processing = ref(false);

function acceptOffer(offer: Offer) {
    router.post(accept({ listing: props.listing.id, offer: offer.id }), {}, {
        preserveScroll: true,
        onStart: () => (processing.value = true),
        onFinish: () => (processing.value = false),
    });
}
</script>

<template>
    <Head title="Offers" />

    <div class="mx-auto mt-6 max-w-2xl">
        <header class="border-border border-b pb-3">
            <h1 class="text-foreground text-2xl font-semibold tracking-tight">
                Offers
            </h1>
            <p class="text-muted-foreground text-sm">
                {{ listing.street }} {{ listing.street_nr }}, {{ listing.city }}
            </p>
        </header>

        <ul
            v-if="offers.length"
            class="border-border divide-border mt-4 divide-y rounded-lg border"
        >
            <li
                v-for="offer in offers"
                :key="offer.id"
                class="flex items-center justify-between gap-4 px-5 py-4"
            >
                <div>
                    <p class="text-foreground text-sm font-medium">
                        {{ offer.bidder?.name }}
                    </p>
                    <p class="text-muted-foreground text-xs">
                        {{ offer.bidder?.email }}
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <ListingPrice :price="offer.amount" />
                        <p class="text-muted-foreground text-xs tabular-nums">
                            {{ new Date(offer.created_at).toLocaleDateString('pl-PL') }}
                        </p>
                    </div>

                    <span
                        v-if="offer.accepted_at"
                        class="bg-primary/10 text-primary rounded px-2 py-1 text-xs font-medium"
                    >
                        Accepted
                    </span>
                    <Button
                        v-else-if="!isSold"
                        size="sm"
                        variant="outline"
                        :disabled="processing"
                        @click="acceptOffer(offer)"
                    >
                        Accept
                    </Button>
                </div>
            </li>
        </ul>

        <p v-else class="text-muted-foreground mt-6 text-sm">
            No offers yet.
        </p>
    </div>
</template>
