<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Instituições',
        href: '/institution',
    },
    {
        title: 'Criar',
        href: '/institution/create',
    },
]

const form = useForm({
    name: '',
    nif: '',
    email: '',
})

function submit() {
    form.post('/institution')
}
</script>

<template>

    <Head title="Nova Instituição" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6 max-w-2xl mx-auto w-full">
            <form @submit.prevent="submit">
                <Card>
                    <CardHeader>
                        <CardTitle>Criar Nova Instituição</CardTitle>
                        <CardDescription>Registe uma nova instituição no sistema.</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="name">Nome</Label>
                            <Input id="name" v-model="form.name" placeholder="Nome da instituição"
                                :class="{ 'border-red-500': form.errors.name }" />
                            <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="nif">NIF</Label>
                            <Input id="nif" v-model="form.nif" placeholder="Número de Identificação Fiscal"
                                :class="{ 'border-red-500': form.errors.nif }" />
                            <p v-if="form.errors.nif" class="text-sm text-red-500">{{ form.errors.nif }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="email">Email</Label>
                            <Input id="email" type="email" v-model="form.email" placeholder="email@instituicao.com"
                                :class="{ 'border-red-500': form.errors.email }" />
                            <p v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</p>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-end gap-2">
                        <Button variant="outline" type="button"
                            @click="$inertia.visit('/institution')">Cancelar</Button>
                        <Button type="submit" :disabled="form.processing">Criar Instituição</Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
