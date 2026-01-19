<script setup lang="ts">
import GenericDataTable from '@/components/GenericDataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3'
import { ColumnDef } from '@tanstack/vue-table';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Áreas de Problema',
    href: '/problem_area',
  },
];

interface ProblemArea {
  id: number;
  name: string;
}

defineProps<{
  problemAreas: ProblemArea[]
}>()

const columns: ColumnDef<ProblemArea>[] = [
  {
    accessorKey: 'name',
    header: 'Nome',
    cell: ({ row }) => row.getValue('name'),
  },
]

const actions = [
  {
    label: 'Editar',
    onClick: (row: ProblemArea) => {
      router.visit(`/problem_area/${row.id}/edit`)
    },
  },
  {
    label: 'Eliminar',
    danger: true,
    onClick: (row: ProblemArea) => {
      if (confirm('Tem certeza que deseja eliminar esta área de problema?')) {
        router.delete(`/problem_area/${row.id}`)
      }
    },
  },
]
</script>

<template>

  <Head title="Áreas de Problema" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
      <GenericDataTable :data="problemAreas" :columns="columns" :actions="actions" title="Áreas de Problema"
        description="Gerencie as áreas de problema e intervenção.">
        <template #actions>
          <Button @click="router.visit('/problem_area/create')">
            <Plus class="mr-2 h-4 w-4" /> Nova Área
          </Button>
        </template>
      </GenericDataTable>
    </div>
  </AppLayout>
</template>
