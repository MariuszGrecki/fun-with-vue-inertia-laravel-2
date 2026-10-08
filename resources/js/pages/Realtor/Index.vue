<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { Listing, Paginated, RealtorFilters as Filters } from '@/types';
import { show } from '@/routes/listing';
import ListingAddress from '@/components/ListingAddress.vue';
import ListingPrice from '@/components/ListingPrice.vue';
import ConfirmDialog from '@/components/ConfirmDialog.vue';
import { Button } from '@/components/ui/button';
import { destroy, edit, restore } from '@/routes/realtor/listing';
import { create as createImage } from '@/routes/realtor/listing/image';
import { index as offerIndex } from '@/routes/realtor/listing/offer';
import RealtorFilters from './Index/Components/RealtorFilters.vue';
import Pagination from '@/components/Pagination.vue';

defineProps<{
    listings: Paginated<Listing>;
    filters: Partial<Filters>;
}>();

const pending = ref<Listing | null>(null);
const processing = ref(false);

function remove() {
    if (!pending.value) {
        return;
    }

    router.delete(destroy(pending.value.id), {
        onStart: () => (processing.value = true),
        onFinish: () => {
            processing.value = false;
            pending.value = null;
        },
    });
}
</script>

<template>
    <div class="mx-auto max-w-3xl">
        <header
            class="mt-6 flex flex-wrap items-baseline justify-between gap-3"
        >
            <h1 class="text-foreground text-2xl font-semibold tracking-tight">
                Your listings
            </h1>
            <span class="text-muted-foreground text-sm tabular-nums">
                {{ listings.data.length }}
                {{ listings.data.length === 1 ? 'listing' : 'listings' }}
            </span>
        </header>

        <section>
            <RealtorFilters :filters="filters" />
        </section>

        <section
            class="border-border bg-card divide-border mt-4 divide-y rounded-lg border"
        >
            <article
                v-for="listing in listings.data"
                :key="listing.id"
                class="hover:bg-accent/40 flex flex-wrap items-center gap-4 px-5 py-4 transition-colors first:rounded-t-lg last:rounded-b-lg"
                :class="{ 'opacity-50': listing.deleted_at }"
            >
                <div class="min-w-0 grow space-y-1.5">
                    <div class="text-lg leading-none">
                        <ListingPrice :price="listing.price" />
                    </div>

                    <div
                        class="text-muted-foreground flex flex-wrap items-center gap-x-2 text-xs"
                    >
                        <span
                            class="bg-muted rounded px-1.5 py-0.5 tabular-nums"
                        >
                            {{ listing.beds }} beds
                        </span>
                        <span
                            class="bg-muted rounded px-1.5 py-0.5 tabular-nums"
                        >
                            {{ listing.baths }} baths
                        </span>
                        <span
                            class="bg-muted rounded px-1.5 py-0.5 tabular-nums"
                        >
                            {{ listing.area }} m²
                        </span>
                        <Link
                            :href="offerIndex(listing.id)"
                            class="bg-muted rounded px-1.5 py-0.5 tabular-nums"
                        >
                            {{ listing.offers_count }} offers
                        </Link>
                        <span
                            v-if="listing.accepted_offer_exists"
                            class="bg-destructive/10 text-destructive rounded px-1.5 py-0.5 text-xs font-medium"
                        >
                            Sold
                        </span>
                        <span
                            v-if="listing.deleted_at"
                            class="bg-destructive/10 text-destructive rounded px-1.5 py-0.5 text-xs font-medium"
                        >
                            Deleted
                        </span>
                    </div>

                    <div class="text-muted-foreground text-sm">
                        <ListingAddress :listing="listing" />
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <Link
                        :href="show(listing.id)"
                        class="text-muted-foreground hover:bg-accent hover:text-foreground inline-flex h-8 items-center rounded-md px-3 text-sm font-medium transition-colors"
                        v-if="!listing.deleted_at"
                    >
                        Preview
                    </Link>
                    <Link
                        :href="edit(listing.id)"
                        class="text-muted-foreground hover:bg-accent hover:text-foreground inline-flex h-8 items-center rounded-md px-3 text-sm font-medium transition-colors"
                    >
                        Edit
                    </Link>
                    <Link
                        :href="createImage(listing.id)"
                        class="text-muted-foreground hover:bg-accent hover:text-foreground inline-flex h-8 items-center rounded-md px-3 text-sm font-medium transition-colors"
                        v-if="!listing.deleted_at"
                    >
                        Images ({{ listing.images_count }})
                    </Link>
                    <Button
                        variant="ghost"
                        size="sm"
                        class="text-destructive hover:bg-destructive/10 hover:text-destructive"
                        @click="pending = listing"
                        v-if="!listing.deleted_at"
                    >
                        Destroy
                    </Button>
                    <Link
                        :href="restore(listing.id)"
                        class="text-muted-foreground hover:bg-accent hover:text-foreground inline-flex h-8 items-center rounded-md px-3 text-sm font-medium transition-colors"
                        v-else
                    >
                        Restore
                    </Link>
                </div>
            </article>

            <p
                v-if="listings.data.length === 0"
                class="text-muted-foreground px-5 py-10 text-center text-sm"
            >
                Nie masz jeszcze żadnych ogłoszeń.
            </p>
        </section>
        <Pagination :paginator="listings" />
    </div>
    <ConfirmDialog
        :open="pending !== null"
        :processing="processing"
        title="Usunąć ogłoszenie?"
        description="Ogłoszenia nie da się przywrócić po usunięciu."
        confirm-label="Usuń"
        confirm-variant="default"
        @update:open="
            (open) => {
                if (!open) pending = null;
            }
        "
        @confirm="remove"
    />
</template>
