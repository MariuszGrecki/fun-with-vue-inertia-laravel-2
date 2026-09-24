<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Moon, Plus, Sun } from '@lucide/vue';
import { computed, ref } from 'vue';
import { Toaster } from '@/components/ui/sonner';
import { useAppearance } from '@/composables/useAppearance';
import UserInfo from '@/components/UserInfo.vue';
import { login, logout } from '@/routes/auth';
import { create as register } from '@/routes/user-account';

const { resolvedAppearance, updateAppearance } = useAppearance();
const page = usePage();
const user = computed(() => page.props.auth.user);

const navLink =
    'text-muted-foreground hover:bg-accent hover:text-foreground rounded-md px-2.5 py-1.5 text-sm font-medium whitespace-nowrap transition-colors';

</script>

<template>
    <div class="bg-background text-foreground mx-auto min-h-screen max-w-4xl px-6 py-6">
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
                    :title="resolvedAppearance === 'dark' ? 'Switch to light' : 'Switch to dark'"
                    :aria-label="resolvedAppearance === 'dark' ? 'Switch to light' : 'Switch to dark'"
                    class="border-border text-muted-foreground hover:bg-accent hover:text-accent-foreground focus-visible:ring-ring/50 inline-flex size-8 shrink-0 items-center justify-center rounded-md border transition-colors outline-none focus-visible:ring-[3px]"
                    @click="updateAppearance(resolvedAppearance === 'dark' ? 'light' : 'dark')"
                >
                    <Sun v-if="resolvedAppearance === 'dark'" class="size-4" />
                    <Moon v-else class="size-4" />
                </button>

                <div class="bg-border mx-1 h-6 w-px"></div>

                <div v-if="user" class="flex items-center gap-2">
                    <UserInfo :user="user" />
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

