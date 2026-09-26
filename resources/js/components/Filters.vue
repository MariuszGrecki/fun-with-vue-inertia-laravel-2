<script setup lang="ts">

import { useForm } from '@inertiajs/vue3';
import type { ListingFilters } from '@/types';
import { index } from '@/routes/listing';

const props = withDefaults(
    defineProps<{ filters?: Partial<ListingFilters> }>(),
    { filters: () => ({}) },
);

const filterForm = useForm<ListingFilters>({
    priceFrom: props.filters.priceFrom ?? null,
    priceTo: props.filters.priceTo ?? null,
    beds: props.filters.beds ?? null,
    baths: props.filters.baths ?? null,
    areaFrom: props.filters.areaFrom ?? null,
    areaTo: props.filters.areaTo ?? null,
});

const visit = () => {
    filterForm
        .transform((data) =>
            Object.fromEntries(
                Object.entries(data).filter(
                    ([, value]) => value !== null && value !== '',
                ),
            ),
        )
        .get(index.url(), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
};

const filter = () => visit();

const clear = () => {
    filterForm.reset();
    visit();
};

</script>

<template>
    <form action="" @submit.prevent="filter">
        <div class="border-border bg-card mt-4 mb-8 flex flex-wrap items-center gap-2 rounded-lg border p-3">
            <div class="flex flex-nowrap items-center">
                <input
                    v-model.number="filterForm.priceFrom"
                    type="text"
                    placeholder="Price from"
                    class="border-input placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 relative h-9 w-28 rounded-md rounded-r-none border bg-transparent px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:z-10 focus-visible:ring-[3px]"
                />
                <input
                    v-model="filterForm.priceTo"
                    type="text"
                    placeholder="Price to"
                    class="border-input placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 relative -ml-px h-9 w-28 rounded-md rounded-l-none border bg-transparent px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:z-10 focus-visible:ring-[3px]"
                />
            </div>
            <div class="flex flex-nowrap items-center">
                <select
                    v-model="filterForm.beds"
                    class="border-input focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 relative h-9 rounded-md rounded-r-none border bg-transparent px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:z-10 focus-visible:ring-[3px]"
                >
                    <option :value="null">Beds</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option :value="6">+6</option>
                </select>
                <select
                    v-model="filterForm.baths"
                    class="border-input focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 relative -ml-px h-9 rounded-md rounded-l-none border bg-transparent px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:z-10 focus-visible:ring-[3px]"
                >
                    <option :value="null">Bath</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option :value="6">+6</option>
                </select>
            </div>
            <div class="flex flex-nowrap items-center">
                <input
                    v-model.number="filterForm.areaFrom"
                    type="text"
                    placeholder="Area from"
                    class="border-input placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 relative h-9 w-28 rounded-md rounded-r-none border bg-transparent px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:z-10 focus-visible:ring-[3px]"
                />
                <input
                    v-model.number="filterForm.areaTo"
                    type="text"
                    placeholder="Area to"
                    class="border-input placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 relative -ml-px h-9 w-28 rounded-md rounded-l-none border bg-transparent px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:z-10 focus-visible:ring-[3px]"
                />
            </div>

            <button
                type="submit"
                class="bg-primary text-primary-foreground hover:bg-primary/90 focus-visible:ring-ring/50 inline-flex h-9 shrink-0 items-center justify-center rounded-md px-4 text-sm font-medium whitespace-nowrap shadow-xs transition-colors outline-none focus-visible:ring-[3px]"
            >
                Filter
            </button>
            <button
                type="reset"
                @click="clear"
                class="border-input hover:bg-accent hover:text-accent-foreground focus-visible:ring-ring/50 dark:bg-input/30 dark:hover:bg-input/50 inline-flex h-9 shrink-0 items-center justify-center rounded-md border bg-transparent px-4 text-sm font-medium whitespace-nowrap shadow-xs transition-colors outline-none focus-visible:ring-[3px]"
            >
                Clear
            </button>
        </div>
    </form>
</template>
