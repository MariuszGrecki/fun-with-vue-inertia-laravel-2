<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { Listing } from '@/types';
import ConfirmDialog from '@/components/ConfirmDialog.vue';
import ListingAddress from '@/components/ListingAddress.vue';
import { Button } from '@/components/ui/button';
import { destroy, edit, show } from '@/routes/listing';

const props = defineProps<{
    listings: Listing[];
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

    <div
        v-for="listing in listings"
        :key="listing.id"
        class="mx-auto mt-4 flex max-w-2xl flex-wrap items-center gap-3 rounded-lg border border-neutral-200 px-5 py-4 transition-colors hover:border-neutral-400"
    >
        <div class="min-w-0 grow">
            <Link
                :href="show(listing.id)"
                class="font-medium text-neutral-900 underline-offset-4 hover:underline"
            >
                <ListingAddress :listing="listing" />
            </Link>
        </div>
        <div>
            <Link
                :href="edit(listing.id)"
                class="inline-flex h-8 items-center rounded-md border border-neutral-300 px-3 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 hover:text-neutral-900"
            >
                Edit
            </Link>
        </div>
        <div>
            <Button
                variant="outline"
                size="sm"
                class="border-neutral-300 text-neutral-700 hover:bg-neutral-900 hover:text-white"
                @click="pending = listing"
            >
                Destroy
            </Button>
        </div>
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
