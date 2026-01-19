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
    location: {
        id: number
        name: string
        geolocation: string
    }
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Localizações',
        href: '/location',
    },
    {
        title: 'Editar',
        href: `/location/${props.location.id}/edit`,
    },
]

const form = useForm({
    name: props.location.name,
    geolocation: props.location.geolocation,
})

function submit() {
    form.put(`/location/${props.location.id}`)
}
</script>

<template>

    <Head title="Editar Localização" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6 max-w-2xl mx-auto w-full">
            <form @submit.prevent="submit">
                <Card>
                    <CardHeader>
                        <CardTitle>Editar Localização</CardTitle>
                        <CardDescription>Atualize os dados da localização.</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="name">Nome da Comunidade</Label>
                            <Input id="name" v-model="form.name" placeholder="Ex: Comunidade X"
                                :class="{ 'border-red-500': form.errors.name }" />
                            <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="geolocation">Geolocalização</Label>
                            <Input id="geolocation" v-model="form.geolocation" placeholder="Latitude, Longitude"
                                :class="{ 'border-red-500': form.errors.geolocation }" />
                            <p v-if="form.errors.geolocation" class="text-sm text-red-500">{{ form.errors.geolocation }}
                            </p>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-end gap-2">
                        <Button variant="outline" type="button" @click="$inertia.visit('/location')">Cancelar</Button>
                        <Button type="submit" :disabled="form.processing">Gravar Alterações</Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
