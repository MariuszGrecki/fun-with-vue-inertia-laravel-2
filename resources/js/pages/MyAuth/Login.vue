<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/auth/login';
import { create as register } from '@/routes/user-account';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.submit(store(), {
        onFinish: () => form.reset('password'),
    });
}

function loginAsTestUser(email: string) {
    form.email = email;
    form.password = 'password';
    submit();
}
</script>

<template>
    <Head title="Log in" />

    <form
        @submit.prevent="submit"
        class="border-border mx-auto mt-6 grid max-w-sm gap-4 rounded-lg border p-6"
    >
        <h1 class="text-foreground text-2xl font-semibold tracking-tight">
            Log in
        </h1>

        <div class="grid gap-2">
            <Label for="email">Email address</Label>
            <Input
                id="email"
                v-model="form.email"
                type="email"
                name="email"
                autocomplete="username"
                required
                autofocus
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
                autocomplete="current-password"
                required
            />
            <InputError :message="form.errors.password" />
        </div>

        <div class="flex items-center gap-2">
            <Checkbox id="remember" v-model="form.remember" />
            <Label for="remember" class="text-muted-foreground font-normal">
                Remember me
            </Label>
        </div>

        <Button type="submit" :disabled="form.processing">
            <Spinner v-if="form.processing" />
            Log in
        </Button>

        <div class="border-border flex gap-2 border-t pt-4">
            <Button
                type="button"
                variant="outline"
                class="flex-1"
                :disabled="form.processing"
                @click="loginAsTestUser('test@example.com')"
            >
                Log in as test user 1
            </Button>
            <Button
                type="button"
                variant="outline"
                class="flex-1"
                :disabled="form.processing"
                @click="loginAsTestUser('test2@example.com')"
            >
                Log in as test user 2
            </Button>
        </div>

        <p class="text-muted-foreground text-center text-sm">
            Don't have an account?
            <Link
                :href="register()"
                class="text-foreground font-medium underline underline-offset-4 hover:no-underline"
            >
                Sign up
            </Link>
        </p>
    </form>
</template>
