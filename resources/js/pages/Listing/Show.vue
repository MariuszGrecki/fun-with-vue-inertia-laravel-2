<script setup lang="ts">
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import type { Listing, Offer } from '@/types';
import ListingPrice from '@/components/ListingPrice.vue';
import ListingOffer from '@/components/ListingOffer.vue';
import OfferMade from '@/pages/Listing/Offer/OfferMade.vue';

const props = defineProps<{
    listing: Listing;
    offers: Offer[];
    isSold: boolean;
    isOwner: boolean;
}>();

const activeIndex = ref<number>(0);
</script>

<template>
    <Head title="Ogłoszenie" />

    <div class="mt-6 grid gap-4 lg:grid-cols-[2fr_1fr]">
        <div v-if="listing.images?.length" class="space-y-3">
            <div
                class="border-border bg-muted aspect-[4/3] overflow-hidden rounded-lg border"
            >
                <img
                    :src="listing.images[activeIndex].src"
                    alt=""
                    class="size-full object-contain"
                />
            </div>

            <ul
                v-if="listing.images.length > 1"
                class="grid grid-cols-5 gap-2 sm:grid-cols-6"
            >
                <li v-for="(image, index) in listing.images" :key="image.id">
                    <button
                        type="button"
                        class="bg-muted aspect-square w-full overflow-hidden rounded-md border-2 transition"
                        :class="
                            index === activeIndex
                                ? 'border-primary'
                                : 'border-transparent opacity-70 hover:opacity-100'
                        "
                        @click="activeIndex = index"
                    >
                        <img
                            :src="image.src"
                            alt=""
                            class="size-full object-cover"
                        />
                    </button>
                </li>
            </ul>
        </div>

        <div
            v-else
            class="border-border text-muted-foreground flex min-h-64 items-center justify-center rounded-lg border text-sm"
        >
            No images
        </div>

        <div class="grid content-start gap-4">
            <div class="border-border rounded-lg border px-5 py-4">
                <p class="text-muted-foreground text-sm">
                    Basic info
                    <span
                        v-if="isSold"
                        class="bg-destructive/10 text-destructive ml-2 rounded px-1.5 py-0.5 text-xs font-medium"
                    >
                        Sold
                    </span>
                </p>

                <ListingPrice
                    :price="listing.price"
                    class="mt-1 block text-2xl"
                />

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

            <ListingOffer
                v-if="!isSold && !isOwner"
                :price="listing.price"
                :listing-id="listing.id"
            />

            <OfferMade :offers="offers" />
        </div>
    </div>
</template>
