<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
    user: {
        id: number;
        name: string;
        email: string;
    }
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Utilizadores',
        href: '/users',
    },
    {
        title: 'Editar',
        href: `/users/${props.user.id}/edit`,
    },
]

const form = useForm({
    name: props.user.name,
    email: props.user.email,
})

function submit() {
    form.put(`/users/${props.user.id}`)
}
</script>

<template>

    <Head title="Editar Utilizador" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6 max-w-2xl mx-auto w-full">
            <form @submit.prevent="submit">
                <Card>
                    <CardHeader>
                        <CardTitle>Editar Utilizador</CardTitle>
                        <CardDescription>Atualize os dados do utilizador.</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="name">Nome</Label>
                            <Input id="name" v-model="form.name" placeholder="Nome completo"
                                :class="{ 'border-red-500': form.errors.name }" />
                            <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="email">Email</Label>
                            <Input id="email" type="email" v-model="form.email" placeholder="email@exemplo.com"
                                :class="{ 'border-red-500': form.errors.email }" />
                            <p v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</p>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-end gap-2">
                        <Button variant="outline" type="button" @click="$inertia.visit('/users')">Cancelar</Button>
                        <Button type="submit" :disabled="form.processing">Gravar Alterações</Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
