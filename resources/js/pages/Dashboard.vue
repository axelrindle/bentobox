<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import Form, { type Field } from '@/components/Form.vue'

const exampleForm: Field[] = [
    { label: 'First Name', name: 'firstName', type: 'text', default: 'John' },
    { label: 'Last Name', name: 'lastName', type: 'text', default: 'Doe' },
    { label: 'Email', name: 'email', type: 'email' },
]

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
]
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form
                :fields="exampleForm"
                :on-submit="(data) => { console.log('Form submitted with data:', data) }"
            />
        </div>
    </AppLayout>
</template>
