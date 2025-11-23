<script setup lang="ts">
import { FlexRender, getCoreRowModel, useVueTable } from "@tanstack/vue-table";
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from "@/components/ui/pagination";

const props = defineProps<{
    data: Array<Record<string, any>>;
    columns: Array<any>;
    total?: number;
    itemsPerPage?: number;
}>();

const table = useVueTable({
    data: props.data,
    columns: props.columns,
    getCoreRowModel: getCoreRowModel(),
});
</script>

<template>
    <div class="flex flex-col space-y-4">
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
                <tr
                    v-for="row in table.getRowModel().rows"
                    :key="row.id"
                    class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors"
                >
                    <td
                        class="p-2 h-12 align-middle whitespace-nowrap"
                        v-for="cell in row.getVisibleCells()"
                        :key="cell.id"
                    >
                        <FlexRender
                            :render="cell.column.columnDef.cell"
                            :props="cell.getContext()"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex items-center justify-between">
            <div class="text-sm text-muted-foreground">
                Showing {{ table.getRowModel().rows.length }} of
                {{ props.total ?? props.data.length }} items
            </div>
            <Pagination
                v-if="total && itemsPerPage"
                v-slot="{ page }"
                :items-per-page="itemsPerPage"
                :total="total"
                as-child
            >
                <PaginationContent v-slot="{ items }">
                    <PaginationPrevious href="#" />
                    <template v-for="(item, index) in items" :key="index">
                        <PaginationItem
                            v-if="item.type === 'page'"
                            :value="item.value"
                            :is-active="item.value === page"
                            size="sm"
                        >
                            {{ item.value }}
                        </PaginationItem>
                        <PaginationEllipsis
                            v-else-if="item.type === 'ellipsis'"
                        />
                    </template>
                    <PaginationNext href="#" />
                </PaginationContent>
            </Pagination>
        </div>
    </div>
</template>
