<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Toaster } from '@/components/ui/sonner';
import { useAppearance } from '@/composables/useAppearance';
import UserInfo from '@/components/UserInfo.vue';
import { login, logout } from '@/routes/auth';
import { create as register } from '@/routes/user-account';

const { resolvedAppearance, updateAppearance } = useAppearance();
const page = usePage();
const user = computed(() => page.props.auth.user);

</script>

<template>
    <div class="bg-background text-foreground mx-auto min-h-screen max-w-4xl px-6 py-6">
        <nav class="border-border flex items-center gap-5 border-b pb-4">
            <Link href="/" class="text-muted-foreground hover:text-foreground text-sm font-medium transition-colors">
                Link to MainPage
            </Link>
            <Link href="/hello" class="text-muted-foreground hover:text-foreground text-sm font-medium transition-colors">
                Link to Show Page
            </Link>
            <Link href="/listing" class="text-muted-foreground hover:text-foreground text-sm font-medium transition-colors">
                Link to Listing Page
            </Link>

            <button
                type="button"
                class="border-border hover:bg-accent hover:text-accent-foreground ml-auto inline-flex h-8 items-center rounded-md border px-3 text-sm font-medium transition-colors"
                @click="updateAppearance(resolvedAppearance === 'dark' ? 'light' : 'dark')"
            >
                {{ resolvedAppearance === 'dark' ? 'Light' : 'Dark' }}
            </button>

            <div v-if="user" class="flex items-center gap-2">
                <UserInfo :user="user" show-email />
                <Link
                    :href="logout()"
                    as="button"
                    type="button"
                    class="border-border hover:bg-accent hover:text-accent-foreground inline-flex h-8 items-center rounded-md border px-3 text-sm font-medium transition-colors"
                >
                    Wyloguj
                </Link>
            </div>
            <div v-else class="flex items-center gap-3">
                <Link :href="login()" class="text-muted-foreground hover:text-foreground text-sm font-medium transition-colors">
                    Zaloguj
                </Link>
                <Link :href="register()" class="text-muted-foreground hover:text-foreground text-sm font-medium transition-colors">
                    Register
                </Link>
            </div>
        </nav>

        <slot>Default</slot>

        <Toaster />
    </div>
</template>

