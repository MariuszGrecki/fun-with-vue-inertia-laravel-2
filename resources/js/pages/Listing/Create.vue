<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/listing';
import type { ListingForm } from '@/types';
import ListingFormFields from '@/components/ListingFormFields.vue';

const form = useForm<ListingForm>({
    street: '',
    street_nr: '',
    code: '',
    city: '',
    beds: 0,
    baths: 0,
    area: 0,
    price: 0,
});
</script>

<template>
    <Head title="Nowe ogłoszenie" />

    <form
        @submit.prevent="form.submit(store())"
        class="mx-auto mt-6 grid max-w-2xl gap-4 rounded-lg border border-neutral-200 p-6 sm:grid-cols-6"
    >
        <h1
            class="border-b border-neutral-200 pb-3 text-2xl font-semibold tracking-tight text-neutral-900 sm:col-span-6"
        >
            Nowe ogłoszenie
        </h1>

        <ListingFormFields :form="form" />

        <Button
            type="submit"
            class="sm:col-span-2 sm:col-start-5"
            :disabled="form.processing"
        >
            <Spinner v-if="form.processing" />
            Dodaj ogłoszenie
        </Button>
    </form>
</template>
