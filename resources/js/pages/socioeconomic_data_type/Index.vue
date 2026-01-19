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
    title: 'Tipos de Dados Socioeconômicos',
    href: '/socioeconomic_data_type',
  },
];

interface SocioeconomicDataType {
  id: number;
  name: string;
  description: string;
}

defineProps<{
  socioeconomicDataTypes: SocioeconomicDataType[]
}>()

const columns: ColumnDef<SocioeconomicDataType>[] = [
  {
    accessorKey: 'name',
    header: 'Nome',
    cell: ({ row }) => row.getValue('name'),
  },
  {
    accessorKey: 'description',
    header: 'Descrição',
    cell: ({ row }) => row.getValue('description'),
  },
]

const actions = [
  {
    label: 'Editar',
    onClick: (row: SocioeconomicDataType) => {
      router.visit(`/socioeconomic_data_type/${row.id}/edit`)
    },
  },
  {
    label: 'Eliminar',
    danger: true,
    onClick: (row: SocioeconomicDataType) => {
      if (confirm('Tem certeza que deseja eliminar este tipo de dado?')) {
        router.delete(`/socioeconomic_data_type/${row.id}`)
      }
    },
  },
]
</script>

<template>

  <Head title="Tipos de Dados Socioeconômicos" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
      <GenericDataTable :data="socioeconomicDataTypes" :columns="columns" :actions="actions"
        title="Tipos de Dados Socioeconômicos" description="Gerencie os tipos de dados socioeconômicos do sistema.">
        <template #actions>
          <Button @click="router.visit('/socioeconomic_data_type/create')">
            <Plus class="mr-2 h-4 w-4" /> Novo Tipo
          </Button>
        </template>
      </GenericDataTable>
    </div>
  </AppLayout>
</template>
