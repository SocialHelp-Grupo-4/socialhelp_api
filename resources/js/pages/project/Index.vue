<script setup lang="ts">
import GenericDataTable from '@/components/GenericDataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3'
import { ColumnDef } from '@tanstack/vue-table';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Projectos',
    href: '/project',
  },
];

interface Project {
  id: number;
  name: string;
  start_date: string;
  end_date: string;
  status: string;
  institution: { name: string };
}

defineProps<{
  projects: Project[]
}>()

const columns: ColumnDef<Project>[] = [
  {
    accessorKey: 'name',
    header: 'Nome',
    cell: ({ row }) => row.getValue('name'),
  },
  {
    accessorKey: 'institution.name',
    header: 'Instituição',
    cell: ({ row }) => row.original.institution?.name ?? 'N/A',
  },
  {
    accessorKey: 'start_date',
    header: 'Data Início',
    cell: ({ row }) => row.getValue('start_date'),
  },
  {
    accessorKey: 'end_date',
    header: 'Data Fim',
    cell: ({ row }) => row.getValue('end_date'),
  },
  {
    accessorKey: 'status',
    header: 'Estado',
    cell: ({ row }) => {
      const status = row.getValue('status') as string;
      return status; // Can use Badge here if I import it. I'll use simple text for now or try to import Badge if I knew where it was (it was in list_dir).
    },
  },
]

const actions = [
  {
    label: 'Editar',
    onClick: (row: Project) => {
      router.visit(`/project/${row.id}/edit`)
    },
  },
  {
    label: 'Eliminar',
    danger: true,
    onClick: (row: Project) => {
      if (confirm('Tem certeza que deseja eliminar este projecto?')) {
        router.delete(`/project/${row.id}`)
      }
    },
  },
]
</script>

<template>

  <Head title="Projectos" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
      <GenericDataTable :data="projects" :columns="columns" :actions="actions" title="Projectos"
        description="Gerencie os projectos sociais.">
        <template #actions>
          <Button @click="router.visit('/project/create')">
            <Plus class="mr-2 h-4 w-4" /> Novo Projecto
          </Button>
        </template>
      </GenericDataTable>
    </div>
  </AppLayout>
</template>
