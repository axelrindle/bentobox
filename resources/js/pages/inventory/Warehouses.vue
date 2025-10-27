<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3'
import { ShieldBan, ShieldCheck } from 'lucide-vue-next'
import { onUnmounted, ref } from 'vue'
import HeadingSmall from '@/components/HeadingSmall.vue'
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue'
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth'
import AppLayout from '@/layouts/AppLayout.vue'
import InventoryLayout from '@/layouts/inventory/Layout.vue'
import { disable, enable, show } from '@/routes/two-factor'
import { BreadcrumbItem } from '@/types'

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
        <InventoryLayout>
            <div class="space-y-6">
                So many warehouses, so little time.
            </div>
        </InventoryLayout>
    </AppLayout>
</template>
