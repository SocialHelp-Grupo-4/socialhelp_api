<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3'
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

defineProps<{
    categorias: {
        id: number
        nome: string
    }[]
}>()

function remover(id: number) {
    if (confirm('Tem certeza?')) {
        router.delete(`/categorias-instituicao/${id}`)
    }
}
</script>

<template>

    <Head title="Categorias de Instituição" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="p-4">
                    <a href="/categorias-instituicao/create" class="btn btn-primary mb-4">
                        Nova Categoria
                    </a>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="w-40">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="c in categorias" :key="c.id">
                                <td>{{ c.nome }}</td>
                                <td class="flex gap-2">
                                    <a :href="`/categorias-instituicao/${c.id}/edit`" class="btn btn-sm">
                                        Editar
                                    </a>

                                    <button @click="remover(c.id)" class="btn btn-sm btn-danger">
                                        Remover
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
