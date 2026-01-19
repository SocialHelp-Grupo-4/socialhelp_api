<script setup lang="ts">
import GenericDataTable from '@/components/GenericDataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3'
import { ColumnDef } from '@tanstack/vue-table';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';

interface User {
    id: number;
    name: string;
    email: string;
    created_at: string;
}

const props = defineProps<{
    users: User[]
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Utilizadores',
        href: '/users',
    },
];

const columns: ColumnDef<User>[] = [
    {
        accessorKey: 'name',
        header: 'Nome',
        cell: ({ row }) => row.getValue('name'),
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
        label: 'Editar',
        onClick: (row: User) => {
            router.visit(`/users/${row.id}/edit`)
        },
    },
    {
        label: 'Eliminar',
        danger: true,
        onClick: (row: User) => {
            if (confirm('Tem certeza que deseja eliminar este utilizador?')) {
                router.delete(`/users/${row.id}`)
            }
        },
    },
]
</script>

<template>

    <Head title="Utilizadores" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <GenericDataTable :data="users" :columns="columns" :actions="actions" title="Lista de Utilizadores"
                description="Gerencie os utilizadores do sistema, crie novos, edite ou remova existentes.">
                <template #actions>
                    <Button @click="router.visit('/users/create')">
                        <Plus class="mr-2 h-4 w-4" /> Novo Utilizador
                    </Button>
                </template>
            </GenericDataTable>
        </div>
    </AppLayout>
</template>
