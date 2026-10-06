<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { Listing, ListingFilters, Paginated } from '@/types';
import ConfirmDialog from '@/components/ConfirmDialog.vue';
import ListingAddress from '@/components/ListingAddress.vue';
import { Button } from '@/components/ui/button';
import { show } from '@/routes/listing';
import ListingOffer from '@/components/ListingOffer.vue';
import Pagination from '@/components/Pagination.vue';
import Filters from '@/components/Filters.vue';

const props = defineProps<{
    listings: Paginated<Listing>;
    filters?: Partial<ListingFilters>;
}>();
</script>

<template>
    <Head title="Ogłoszenia" />

    <Filters :filters="filters" />

    <div
        v-for="listing in listings.data"
        :key="listing.id"
        class="border-border hover:border-foreground/40 mx-auto mt-4 flex max-w-2xl flex-wrap items-center gap-3 rounded-lg border px-5 py-4 transition-colors"
    >
        <div class="min-w-0 grow">
            <Link
                :href="show(listing.id)"
                class="text-foreground font-medium underline-offset-4 hover:underline"
            >
                <ListingAddress :listing="listing" />
            </Link>
        </div>
    </div>
    <Pagination :paginator="listings" />
</template>
