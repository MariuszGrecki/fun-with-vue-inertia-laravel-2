<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { update } from '@/routes/listing';
import type { Listing, ListingForm } from '@/types';
import ListingFormFields from '@/components/ListingFormFields.vue';

const props = defineProps<{ listing: Listing }>();

const form = useForm<ListingForm>({
    street: props.listing.street,
    street_nr: props.listing.street_nr,
    code: props.listing.code,
    city: props.listing.city,
    beds: props.listing.beds,
    baths: props.listing.baths,
    area: props.listing.area,
    price: props.listing.price,
});
</script>

<template>
    <Head title="Edytuj ogłoszenie" />

    <form
        @submit.prevent="form.submit(update(listing.id))"
        class="border-border mx-auto mt-6 grid max-w-2xl gap-4 rounded-lg border p-6 sm:grid-cols-6"
    >
        <h1
            class="border-border text-foreground border-b pb-3 text-2xl font-semibold tracking-tight sm:col-span-6"
        >
            Edytuj ogłoszenie
        </h1>

        <ListingFormFields :form="form" />

        <Button
            type="submit"
            class="sm:col-span-2 sm:col-start-5"
            :disabled="form.processing"
        >
            <Spinner v-if="form.processing" />
            Zapisz zmiany
        </Button>
    </form>
</template>
