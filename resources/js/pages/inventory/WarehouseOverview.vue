<script setup lang="tsx">
import { Head, Link } from '@inertiajs/vue3'
import { createColumnHelper } from '@tanstack/vue-table'
import { ArrowRight } from 'lucide-vue-next'
import HeadingSmall from '@/components/HeadingSmall.vue'
import { Button } from '@/components/ui/button'
import Table from '@/components/ui/table/Table.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import InventoryLayout from '@/layouts/inventory/Layout.vue'
import { show } from '@/routes/two-factor'
import { BreadcrumbItem, PaginationParams } from '@/types'
import { showSingleWarehouse } from '@/routes/inventory/warehouses'

const columnHelper = createColumnHelper<App.Data.WarehouseResource>()

const warehouseColumns = [
    columnHelper.accessor('name', {
        header: 'Name',
    }),
    columnHelper.display({
        header: 'Coordinates',
        cell: ({ row: { original } }) =>
            `${original.latitude}°N,-${original.longitude}°W`,
    }),
    columnHelper.accessor('description', {
        header: 'Description',
    }),
    columnHelper.display({
        id: 'actions',
        cell: ({ row: { original } }) => (
            <Button class="float-right" asChild>
                <Link
                    href={showSingleWarehouse(
                        {
                            place: props.currentPlace.id,
                            warehouse: original.id,
                        },
                        {
                            query: {
                                page: 1,
                                per_page: 15,
                            } satisfies PaginationParams,
                        },
                    )}
                >
                    <span>View</span>
                    <ArrowRight class="size-4" />
                </Link>
            </Button>
        ),
    }),
]

const props = defineProps<{
    places: App.Data.PlaceResource[];
    currentPlace: App.Data.PlaceResource;
    warehouses: App.Data.WarehouseResource[];
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
