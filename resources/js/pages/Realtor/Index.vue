<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Listing } from '@/types';
import { destroy, edit, show } from '@/routes/listing';
import ListingAddress from '@/components/ListingAddress.vue';
import ListingPrice from '@/components/ListingPrice.vue';
import { Button } from '@/components/ui/button';

defineProps<{
    listings: Listing[];
}>();

</script>

<template>
    <div class="mx-auto max-w-2xl">
        <h1 class="text-foreground mt-6 text-2xl font-semibold tracking-tight">Your listings</h1>

        <section
            class="border-border bg-card text-muted-foreground mt-4 rounded-lg border p-3 text-sm"
        >
            Filters
        </section>

        <section class="text-muted-foreground mt-4 space-y-3 text-sm">
            <div
                v-for="listing in listings"
                :key="listing.id"
                class="border-border hover:border-foreground/40 flex flex-wrap items-center gap-3 rounded-lg border px-5 py-4 transition-colors"
            >
                <div class="min-w-0 grow space-y-1">
                    <div class="text-lg leading-none">
                        <ListingPrice :price="listing.price" />
                    </div>
                    <div class="text-sm">
                        <ListingAddress :listing="listing" />
                    </div>
                </div>
                <div>
                    <Link
                        :href="edit(listing.id)"
                        class="border-border text-foreground hover:bg-accent hover:text-accent-foreground inline-flex h-8 items-center rounded-md border px-3 text-sm font-medium transition-colors"
                    >
                        Edit
                    </Link>
                </div>
                <div>
                    <Button
                        :href="destroy(listing.id)"
                        variant="outline"
                        size="sm"
                        class="border-border text-foreground hover:bg-primary hover:text-primary-foreground"
                    >
                        Destroy
                    </Button>
                </div>
            </div>
        </section>
    </div>
</template>
