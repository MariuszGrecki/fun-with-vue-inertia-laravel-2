<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Spinner } from '@/components/ui/spinner';
import type { ButtonVariants } from '@/components/ui/button';

const open = defineModel<boolean>('open', { required: true });

withDefaults(
    defineProps<{
        title?: string;
        description?: string;
        confirmLabel?: string;
        cancelLabel?: string;
        confirmVariant?: ButtonVariants['variant'];
        processing?: boolean;
    }>(),
    {
        title: 'Na pewno?',
        description: 'Tej operacji nie można cofnąć.',
        confirmLabel: 'Potwierdź',
        cancelLabel: 'Anuluj',
        confirmVariant: 'destructive',
        processing: false,
    },
);

const emit = defineEmits<{ confirm: [] }>();
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
                <DialogDescription>{{ description }}</DialogDescription>
            </DialogHeader>

            <slot />

            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline" :disabled="processing">
                        {{ cancelLabel }}
                    </Button>
                </DialogClose>

                <Button
                    :variant="confirmVariant"
                    :disabled="processing"
                    @click="emit('confirm')"
                >
                    <Spinner v-if="processing" />
                    {{ confirmLabel }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
