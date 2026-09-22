<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes/auth';
import { store } from '@/routes/user-account';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.submit(store(), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <Head title="Register" />

    <form
        @submit.prevent="submit"
        class="border-border mx-auto mt-6 grid max-w-sm gap-4 rounded-lg border p-6"
    >
        <h1 class="text-foreground text-2xl font-semibold tracking-tight">
            Register
        </h1>

        <div class="grid gap-2">
            <Label for="name">Name</Label>
            <Input
                id="name"
                v-model="form.name"
                type="text"
                name="name"
                autocomplete="name"
                required
                autofocus
            />
            <InputError :message="form.errors.name" />
        </div>

        <div class="grid gap-2">
            <Label for="email">Email address</Label>
            <Input
                id="email"
                v-model="form.email"
                type="email"
                name="email"
                autocomplete="email"
                required
            />
            <InputError :message="form.errors.email" />
        </div>

        <div class="grid gap-2">
            <Label for="password">Password</Label>
            <Input
                id="password"
                v-model="form.password"
                type="password"
                name="password"
                autocomplete="new-password"
                required
            />
            <InputError :message="form.errors.password" />
        </div>

        <div class="grid gap-2">
            <Label for="password_confirmation">Confirm Password</Label>
            <Input
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                name="password_confirmation"
                autocomplete="new-password"
                required
            />
            <InputError :message="form.errors.password_confirmation" />
        </div>

        <Button type="submit" :disabled="form.processing">
            <Spinner v-if="form.processing" />
            Create account
        </Button>

        <p class="text-muted-foreground text-center text-sm">
            Already have an account?
            <Link
                :href="login()"
                class="text-foreground font-medium underline underline-offset-4 hover:no-underline"
            >
                Log in
            </Link>
        </p>
    </form>
</template>
