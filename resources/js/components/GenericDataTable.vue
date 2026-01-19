<script setup lang="ts">
import { h, ref, computed } from 'vue'
import type {
  ColumnDef,
  SortingState,
  ColumnFiltersState,
  VisibilityState,
} from '@tanstack/vue-table'
import {
  useVueTable,
  getCoreRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  getFilteredRowModel,
  FlexRender,
} from '@tanstack/vue-table'

import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody,
  TableCell,
} from '@/components/ui/table'

import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
} from '@/components/ui/dropdown-menu'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'

import { IconDotsVertical, IconChevronLeft, IconChevronRight, IconSearch } from '@tabler/icons-vue'

/* =======================
   TYPES
======================= */

export interface DataTableAction<T> {
  label: string
  onClick: (row: T) => void
  danger?: boolean
}

interface Props<T> {
  data: T[]
  columns: ColumnDef<T>[]
  actions?: DataTableAction<T>[]
  title?: string
  description?: string
  searchPlaceholder?: string
}

/* =======================
   PROPS
======================= */

const props = withDefaults(defineProps<Props<any>>(), {
  searchPlaceholder: 'Pesquisar...',
  title: 'Lista',
  description: 'Gerencie os registros do sistema.'
})

/* =======================
   STATE
======================= */

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const globalFilter = ref('')

/* =======================
   ACTION COLUMN (OPTIONAL)
======================= */

const finalColumns = computed<ColumnDef<any>[]>(() => {
  if (!props.actions?.length) return props.columns

  return [
    ...props.columns,
    {
      id: 'actions',
      header: 'Ações',
      enableSorting: false,
      cell: ({ row }) =>
        h(
          DropdownMenu,
          {},
          {
            default: () => [
              h(
                DropdownMenuTrigger,
                { asChild: true },
                {
                  default: () =>
                    h(
                      Button,
                      { variant: 'ghost', size: 'icon', class: 'h-8 w-8 p-0' },
                      () => h(IconDotsVertical, { size: 16 })
                    ),
                }
              ),
              h(
                DropdownMenuContent,
                { align: 'end' },
                {
                  default: () =>
                    props.actions!.map(action =>
                      h(
                        DropdownMenuItem,
                        {
                          class: action.danger ? 'text-red-600 focus:text-red-600 focus:bg-red-50' : '',
                          onClick: () => action.onClick(row.original),
                        },
                        () => action.label
                      )
                    ),
                }
              ),
            ],
          }
        ),
    },
  ]
})

/* =======================
   TABLE INSTANCE
======================= */

const table = useVueTable({
  get data() {
    return props.data
  },
  columns: finalColumns.value,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),

  onSortingChange: updater =>
  (sorting.value =
    typeof updater === 'function' ? updater(sorting.value) : updater),

  onColumnFiltersChange: updater =>
  (columnFilters.value =
    typeof updater === 'function'
      ? updater(columnFilters.value)
      : updater),

  onGlobalFilterChange: updater =>
  (globalFilter.value =
    typeof updater === 'function'
      ? updater(globalFilter.value)
      : updater),

  onColumnVisibilityChange: updater =>
  (columnVisibility.value =
    typeof updater === 'function'
      ? updater(columnVisibility.value)
      : updater),

  onRowSelectionChange: updater =>
  (rowSelection.value =
    typeof updater === 'function'
      ? updater(rowSelection.value)
      : updater),

  state: {
    get sorting() {
      return sorting.value
    },
    get columnFilters() {
      return columnFilters.value
    },
    get globalFilter() {
      return globalFilter.value
    },
    get columnVisibility() {
      return columnVisibility.value
    },
    get rowSelection() {
      return rowSelection.value
    },
  },
})
</script>

<template>
  <Card class="w-full">
    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-4">
      <div class="space-y-1">
        <CardTitle>{{ title }}</CardTitle>
        <CardDescription>{{ description }}</CardDescription>
      </div>
      <div class="flex items-center gap-2">
        <slot name="actions" />
      </div>
    </CardHeader>
    <CardContent>
      <div class="flex items-center py-4 gap-2">
        <div class="relative max-w-sm w-full">
          <IconSearch class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
          <Input :placeholder="searchPlaceholder" :model-value="globalFilter ?? ''"
            @update:model-value="val => globalFilter = String(val)" class="pl-8" />
        </div>

      </div>
      <div class="rounded-md border">
        <Table>
          <TableHeader>
            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
              <TableHead v-for="header in headerGroup.headers" :key="header.id" :col-span="header.colSpan">
                <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                  :props="header.getContext()" />
              </TableHead>
            </TableRow>
          </TableHeader>

          <TableBody>
            <TableRow v-for="row in table.getRowModel().rows" :key="row.id"
              :data-state="row.getIsSelected() ? 'selected' : undefined">
              <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
              </TableCell>
            </TableRow>

            <TableRow v-if="!table.getRowModel().rows.length">
              <TableCell :col-span="finalColumns.length" class="text-center py-10 text-muted-foreground">
                Nenhum registo encontrado
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>

      <div class="flex items-center justify-end space-x-2 py-4">
        <div class="flex-1 text-sm text-muted-foreground">
          Página {{ table.getState().pagination.pageIndex + 1 }} de {{ table.getPageCount() }}
        </div>
        <div class="space-x-2">
          <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
            Anterior
          </Button>
          <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
            Próximo
          </Button>
        </div>
      </div>
    </CardContent>
  </Card>
</template>
