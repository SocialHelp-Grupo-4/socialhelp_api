<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
    family: {
        id: number;
        location_id: number;
        user_id: number;
    };
    locations: { id: number, name: string }[];
    users: { id: number, name: string }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Famílias',
        href: '/family',
    },
    {
        title: 'Editar',
        href: `/family/${props.family.id}/edit`,
    },
]

const form = useForm({
    location_id: String(props.family.location_id),
    user_id: String(props.family.user_id),
})

function submit() {
    form.put(`/family/${props.family.id}`)
}
</script>

<template>

    <Head title="Editar Família" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6 max-w-2xl mx-auto w-full">
            <form @submit.prevent="submit">
                <Card>
                    <CardHeader>
                        <CardTitle>Editar Família</CardTitle>
                        <CardDescription>Atualize os dados da família.</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label>Localização</Label>
                            <Select v-model="form.location_id">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecione uma localização" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="location in locations" :key="location.id"
                                        :value="String(location.id)">
                                        {{ location.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="form.errors.location_id" class="text-sm text-red-500">{{ form.errors.location_id }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label>Responsável (Usuário)</Label>
                            <Select v-model="form.user_id">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecione um responsável" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="user in users" :key="user.id" :value="String(user.id)">
                                        {{ user.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="form.errors.user_id" class="text-sm text-red-500">{{ form.errors.user_id }}</p>
                        </div>

                    </CardContent>
                    <CardFooter class="flex justify-end gap-2">
                        <Button variant="outline" type="button" @click="$inertia.visit('/family')">Cancelar</Button>
                        <Button type="submit" :disabled="form.processing">Gravar Alterações</Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
