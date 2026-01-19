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
        title: 'Instituições',
        href: '/institution',
    },
];

interface Institution {
    id: number;
    name: string;
    nif: string;
    email: string;
}

const props = defineProps<{
    institutions: Institution[]
}>()

const columns: ColumnDef<Institution>[] = [
    {
        accessorKey: 'name',
        header: 'Nome',
        cell: ({ row }) => row.getValue('name'),
    },
    {
        accessorKey: 'nif',
        header: 'NIF',
        cell: ({ row }) => row.getValue('nif'),
    },
    {
        accessorKey: 'email',
        header: 'Email',
        cell: ({ row }) => row.getValue('email'),
    },
]

const actions = [
    {
        label: 'Editar',
        onClick: (row: Institution) => {
            router.visit(`/institution/${row.id}/edit`)
        },
    },
    {
        label: 'Eliminar',
        danger: true,
        onClick: (row: Institution) => {
            if (confirm('Tem certeza que deseja eliminar esta instituição?')) {
                router.delete(`/institution/${row.id}`)
            }
        },
    },
]
</script>

<template>

    <Head title="Instituições" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <GenericDataTable :data="institutions" :columns="columns" :actions="actions" title="Instituições"
                description="Gerencie as instituições parceiras.">
                <template #actions>
                    <Button @click="router.visit('/institution/create')">
                        <Plus class="mr-2 h-4 w-4" /> Nova Instituição
                    </Button>
                </template>
            </GenericDataTable>
        </div>
    </AppLayout>
</template>
