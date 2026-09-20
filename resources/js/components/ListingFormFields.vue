<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { InertiaForm } from '@inertiajs/vue3';
import type { ListingForm } from '@/types';

defineProps<{ form: InertiaForm<ListingForm> }>();
</script>

<template>
    <div class="grid gap-2 sm:col-span-6">
        <Label for="street">Ulica</Label>
        <Input id="street" v-model="form.street" required />
        <InputError :message="form.errors.street" />
    </div>

    <div class="grid gap-2 sm:col-span-3">
        <Label for="street_nr">Numer</Label>
        <Input id="street_nr" v-model="form.street_nr" required />
        <InputError :message="form.errors.street_nr" />
    </div>

    <div class="grid gap-2 sm:col-span-3">
        <Label for="code">Kod pocztowy</Label>
        <Input id="code" v-model="form.code" required />
        <InputError :message="form.errors.code" />
    </div>

    <div class="grid gap-2 sm:col-span-6">
        <Label for="city">Miasto</Label>
        <Input id="city" v-model="form.city" required />
        <InputError :message="form.errors.city" />
    </div>

    <div class="grid gap-2 sm:col-span-2">
        <Label for="beds">Sypialnie</Label>
        <Input id="beds" v-model="form.beds" type="number" required />
        <InputError :message="form.errors.beds" />
    </div>

    <div class="grid gap-2 sm:col-span-2">
        <Label for="baths">Łazienki</Label>
        <Input id="baths" v-model="form.baths" type="number" required />
        <InputError :message="form.errors.baths" />
    </div>

    <div class="grid gap-2 sm:col-span-2">
        <Label for="area">Powierzchnia (m²)</Label>
        <Input id="area" v-model="form.area" type="number" required />
        <InputError :message="form.errors.area" />
    </div>

    <div class="grid gap-2 sm:col-span-6">
        <Label for="price">Cena (zł)</Label>
        <Input id="price" v-model="form.price" type="number" required />
        <InputError :message="form.errors.price" />
    </div>
</template>
