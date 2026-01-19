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
        title: 'Famílias',
        href: '/family',
    },
];

interface Family {
    id: number;
    location: { name: string };
    user: { name: string };
}

defineProps<{
    families: Family[]
}>()

const columns: ColumnDef<Family>[] = [
    {
        accessorKey: 'location.name',
        header: 'Localização',
        cell: ({ row }) => row.original.location?.name ?? 'N/A',
    },
    {
        accessorKey: 'user.name',
        header: 'Responsável',
        cell: ({ row }) => row.original.user?.name ?? 'N/A',
    },
]

const actions = [
    {
        label: 'Editar',
        onClick: (row: Family) => {
            router.visit(`/family/${row.id}/edit`)
        },
    },
    {
        label: 'Eliminar',
        danger: true,
        onClick: (row: Family) => {
            if (confirm('Tem certeza que deseja eliminar esta família?')) {
                router.delete(`/family/${row.id}`)
            }
        },
    },
]
</script>

<template>

    <Head title="Famílias" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <GenericDataTable :data="families" :columns="columns" :actions="actions" title="Famílias"
                description="Gerencie as famílias beneficiárias.">
                <template #actions>
                    <Button @click="router.visit('/family/create')">
                        <Plus class="mr-2 h-4 w-4" /> Nova Família
                    </Button>
                </template>
            </GenericDataTable>
        </div>
    </AppLayout>
</template>
