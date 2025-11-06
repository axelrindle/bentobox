<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { createColumnHelper } from '@tanstack/vue-table'
import HeadingSmall from '@/components/HeadingSmall.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import InventoryLayout from '@/layouts/inventory/Layout.vue'
import { show } from '@/routes/two-factor'
import { BreadcrumbItem } from '@/types'
import Table from '@/components/ui/table/Table.vue'

const columnHelper = createColumnHelper<App.Data.WarehouseResource>()

const warehouseColumns = [
    columnHelper.accessor('name', {
        header: () => 'Name',
    }),
    columnHelper.display({
        header: 'Coordinates',
        cell: ({ row: { original } }) => `${original.latitude}°N,-${original.longitude}°W`,
    }),
    columnHelper.accessor('description', {
        header: () => 'Description',
    }),
]

defineProps<{
    places: App.Data.PlaceResource[]
    currentPlace: App.Data.PlaceResource
    warehouses: App.Data.WarehouseResource[]
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inventory',
        href: show.url(),
    },
    {
        title: 'Warehouses',
        href: show.url(),
    },
]
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Warehouses" />
        <InventoryLayout
            :places="places"
            :current-place="currentPlace"
        >
            <div class="flex flex-col space-y-6">
                <HeadingSmall
                    title="Warehouses"
                    description="Manage your warehouses"
                />
                <Table
                    :data="warehouses"
                    :columns="warehouseColumns"
                />
            </div>
        </InventoryLayout>
    </AppLayout>
</template>
