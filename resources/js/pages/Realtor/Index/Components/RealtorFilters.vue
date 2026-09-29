<script setup lang="ts">

import { router } from '@inertiajs/vue3';
import { index } from '@/routes/realtor/listing';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { reactive, watch } from 'vue';
import { RealtorFilters } from '@/types';
import { watchDebounced } from '@vueuse/core';

const filterForm = reactive<RealtorFilters>({
    deleted: false,
})

watchDebounced(
    filterForm,
    () =>
        router.get(
            index.url(),
            filterForm.deleted ? { deleted: 1 } : {},
            { preserveState: true, preserveScroll: true, replace: true },
        ),
    { debounce: 300 },
);

</script>

<template>
    <form>
        <div class="border-border bg-card mt-4 mb-8 flex flex-wrap items-center gap-2 rounded-lg border p-3">
            <div class="flex items-center gap-2">
                <Checkbox id="deleted" v-model="filterForm.deleted"/>
                <Label for="deleted" class="font-normal">Deleted</Label>
            </div>
        </div>
    </form>
</template>
