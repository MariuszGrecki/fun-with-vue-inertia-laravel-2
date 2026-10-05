<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ImagePlus, Trash2, X } from '@lucide/vue';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { destroy, store } from '@/routes/realtor/listing/image';
import type { Listing, ListingImage } from '@/types';

const props = defineProps<{
    listing: Listing;
}>();

const form = useForm<{ images: File[] }>({
    images: [],
});

const previews = ref<string[]>([]);

function addFiles(event: Event) {
    form.clearErrors();

    const input = event.target as HTMLInputElement;
    const files = Array.from(input.files ?? []);

    form.images.push(...files);
    previews.value.push(...files.map((file) => URL.createObjectURL(file)));

    input.value = '';
}

function removeFile(index: number) {
    form.clearErrors();

    URL.revokeObjectURL(previews.value[index]);
    form.images.splice(index, 1);
    previews.value.splice(index, 1);
}

function clearFiles() {
    previews.value.forEach((url) => URL.revokeObjectURL(url));
    previews.value = [];
    form.reset();
}

function upload() {
    form.submit(store(props.listing), {
        onSuccess: clearFiles,
    });
}

function deleteImage(image: ListingImage) {
    router.delete(destroy({ listing: props.listing.id, image: image.id }), {
        preserveScroll: true,
    });
}

function imageError(index: number): string | undefined {
    return (form.errors as Record<string, string>)[`images.${index}`];
}

</script>

<template>
    <Head title="Listing images" />

    <form
        @submit.prevent="upload"
        class="border-border mx-auto mt-6 max-w-2xl space-y-5 rounded-lg border p-6"
    >
        <header class="border-border border-b pb-3">
            <h1 class="text-foreground text-2xl font-semibold tracking-tight">
                Listing images
            </h1>
            <p class="text-muted-foreground text-sm">
                {{ listing.street }} {{ listing.street_nr }}, {{ listing.city }}
            </p>
        </header>

        <label
            class="border-border hover:bg-accent/40 flex cursor-pointer flex-col items-center gap-2 rounded-lg border-2 border-dashed px-6 py-10 text-center transition-colors"
        >
            <ImagePlus class="text-muted-foreground size-8" />
            <span class="text-foreground text-sm font-medium">
                Click to choose images
            </span>
            <span class="text-muted-foreground text-xs">
                You can select several at once and keep adding more
            </span>
            <input
                type="file"
                accept="image/*"
                multiple
                class="sr-only"
                @change="addFiles"
            />
        </label>

        <ul v-if="previews.length" class="grid grid-cols-3 gap-3 sm:grid-cols-4">
            <li
                v-for="(url, index) in previews"
                :key="url"
                class="relative aspect-square overflow-hidden rounded-md border"
                :class="imageError(index) ? 'border-destructive border-2' : 'border-border'"
            >
                <img
                    :src="url"
                    :alt="form.images[index].name"
                    class="size-full object-cover"
                />
                <button
                    type="button"
                    aria-label="Remove image"
                    class="bg-background/80 hover:bg-background absolute top-1 right-1 rounded-full p-1"
                    @click="removeFile(index)"
                >
                    <X class="size-4" />
                </button>
            </li>
        </ul>

        <ul
            v-if="form.hasErrors"
            class="bg-destructive/10 text-destructive space-y-1 rounded-md px-4 py-3 text-sm"
        >
            <li v-for="(message, key) in form.errors" :key="key">{{ message }}</li>
        </ul>

        <div v-if="form.progress" class="space-y-1.5">
            <div class="text-muted-foreground flex justify-between text-xs">
                <span>Uploading…</span>
                <span class="tabular-nums">{{ form.progress.percentage }}%</span>
            </div>
            <div class="bg-muted h-2 overflow-hidden rounded-full">
                <div
                    class="bg-primary h-full rounded-full transition-[width] duration-200"
                    :style="{ width: `${form.progress.percentage}%` }"
                />
            </div>
        </div>

        <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground text-sm">
                Selected: {{ form.images.length }}
            </span>
            <Button type="submit" :disabled="form.processing || !form.images.length">
                <Spinner v-if="form.processing" />
                Upload images
            </Button>
        </div>
    </form>

    <section v-if="listing.images?.length" class="mx-auto mt-6 max-w-2xl">
        <h2 class="text-foreground mb-3 text-lg font-semibold">
            Saved images ({{ listing.images.length }})
        </h2>

        <ul class="grid grid-cols-3 gap-3 sm:grid-cols-4">
            <li
                v-for="image in listing.images"
                :key="image.id"
                class="border-border relative aspect-square overflow-hidden rounded-md border"
            >
                <img :src="image.src" alt="" class="size-full object-cover" />
                <button
                    type="button"
                    aria-label="Delete image"
                    class="bg-background/80 text-destructive hover:bg-background absolute top-1 right-1 rounded-full p-1.5"
                    @click="deleteImage(image)"
                >
                    <Trash2 class="size-4" />
                </button>
            </li>
        </ul>
    </section>
</template>
