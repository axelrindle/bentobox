<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { ScanQrCode } from 'lucide-vue-next'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()

</script>

<template>
  <Button
    data-sidebar="trigger"
    data-slot="sidebar-trigger"
    variant="ghost"
    size="icon"
    :class="cn('h-7 w-7', props.class)"
  >
    <ScanQrCode />
    <span class="sr-only">Show Login-ID Code</span>
  </Button>
</template>
