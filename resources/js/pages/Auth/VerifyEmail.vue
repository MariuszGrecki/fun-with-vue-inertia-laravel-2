<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { send } from '@/routes/verification';
import { logout } from '@/routes/auth';

const form = useForm({});

function resend() {
    form.submit(send());
}
</script>

<template>
    <Head title="Verify email" />

    <div
        class="border-border mx-auto mt-6 grid max-w-sm gap-4 rounded-lg border p-6"
    >
        <h1 class="text-foreground text-2xl font-semibold tracking-tight">
            Verify your email
        </h1>

        <p class="text-muted-foreground text-sm">
            We sent a verification link to your email address. Click the link to
            continue.
        </p>

        <Button type="button" :disabled="form.processing" @click="resend">
            <Spinner v-if="form.processing" />
            Resend verification email
        </Button>

        <Link
            :href="logout()"
            as="button"
            type="button"
            class="text-muted-foreground text-center text-sm underline underline-offset-4 hover:no-underline"
        >
            Log out
        </Link>
    </div>
</template>
