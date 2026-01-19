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
        title: 'Utilizadores',
        href: '/users',
    },
    {
        title: 'Criar',
        href: '/users/create',
    },
]

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

function submit() {
    form.post('/users')
}
</script>

<template>

    <Head title="Novo Utilizador" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6 max-w-2xl mx-auto w-full">
            <form @submit.prevent="submit">
                <Card>
                    <CardHeader>
                        <CardTitle>Criar Novo Utilizador</CardTitle>
                        <CardDescription>Preencha os dados abaixo para registar um novo utilizador no sistema.
                        </CardDescription>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="password">Senha</Label>
                                <Input id="password" type="password" v-model="form.password" placeholder="********"
                                    :class="{ 'border-red-500': form.errors.password }" />
                                <p v-if="form.errors.password" class="text-sm text-red-500">{{ form.errors.password }}
                                </p>
                            </div>
                            <div class="space-y-2">
                                <Label for="password_confirmation">Confirmar Senha</Label>
                                <Input id="password_confirmation" type="password" v-model="form.password_confirmation"
                                    placeholder="********" />
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-end gap-2">
                        <Button variant="outline" type="button" @click="$inertia.visit('/users')">Cancelar</Button>
                        <Button type="submit" :disabled="form.processing">Criar Utilizador</Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
