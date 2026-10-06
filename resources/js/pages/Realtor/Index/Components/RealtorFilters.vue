<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { index } from '@/routes/realtor/listing';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { reactive, computed } from 'vue';
import { watchDebounced } from '@vueuse/core';
import type { RealtorFilters, SortBy, SortOption } from '@/types';

const props = defineProps<{
    filters: Partial<RealtorFilters>;
}>();

const filterForm = reactive<RealtorFilters>({
    deleted: false,
    by: 'created_at',
    order: 'desc',
    ...props.filters,
});

const sortLabels: Record<SortBy, SortOption[]> = {
    created_at: [
        { label: 'Latest', value: 'desc' },
        { label: 'Oldest', value: 'asc' },
    ],
    price: [
        { label: 'Pricey', value: 'desc' },
        { label: 'Cheapest', value: 'asc' },
    ],
};

const sortOptions = computed(() => sortLabels[filterForm.by]);

watchDebounced(
    filterForm,
    () =>
        router.get(
            index.url(),
            {
                ...(filterForm.deleted ? { deleted: 1 } : {}),
                by: filterForm.by,
                order: filterForm.order,
            },
            { preserveState: true, preserveScroll: true, replace: true },
        ),
    { debounce: 300 },
);
</script>

<template>
    <form>
        <div
            class="border-border bg-card mt-4 mb-8 flex flex-wrap items-center gap-2 rounded-lg border p-3"
        >
            <div class="flex items-center gap-2">
                <Checkbox id="deleted" v-model="filterForm.deleted" />
                <Label for="deleted" class="font-normal">Deleted</Label>
            </div>
            <div class="flex flex-nowrap items-center">
                <select
                    v-model="filterForm.by"
                    class="border-input focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 relative h-9 rounded-md rounded-r-none border bg-transparent px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:z-10 focus-visible:ring-[3px]"
                >
                    <option value="created_at">Added</option>
                    <option value="price">Price</option>
                </select>
                <select
                    v-model="filterForm.order"
                    class="border-input focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 relative -ml-px h-9 rounded-md rounded-l-none border bg-transparent px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:z-10 focus-visible:ring-[3px]"
                >
                    <option
                        v-for="option in sortOptions"
                        :key="option.value"
                        :value="option.value"
                    >
                        {{ option.label }}
                    </option>
                </select>
            </div>
        </div>
    </form>
</template>
