<script lang="ts" setup>
import type { DialogContentEmits, DialogContentProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { useForwardPropsEmits } from "reka-ui"
import { DrawerContent, DrawerPortal } from "vaul-vue"
import { cn } from "@/lib/utils"
import DrawerOverlay from "./DrawerOverlay.vue"

const props = defineProps<DialogContentProps & { class?: HTMLAttributes["class"], direction: "top" | "bottom" }>()
const emits = defineEmits<DialogContentEmits>()

const forwarded = useForwardPropsEmits(props, emits)
</script>

<template>
  <DrawerPortal>
    <DrawerOverlay />
    <DrawerContent
      v-bind="forwarded" :class="cn(
        'fixed inset-x-0 z-50 flex h-auto flex-col border bg-background',
        props.direction === 'top' ? 'top-0 mb-24 rounded-b-xl' : 'mt-24 bottom-0 rounded-t-xl',
        props.class,
      )"
    >
      <slot />
    </DrawerContent>
  </DrawerPortal>
</template>
