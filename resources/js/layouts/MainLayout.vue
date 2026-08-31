<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const timer = ref<number>(0);
setInterval(() => timer.value++ , 1000)
</script>

<template>
    <div>
        <Link href="/"> Link to MainPage</Link>
        <Link href="/hello"> Link to Show Page</Link>
        The Page with time {{ timer }};
        <slot>Default</slot>
    </div>
</template>
