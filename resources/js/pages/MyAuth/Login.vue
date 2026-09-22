<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/auth/login';

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
</script>

<template>
    <Head title="Logowanie" />

    <form
        @submit.prevent="submit"
        class="border-border mx-auto mt-6 grid max-w-sm gap-4 rounded-lg border p-6"
    >
        <h1 class="text-foreground text-2xl font-semibold tracking-tight">
            Logowanie
        </h1>

        <div class="grid gap-2">
            <Label for="email">E-mail</Label>
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
            <Label for="password">Hasło</Label>
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
                Zapamiętaj mnie
            </Label>
        </div>

        <Button type="submit" :disabled="form.processing">
            <Spinner v-if="form.processing" />
            Zaloguj
        </Button>
    </form>
</template>
