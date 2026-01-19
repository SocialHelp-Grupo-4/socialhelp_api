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
        title: 'Localizações',
        href: '/location',
    },
];

interface Location {
    id: number;
    name: string;
    geolocation: string;
}

const props = defineProps<{
    locations: Location[]
}>()

const columns: ColumnDef<Location>[] = [
    {
        accessorKey: 'name',
        header: 'Nome',
        cell: ({ row }) => row.getValue('name'),
    },
    {
        accessorKey: 'geolocation',
        header: 'Geolocalização',
        cell: ({ row }) => row.getValue('geolocation'),
    },
]

const actions = [
    {
        label: 'Editar',
        onClick: (row: Location) => {
            router.visit(`/location/${row.id}/edit`)
        },
    },
    {
        label: 'Eliminar',
        danger: true,
        onClick: (row: Location) => {
            if (confirm('Tem certeza que deseja eliminar esta localização?')) {
                router.delete(`/location/${row.id}`)
            }
        },
    },
]
</script>

<template>

    <Head title="Localizações" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <GenericDataTable :data="locations" :columns="columns" :actions="actions" title="Localizações"
                description="Gerencie as comunidades e localizações do sistema.">
                <template #actions>
                    <Button @click="router.visit('/location/create')">
                        <Plus class="mr-2 h-4 w-4" /> Nova Localização
                    </Button>
                </template>
            </GenericDataTable>
        </div>
    </AppLayout>
</template>
