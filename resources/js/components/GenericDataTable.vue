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
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
} from '@/components/ui/dropdown-menu'

import { IconDotsVertical } from '@tabler/icons-vue'

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
}

/* =======================
   PROPS
======================= */

const props = defineProps<Props<any>>()

/* =======================
   STATE
======================= */

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})

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
                      { variant: 'ghost', size: 'icon' },
                      () => h(IconDotsVertical)
                    ),
                }
              ),
              h(
                DropdownMenuContent,
                {},
                {
                  default: () =>
                    props.actions!.map(action =>
                      h(
                        DropdownMenuItem,
                        {
                          class: action.danger ? 'text-red-600' : '',
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
  <div class="rounded-lg border overflow-hidden">
    <Table>
      <TableHeader>
        <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
          <TableHead
            v-for="header in headerGroup.headers"
            :key="header.id"
            :col-span="header.colSpan"
          >
            <FlexRender
              v-if="!header.isPlaceholder"
              :render="header.column.columnDef.header"
              :props="header.getContext()"
            />
          </TableHead>
        </TableRow>
      </TableHeader>

      <TableBody>
        <TableRow
          v-for="row in table.getRowModel().rows"
          :key="row.id"
        >
          <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
            <FlexRender
              :render="cell.column.columnDef.cell"
              :props="cell.getContext()"
            />
          </TableCell>
        </TableRow>

        <TableRow v-if="!table.getRowModel().rows.length">
          <TableCell
            :col-span="finalColumns.length"
            class="text-center py-6 text-muted-foreground"
          >
            Nenhum registo encontrado
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </div>
</template>
