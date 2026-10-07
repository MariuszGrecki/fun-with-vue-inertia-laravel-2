<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import ListingPrice from '@/components/ListingPrice.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { store } from '@/routes/listing/offer';

const props = defineProps<{ price: number; listingId: number }>();

function submit() {
    form.submit(store(props.listingId), { preserveScroll: true });
}

const step = computed(() =>
    Math.max(1, 10 ** (Math.floor(Math.log10(Math.max(props.price, 1))) - 2)),
);

const form = useForm({
    amount: props.price,
});

const min = computed(
    () => Math.ceil(props.price / 2 / step.value) * step.value,
);
const max = computed(
    () => Math.floor((props.price * 2) / step.value) * step.value,
);

const difference = computed(() => form.amount - props.price);
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4">
        <p class="text-foreground font-medium">Make an offer</p>

        <div class="space-y-2">
            <label
                for="offer_amount"
                class="text-muted-foreground block text-sm"
            >
                Your offer (zł)
            </label>
            <Input
                id="offer_amount"
                v-model.number="form.amount"
                type="number"
                :min="min"
                :max="max"
                step="1"
            />
        </div>

        <input
            type="range"
            v-model.number="form.amount"
            :min="min"
            :max="max"
            :step="step"
            aria-label="Offer amount"
            class="[&::-moz-range-thumb]:bg-primary [&::-moz-range-track]:bg-secondary [&::-webkit-slider-runnable-track]:bg-secondary [&::-webkit-slider-thumb]:bg-primary focus-visible:[&::-webkit-slider-thumb]:ring-ring/50 h-4 w-full cursor-pointer appearance-none bg-transparent focus-visible:outline-none [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-0 [&::-moz-range-track]:h-1.5 [&::-moz-range-track]:rounded-full [&::-webkit-slider-runnable-track]:h-1.5 [&::-webkit-slider-runnable-track]:rounded-full [&::-webkit-slider-thumb]:-mt-[5px] [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:transition-transform hover:[&::-webkit-slider-thumb]:scale-110 focus-visible:[&::-webkit-slider-thumb]:ring-[3px]"
        />

        <div class="flex justify-between text-xs">
            <ListingPrice :price="min" />
            <ListingPrice :price="max" />
        </div>

        <div
            class="bg-muted flex items-center justify-between rounded-md px-3 py-2 text-sm"
        >
            <span class="text-muted-foreground">
                Difference
                <span
                    v-if="difference > 0"
                    class="text-emerald-600 dark:text-emerald-400"
                >
                    (above asking price)
                </span>
                <span v-else-if="difference < 0" class="text-destructive">
                    (below asking price)
                </span>
            </span>
            <ListingPrice :price="difference" />
        </div>

        <Button type="submit" class="w-full" :disabled="form.processing">
            Make an offer
        </Button>
    </form>
</template>
