<script setup lang="ts">
import {
  FlexRender,
  getCoreRowModel,
  useVueTable,
  createColumnHelper,
} from '@tanstack/vue-table'

const props = defineProps<{
  data: Array<Record<string, any>>
  columns: Array<any>
}>()

const table = useVueTable({
  data: props.data,
  columns: props.columns,
  getCoreRowModel: getCoreRowModel(),
})
</script>

<template>
    <table class="w-full caption-bottom text-sm">
        <thead class="border-b">
            <tr
                v-for="headerGroup in table.getHeaderGroups()"
                :key="headerGroup.id"
                class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors"
            >
                <th
                    v-for="header in headerGroup.headers"
                    :key="header.id"
                    :colSpan="header.colSpan"
                    class="text-muted-foreground h-12 px-2 text-left align-middle font-medium whitespace-nowrap"
                >
                    <FlexRender
                        v-if="!header.isPlaceholder"
                        :render="header.column.columnDef.header"
                        :props="header.getContext()"
                    />
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in table.getRowModel().rows" :key="row.id" class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                <td class="p-2 h-12 align-middle whitespace-nowrap" v-for="cell in row.getVisibleCells()" :key="cell.id">
                    <FlexRender
                        :render="cell.column.columnDef.cell"
                        :props="cell.getContext()"
                    />
                </td>
            </tr>
        </tbody>
    </table>
</template>
