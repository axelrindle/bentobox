<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import WarehouseLayout from '@/layouts/warehouse/Layout.vue'
import { BreadcrumbItem } from '@/types'

const props = defineProps<{
    currentPlace: App.Data.PlaceResource
    currentWarehouse: App.Data.WarehouseResource
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inventory',
        href: "#",
    },
    {
        title: 'Warehouses',
        href: "#",
    },
    {
        title: props.currentWarehouse.name,
        href: "#",
    },
]
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="`Warehouse - ${currentWarehouse.name}`" />
        <WarehouseLayout
            :current-place="currentPlace"
            :current-warehouse="currentWarehouse"
        >
            <div class="flex flex-col space-y-6">
                <HeadingSmall
                    title="Warehouses"
                    description="Manage your warehouses"
                />
            </div>
        </WarehouseLayout>
    </AppLayout>
</template>
