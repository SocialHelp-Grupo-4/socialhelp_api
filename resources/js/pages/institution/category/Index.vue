<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import GenericDataTable from '@/components/GenericDataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3'
import { ColumnDef } from '@tanstack/vue-table';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

interface Category {
  id: number
  name: string
}

defineProps<{
      categories: Category[]
}>()

const columns: ColumnDef<Category>[] = [
  {
    accessorKey: 'name',
    header: 'Nome',
    cell: ({ row }) => row.getValue('name'),
  },
]

const actions = [
  {
    label: 'Editar',
    onClick: (row: Category) => {
      console.log('Editar', row)
    },
  },
  {
    label: 'Eliminar',
    danger: true,
    onClick: (row: Category) => {
      console.log('Eliminar', row)
    },
  },
]

function remover(id: number) {
    if (confirm('Tem certeza?')) {
        router.delete(`/institution/category/${id}`)
    }
}

const data = [
  {
    id: 1,
    header: "Cover page",
    type: "Cover page",
    status: "In Process",
    target: "18",
    limit: "5",
    reviewer: "Eddie Lake",
  },
  {
    id: 2,
    header: "Table of contents",
    type: "Table of contents",
    status: "Done",
    target: "29",
    limit: "24",
    reviewer: "Eddie Lake",
  }
];
</script>

<template>

    <Head title="Categorias de Instituição" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">

            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                  <DataTable :data="data" />

                <GenericDataTable
                    :data="categories"
                    :columns="columns"
                    :actions="actions"
                />

            </div>
        </div>
    </AppLayout>
</template>
