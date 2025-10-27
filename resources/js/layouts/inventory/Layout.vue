<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { CogIcon, MapPinnedIcon } from 'lucide-vue-next'
import { ref } from 'vue'
import Heading from '@/components/Heading.vue'
import Select from '@/components/Select.vue'
import { Button } from '@/components/ui/button'
import { Separator } from '@/components/ui/separator'
import { toUrl, urlIsActive } from '@/lib/utils'
import { show } from '@/routes/warehouses'
import { type NavItem } from '@/types'

const selectedPlace = ref<any>(null)

const sidebarNavItems: NavItem[] = [
    {
        title: 'Warehouses',
        href: show(),
    },
    {
        title: 'All Items',
        href: '#',
    },
]

const currentPath = typeof window !== undefined ? window.location.pathname : ''
</script>

<template>
    <div class="p-4 space-y-4">
        <div class="border border-sidebar-border/70 w-full rounded-xl flex items-center justify-between p-2">
            <Select
                v-model="selectedPlace"
                :places="[
                    { id: 1, name: 'Main Warehouse' },
                    { id: 2, name: 'Secondary Warehouse' },
                ]"
            />
            <div class="flex items-center space-x-2">
                <Button
                    :disabled="!selectedPlace"
                    variant="outline"
                >
                    <MapPinnedIcon />
                    <span>Show on Map</span>
                </Button>
                <Button
                    :disabled="!selectedPlace"
                    variant="outline"
                    size="icon"
                >
                    <CogIcon />
                </Button>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
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

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
