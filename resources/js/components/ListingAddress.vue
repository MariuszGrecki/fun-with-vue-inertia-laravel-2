<script setup lang="ts">
import type { Listing } from '@/types';
import ListingPrice from './ListingPrice.vue';
import { useMonthlyPayment } from '@/composables/MortgageCalculator.js';

const props = defineProps<{
    listing: Listing;
}>();

const { monthlyPayment, totalPaid } = useMonthlyPayment(
    () => props.listing.price,
    5,
    25,
);

</script>

<template>
    <span class="text-foreground">
        {{ listing.street }} {{ listing.street_nr }},
        <span class="text-muted-foreground">{{ listing.city }}</span>
        <p> Monthly Payment 
            <ListingPrice :price=monthlyPayment />
        </p>
        <p> Total to Paid
            <ListingPrice :price=totalPaid />
        </p>  
    </span>
</template>
