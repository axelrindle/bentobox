<script lang="ts" setup>
import { Candy, HandCoins } from 'lucide-vue-next'
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip'

defineProps<{
    properties: {
        isLendable: boolean;
        isConsumable: boolean;
    };
}>()
</script>

<template>
    <div class="flex items-center gap-2">
        <TooltipProvider>
            <Tooltip v-if="properties.isLendable">
                <TooltipTrigger as-child>
                    <HandCoins class="size-4 text-muted-foreground" />
                </TooltipTrigger>
                <TooltipContent>
                    <p>Lendable</p>
                </TooltipContent>
            </Tooltip>
            <Tooltip v-if="properties.isConsumable">
                <TooltipTrigger as-child>
                    <Candy class="size-4 text-muted-foreground" />
                </TooltipTrigger>
                <TooltipContent>
                    <p>Consumable</p>
                </TooltipContent>
            </Tooltip>
        </TooltipProvider>
    </div>
</template>
