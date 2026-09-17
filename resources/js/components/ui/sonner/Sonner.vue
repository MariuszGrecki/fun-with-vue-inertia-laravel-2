<script lang="ts" setup>
import type { ToasterProps } from "vue-sonner"
import { CircleCheckIcon, InfoIcon, Loader2Icon, OctagonXIcon, TriangleAlertIcon, XIcon } from "@lucide/vue"
import { Toaster as Sonner } from "vue-sonner"
import { cn } from "@/lib/utils"

import 'vue-sonner/style.css';

const props = defineProps<ToasterProps>()
</script>

<template>
  <Sonner
    :class="cn('toaster group', props.class)"
    :style="{
      '--normal-bg': 'var(--popover)',
      '--normal-text': 'var(--popover-foreground)',
      '--normal-border': 'var(--border)',
      '--border-radius': 'var(--radius)',
      '--success-bg': 'color-mix(in oklab, oklch(0.72 0.19 150) 12%, var(--popover))',
      '--success-border': 'color-mix(in oklab, oklch(0.72 0.19 150) 35%, var(--popover))',
      '--success-text': 'var(--popover-foreground)',
      '--info-bg': 'color-mix(in oklab, oklch(0.62 0.19 260) 12%, var(--popover))',
      '--info-border': 'color-mix(in oklab, oklch(0.62 0.19 260) 35%, var(--popover))',
      '--info-text': 'var(--popover-foreground)',
      '--warning-bg': 'color-mix(in oklab, oklch(0.80 0.16 80) 15%, var(--popover))',
      '--warning-border': 'color-mix(in oklab, oklch(0.80 0.16 80) 40%, var(--popover))',
      '--warning-text': 'var(--popover-foreground)',
      '--error-bg': 'color-mix(in oklab, oklch(0.64 0.22 27) 12%, var(--popover))',
      '--error-border': 'color-mix(in oklab, oklch(0.64 0.22 27) 35%, var(--popover))',
      '--error-text': 'var(--popover-foreground)',
    }"
    v-bind="props"
    rich-colors
  >
    <template #success-icon>
      <CircleCheckIcon class="size-4 text-green-600 dark:text-green-400" />
    </template>
    <template #info-icon>
      <InfoIcon class="size-4 text-blue-600 dark:text-blue-400" />
    </template>
    <template #warning-icon>
      <TriangleAlertIcon class="size-4 text-amber-600 dark:text-amber-400" />
    </template>
    <template #error-icon>
      <OctagonXIcon class="size-4 text-red-600 dark:text-red-400" />
    </template>
    <template #loading-icon>
      <div>
        <Loader2Icon class="size-4 animate-spin" />
      </div>
    </template>
    <template #close-icon>
      <XIcon class="size-4" />
    </template>
  </Sonner>
</template>
