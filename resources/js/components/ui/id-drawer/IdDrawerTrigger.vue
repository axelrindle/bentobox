<script setup lang="ts">
import { nextTick, onMounted, ref, watch, type HTMLAttributes } from "vue";
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
import { usePage } from "@inertiajs/vue3";
import QRCodeStyling from "qr-code-styling";

const page = usePage();
const user = page.props.auth.user;

const open = ref(false);
const qrCode = ref<QRCodeStyling | null>(null);
const canvas = ref<HTMLElement>();

const props = defineProps<{
    class?: HTMLAttributes["class"];
}>();

watch(open, async (newVal) => {
    await nextTick();
    if (newVal && canvas.value) {
        qrCode.value = new QRCodeStyling({
            width: 160,
            height: 160,
            type: "svg",
            data: user.email,
            dotsOptions: {
                type: "dots",
            },
            cornersDotOptions: {
                type: "dot",
            },
            cornersSquareOptions: {
                type: "extra-rounded",
            },
        });

        qrCode.value.append(canvas.value);
    }
});
</script>

<template>
    <Drawer v-model:open="open" direction="top">
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
            <DrawerHeader>
                <DrawerTitle>Your Login-ID Code</DrawerTitle>
                <DrawerDescription>
                    Present this code to a BentoBox terminal to log in.
                </DrawerDescription>
            </DrawerHeader>

            <div class="flex items-center justify-center my-4">
                <div ref="canvas" class="border rounded-3xl size-44 flex items-center justify-center overflow-hidden"></div>
            </div>

            <DrawerFooter>
                <DrawerClose>
                    <Button variant="outline" class="w-full"> Cancel </Button>
                </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>
