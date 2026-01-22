<script setup lang="ts">
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
    {
        title: 'Aprovações Pendentes',
        href: '/admin/approvals',
    },
];

interface Institution {
    id: number;
    name: string;
    nif: string;
    email: string;
    created_at: string;
    category?: {
        name: string;
    };
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
        accessorKey: 'category.name',
        header: 'Categoria',
        cell: ({ row }) => row.original.category?.name || 'N/A',
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
    {
        accessorKey: 'created_at',
        header: 'Data de Registo',
        cell: ({ row }) => new Date(row.getValue('created_at')).toLocaleDateString('pt-PT'),
    },
]

const actions = [
    {
        label: 'Aprovar',
        // variant: 'default', // Assuming GenericDataTable supports variant or class
        onClick: (row: Institution) => {
            if (confirm(`Tem certeza que deseja aprovar "${row.name}"?`)) {
                console.log(row.id);
                router.post(`/admin/approvals/${row.id}/approve`, {}, {
                    preserveScroll: true,
                    onSuccess: () => {
                        // Optional toast handled by global flash message
                    }
                })
            }
        },
    },
    {
        label: 'Rejeitar',
        danger: true,
        onClick: (row: Institution) => {
            if (confirm(`Tem certeza que deseja rejeitar "${row.name}"?`)) {
                router.post(`/admin/approvals/${row.id}/reject`, {}, {
                    preserveScroll: true,
                    onSuccess: () => {
                        // Optional toast
                    }
                })
            }
        },
    },
]
</script>

<template>

    <Head title="Aprovações de Instituições" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <GenericDataTable :data="institutions" :columns="columns" :actions="actions" title="Aprovações Pendentes"
                description="Gerencie as aprovações de novas instituições registadas no sistema.">
            </GenericDataTable>
        </div>
    </AppLayout>
</template>
