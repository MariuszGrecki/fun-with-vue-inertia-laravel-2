<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import { Toaster } from '@/components/ui/sonner';

    const timer = ref<number>(0);
    setInterval(() => timer.value++ , 1000)
</script>

<template>
    <div>
        <Link href="/"> Link to MainPage</Link>
        <Link href="/hello"> Link to Show Page</Link>
        The Page with time {{ timer }};
        <slot>Default</slot>
        <Toaster />
    </div>
</template>
