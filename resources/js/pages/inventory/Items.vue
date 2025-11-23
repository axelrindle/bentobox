<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import InventoryLayout from '@/layouts/inventory/Layout.vue'
import { BreadcrumbItem } from '@/types'
import { show } from '@/routes/inventory/warehouses'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inventory',
        href: show.url(),
    },
    {
        title: 'All Items',
        href: show.url(),
    },
]
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="All Items" />
        <InventoryLayout>
            <div class="space-y-6">
                So many items, so much stock to manage.
            </div>
        </InventoryLayout>
    </AppLayout>
</template>
