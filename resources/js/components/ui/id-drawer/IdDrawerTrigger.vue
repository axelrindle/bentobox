<script setup lang="ts">
import type { HTMLAttributes } from "vue";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { ScanQrCode } from "lucide-vue-next";
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from "@/components/ui/drawer";

const props = defineProps<{
    class?: HTMLAttributes["class"];
}>();
</script>

<template>
    <Drawer direction="top">
        <DrawerTrigger as-child>
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
        </DrawerTrigger>
        <DrawerContent direction="top">
            <DrawerHeader class="text-left">
                <DrawerTitle>Your Login-ID Code</DrawerTitle>
                <DrawerDescription>
                    Present this code to a BentoBox terminal to log in.
                </DrawerDescription>
            </DrawerHeader>
            <DrawerFooter>
                <Button>Submit</Button>
                <DrawerClose>
                    <Button variant="outline" class="w-full"> Cancel </Button>
                </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>
