<script setup lang="ts">
</script>
import type { InertiaForm } from '@inertiajs/vue3';
import type { ListingForm } from '@/types';

defineProps<{ form: InertiaForm<ListingForm> }>();
