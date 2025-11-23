<script setup lang="tsx">
import { Head } from '@inertiajs/vue3'
import { createColumnHelper } from '@tanstack/vue-table'
import { Link } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import WarehouseLayout from '@/layouts/warehouse/Layout.vue'
import { BreadcrumbItem } from '@/types'
import { showOverview } from '@/routes/inventory/warehouses'
import HeadingSmall from '@/components/HeadingSmall.vue'
import Input from '@/components/ui/input/Input.vue'
import Table from '@/components/ui/table/Table.vue'
import { Button } from '@/components/ui/button'
import type { PaginatedResource } from '@/types'

import WarehouseDetailsProperties from '@/components/WarehouseDetailsProperties.vue'

const columnHelper = createColumnHelper<App.Data.ItemResource>()

const props = defineProps<{
    currentPlace: App.Data.PlaceResource;
    currentWarehouse: App.Data.WarehouseResource;
    items: PaginatedResource<App.Data.ItemResource>;
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inventory',
        href: '#',
    },
    {
        title: 'Warehouses',
        href: showOverview(),
    },
    {
        title: props.currentWarehouse.name,
        href: '#',
    },
]

const itemsColumns = [
    columnHelper.accessor('name', {
        header: 'Name',
    }),
    columnHelper.accessor('amount', {
        header: 'Amount',
    }),
    columnHelper.accessor('tags', {
        header: 'Tags',
    }),
    columnHelper.display({
        header: 'Properties',
        cell: ({ row: { original } }) => {
            return (
                <WarehouseDetailsProperties
                    properties={{
                        isLendable: original.isLendable,
                        isConsumable: original.isConsumable,
                    }}
                />
            )
        },
    }),
    columnHelper.display({
        id: 'actions',
        cell: ({ row: { original } }) => (
            <Button class="float-right" asChild>
                {/* TODO: replace with warehouse detail link */}
                <Link href="#">
                    <span>View</span>
                    <ArrowRight class="size-4" />
                </Link>
            </Button>
        ),
    }),
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
                <div class="flex items-center justify-between">
                    <HeadingSmall
                        title="All Items"
                        description="Filter and manage all items stored in this warehouse."
                    />
                    <Input
                        placeholder="Search items..."
                        class="w-64"
                    />
                </div>

                <Table
                    :data="items.data"
                    :columns="itemsColumns"
                    :total="items.total"
                    :items-per-page="items.per_page"
                />
            </div>
        </WarehouseLayout>
    </AppLayout>
</template>
