<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Moon, Plus, Sun } from '@lucide/vue';
import { computed, ref } from 'vue';
import { Toaster } from '@/components/ui/sonner';
import { useAppearance } from '@/composables/useAppearance';
import UserInfo from '@/components/UserInfo.vue';
import { login, logout } from '@/routes/auth';
import { create as register } from '@/routes/user-account';
import { Bell } from '@lucide/vue';
import { useEchoNotification } from '@laravel/echo-vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { DropdownMenuItem, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import ListingPrice from '@/components/ListingPrice.vue';
import { index as offerIndex } from '@/routes/realtor/listing/offer';
import { read } from '@/routes/notifications';
import { watch } from 'vue';

const { resolvedAppearance, updateAppearance } = useAppearance();
const page = usePage();
const user = computed(() => page.props.auth.user);

const navLink ='text-muted-foreground hover:bg-accent hover:text-foreground rounded-md px-2.5 py-1.5 text-sm font-medium whitespace-nowrap transition-colors';

const unreadCount = ref(page.props.unreadNotificationsCount);
if (user.value) {
    useEchoNotification(
        `App.Models.User.${user.value.id}`,
        () => {
            unreadCount.value++;
        },
    );
}

watch(
    () => page.props.unreadNotificationsCount,
    (value) => {
        unreadCount.value = value;
    },
);


</script>

<template>
    <div
        class="bg-background text-foreground mx-auto min-h-screen max-w-4xl px-6 py-6"
    >
        <nav class="border-border flex items-center gap-2 border-b pb-4">
            <div class="flex items-center gap-1">
                <Link href="/" :class="navLink">Home</Link>
                <Link href="/hello" :class="navLink">Hello</Link>
                <Link href="/listing" :class="navLink">Listings</Link>
            </div>

            <div class="ml-auto flex items-center gap-2">
                <Link
                    href="/listing/create"
                    class="bg-primary text-primary-foreground hover:bg-primary/90 focus-visible:ring-ring/50 inline-flex h-8 shrink-0 items-center gap-1.5 rounded-md px-3 text-sm font-medium whitespace-nowrap shadow-xs transition-colors outline-none focus-visible:ring-[3px]"
                >
                    <Plus class="size-4" />
                    Add new
                </Link>

                <button
                    type="button"
                    :title="
                        resolvedAppearance === 'dark'
                            ? 'Switch to light'
                            : 'Switch to dark'
                    "
                    :aria-label="
                        resolvedAppearance === 'dark'
                            ? 'Switch to light'
                            : 'Switch to dark'
                    "
                    class="border-border text-muted-foreground hover:bg-accent hover:text-accent-foreground focus-visible:ring-ring/50 inline-flex size-8 shrink-0 items-center justify-center rounded-md border transition-colors outline-none focus-visible:ring-[3px]"
                    @click="
                        updateAppearance(
                            resolvedAppearance === 'dark' ? 'light' : 'dark',
                        )
                    "
                >
                    <Sun v-if="resolvedAppearance === 'dark'" class="size-4" />
                    <Moon v-else class="size-4" />
                </button>

                <div class="bg-border mx-1 h-6 w-px"></div>

                <div v-if="user" class="flex items-center gap-2">
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <button
                        type="button"
                        class="border-border text-muted-foreground hover:bg-accent hover:text-accent-foreground relative inline-flex size-8 shrink-0 items-center justify-center rounded-md border transition-colors"
                        title="Notifications"
                    >
                <Bell class="size-4" />
                <span
                    v-if="unreadCount > 0"
                    class="bg-primary text-primary-foreground absolute -top-1 -right-1 flex size-4 items-center justify-center rounded-full text-[10px] font-medium"
                >
                    {{ unreadCount }}
                </span>
        </button>
    </DropdownMenuTrigger>

<DropdownMenuContent align="end" class="w-80">
    <p
        v-if="page.props.recentNotifications.length === 0"
        class="text-muted-foreground px-2 py-4 text-center text-sm"
    >
        No notifications yet
    </p>

    <DropdownMenuItem
        v-for="notification in page.props.recentNotifications"
        :key="notification.id"
        as-child
    >
        <Link
            :href="read({ notification: notification.id })"
            class="flex items-center justify-between gap-3"
            :class="{ 'font-medium': !notification.read_at }"
        >
            <span class="text-sm">
                {{ notification.data.bidder_name }} made an offer
            </span>
            <ListingPrice :price="notification.data.amount" class="text-xs" />
        </Link>
    </DropdownMenuItem>

    <DropdownMenuSeparator v-if="page.props.recentNotifications.length > 0" />
    <DropdownMenuItem as-child>
        <Link href="/notifications" class="text-muted-foreground justify-center text-sm">
            View all
        </Link>
    </DropdownMenuItem>
</DropdownMenuContent>

</DropdownMenu>

                    <UserInfo :user="user" />
                    <Link href="/realtor/listing" :class="navLink"
                        >My Listings</Link
                    >
                    <Link
                        :href="logout()"
                        as="button"
                        type="button"
                        class="border-border hover:bg-accent hover:text-accent-foreground focus-visible:ring-ring/50 inline-flex h-8 shrink-0 items-center rounded-md border px-3 text-sm font-medium whitespace-nowrap transition-colors outline-none focus-visible:ring-[3px]"
                    >
                        Wyloguj
                    </Link>
                </div>
                <div v-else class="flex items-center gap-1">
                    <Link :href="login()" :class="navLink">Zaloguj</Link>
                    <Link :href="register()" :class="navLink">Register</Link>
                </div>
            </div>
        </nav>

        <slot>Default</slot>

        <Toaster />
    </div>
</template>
