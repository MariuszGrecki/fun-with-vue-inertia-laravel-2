<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { Listing, Paginated } from '@/types';
import ConfirmDialog from '@/components/ConfirmDialog.vue';
import ListingAddress from '@/components/ListingAddress.vue';
import { Button } from '@/components/ui/button';
import { destroy, edit, show } from '@/routes/listing';
import ListingOffer from '@/components/ListingOffer.vue';
import Pagination from '@/components/Pagination.vue';
import Filters from '@/components/Filters.vue';

const props = defineProps<{
    listings: Paginated<Listing>;
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
    <Head title="Ogłoszenia" />

    <Filters/>
    
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
                variant="outline"
                size="sm"
                class="border-border text-foreground hover:bg-primary hover:text-primary-foreground"
                @click="pending = listing"
            >
                Destroy
            </Button>
        </div>
    </div>
    <Pagination :paginator="listings" />
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
