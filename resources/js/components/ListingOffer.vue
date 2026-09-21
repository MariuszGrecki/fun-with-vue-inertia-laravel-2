<script setup lang="ts">
import { PrinterCheck } from '@lucide/vue';
import ListingPrice from './ListingPrice.vue';
import { ref, computed } from 'vue';
import { useMonthlyPayment } from '@/composables/MortgageCalculator.js';

const props = defineProps<{
    price: number;
}>();

const interestRate = ref< number >(5);
const durationRate = ref< number >(25);

const { monthlyPayment, totalPaid } = useMonthlyPayment(
    () => props.price,
    interestRate,
    durationRate,
)

</script>

<template>
    <div class="border-border rounded-lg border px-5 py-4">
        <p class="text-muted-foreground text-sm">Offer</p>
        <p class="text-foreground mt-1 font-medium">Make an offer</p>
        <label
            for="interest_rate"
            class="text-muted-foreground mt-4 block text-sm"
        >
            Interest rate {{ interestRate }} 
        </label>
        <input
            id="interest_rate"
            type="range"
            v-model.number="interestRate"
            min="0.1"
            max="30"
            step="0.1"
            class="mt-2 h-4 w-full cursor-pointer appearance-none bg-transparent focus-visible:outline-none [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-0 [&::-moz-range-thumb]:bg-primary [&::-moz-range-track]:h-1.5 [&::-moz-range-track]:rounded-full [&::-moz-range-track]:bg-secondary [&::-webkit-slider-runnable-track]:h-1.5 [&::-webkit-slider-runnable-track]:rounded-full [&::-webkit-slider-runnable-track]:bg-secondary [&::-webkit-slider-thumb]:-mt-[5px] [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary [&::-webkit-slider-thumb]:transition-transform hover:[&::-webkit-slider-thumb]:scale-110 focus-visible:[&::-webkit-slider-thumb]:ring-ring/50 focus-visible:[&::-webkit-slider-thumb]:ring-[3px]"
        />
        <label
            for="duration_rate"
            class="text-muted-foreground mt-4 block text-sm"
        >
            Duration {{ durationRate }}
        </label>
        <input
            id="duration_rate"
            type="range"
            v-model.number="durationRate"
            min="3"
            max="35"
            step="0.1"
            class="mt-2 h-4 w-full cursor-pointer appearance-none bg-transparent focus-visible:outline-none [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-0 [&::-moz-range-thumb]:bg-primary [&::-moz-range-track]:h-1.5 [&::-moz-range-track]:rounded-full [&::-moz-range-track]:bg-secondary [&::-webkit-slider-runnable-track]:h-1.5 [&::-webkit-slider-runnable-track]:rounded-full [&::-webkit-slider-runnable-track]:bg-secondary [&::-webkit-slider-thumb]:-mt-[5px] [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary [&::-webkit-slider-thumb]:transition-transform hover:[&::-webkit-slider-thumb]:scale-110 focus-visible:[&::-webkit-slider-thumb]:ring-ring/50 focus-visible:[&::-webkit-slider-thumb]:ring-[3px]"
        />
    
        <p class="text-muted-foreground text-sm"> Yue monthly payment</p>
        <ListingPrice :price=monthlyPayment ></ListingPrice>
        <p class="text-muted-foreground text-sm"> Total to paid</p>
        <ListingPrice :price=totalPaid ></ListingPrice>
    </div>
</template>