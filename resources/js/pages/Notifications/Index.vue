<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import type { AppNotification, Paginated } from '@/types';
import ListingPrice from '@/components/ListingPrice.vue';
import Pagination from '@/components/Pagination.vue';
import { index as offerIndex } from '@/routes/realtor/listing/offer';
import { read } from '@/routes/notifications';

defineProps<{
    notifications: Paginated<AppNotification>;
}>();
</script>

<template>
    <Head title="Notifications" />

    <div class="mx-auto mt-6 max-w-2xl">
        <h1
            class="text-foreground border-border border-b pb-3 text-2xl font-semibold tracking-tight"
        >
            Notifications
        </h1>

        <ul
            v-if="notifications.data.length"
            class="border-border divide-border mt-4 divide-y rounded-lg border"
        >
            <li
                v-for="notification in notifications.data"
                :key="notification.id"
                :class="{ 'bg-accent/30': !notification.read_at }"
            >
                <Link
                    :href="read({ notification: notification.id })"
                    class="flex items-center justify-between gap-4 px-5 py-4"
                >
                    <span class="text-foreground text-sm">
                        <span class="font-medium">{{
                            notification.data.bidder_name
                        }}</span>
                        made an offer
                    </span>

                    <span class="flex items-center gap-3">
                        <ListingPrice :price="notification.data.amount" />
                        <span
                            class="text-muted-foreground text-xs tabular-nums"
                        >
                            {{
                                new Date(
                                    notification.created_at,
                                ).toLocaleDateString('pl-PL')
                            }}
                        </span>
                    </span>
                </Link>
            </li>
        </ul>

        <p v-else class="text-muted-foreground mt-6 text-sm">
            No notifications yet.
        </p>

        <Pagination :paginator="notifications" />
    </div>
</template>
