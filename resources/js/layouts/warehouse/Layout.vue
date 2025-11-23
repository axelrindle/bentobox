<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Separator } from '@/components/ui/separator'
import { useCurrentPath } from '@/composables/useCurrentPath'
import { toUrl, urlIsActive } from '@/lib/utils'
import { type NavItem } from '@/types'
import { SidebarGroupLabel } from '@/components/ui/sidebar'
import { showSingleWarehouse } from '@/routes/inventory/warehouses'
import Heading from '@/components/Heading.vue'

const props = defineProps<{
    currentPlace: App.Data.PlaceResource
    currentWarehouse: App.Data.WarehouseResource
}>()

const sidebarNavItems: NavItem[] = [
    {
        title: 'All Items',
        href: showSingleWarehouse({ warehouse: props.currentWarehouse!, place: props.currentPlace! }),
    },
]

const currentPath = useCurrentPath()
</script>

<template>
    <div class="p-4 space-y-4">
        <Heading
            :title="currentWarehouse.name"
        />
        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
                    <SidebarGroupLabel>Warehouse</SidebarGroupLabel>
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        variant="ghost"
                        :class="[
                            'w-full justify-start',
                            { 'bg-muted': urlIsActive(item.href, currentPath) },
                        ]"
                        as-child
                    >
                        <Link :href="item.href">
                            <component
                                :is="item.icon"
                                class="h-4 w-4"
                            />
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
                <Separator class="my-6" />
                <nav class="flex flex-col space-y-1 space-x-0">
                    <SidebarGroupLabel>Tags</SidebarGroupLabel>
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        variant="ghost"
                        :class="[
                            'w-full justify-start',
                            { 'bg-muted': urlIsActive(item.href, currentPath) },
                        ]"
                        as-child
                    >
                        <Link :href="item.href">
                            <component
                                :is="item.icon"
                                class="h-4 w-4"
                            />
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1">
                <section class="space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
