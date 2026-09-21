<script lang="ts">
    const formatter = new Intl.NumberFormat('pl-PL', {
        style: 'currency',
        currency: 'PLN',
        maximumFractionDigits: 0
    });
</script>

<script setup lang="ts">
    import { computed } from 'vue';

    const props = defineProps<{ 
        price: number
    }>();

    const formatted = computed(() => formatter.format(props.price));
</script>

<template>
    <span class="text-foreground font-semibold tabular-nums">
        {{ formatted }}
    </span>
</template>