<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Checkbox } from '@/components/ui/checkbox'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
    institutions: { id: number, name: string }[];
    problemAreas: { id: number, name: string }[];
   
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Projectos',
        href: '/project',
    },
    {
        title: 'Criar',
        href: '/project/create',
    },
]

const form = useForm({
    name: '',
    objectives: '',
    start_date: '',
    end_date: '',
    institution_id: '',
    problem_areas: [] as number[],
})

function submit() {
    form.post('/project')
}
</script>

<template>

    <Head title="Novo Projecto" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6 max-w-4xl mx-auto w-full">
            <form @submit.prevent="submit">
                <Card>
                    <CardHeader>
                        <CardTitle>Criar Novo Projecto</CardTitle>
                        <CardDescription>Defina os detalhes do novo projecto social.</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="name">Nome do Projecto</Label>
                                <Input id="name" v-model="form.name" placeholder="Ex: Campanha de vacinação"
                                    :class="{ 'border-red-500': form.errors.name }" />
                                <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
                            </div>
                            <div class="space-y-2">
                                <Label>Instituição Responsável</Label>
                                <Select v-model="form.institution_id">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Selecione uma instituição" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="institution in institutions" :key="institution.id"
                                            :value="String(institution.id)">
                                            {{ institution.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <p v-if="form.errors.institution_id" class="text-sm text-red-500">{{
                                    form.errors.institution_id }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <Label for="objectives">Objectivos</Label>
                            <textarea id="objectives" v-model="form.objectives"
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="Descreva os objectivos do projecto..."></textarea>
                            <p v-if="form.errors.objectives" class="text-sm text-red-500">{{ form.errors.objectives }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <Label for="start_date">Data de Início</Label>
                                <Input id="start_date" type="date" v-model="form.start_date"
                                    :class="{ 'border-red-500': form.errors.start_date }" />
                                <p v-if="form.errors.start_date" class="text-sm text-red-500">{{ form.errors.start_date
                                    }}</p>
                            </div>
                            <div class="space-y-2">
                                <Label for="end_date">Data de Fim</Label>
                                <Input id="end_date" type="date" v-model="form.end_date"
                                    :class="{ 'border-red-500': form.errors.end_date }" />
                                <p v-if="form.errors.end_date" class="text-sm text-red-500">{{ form.errors.end_date }}
                                </p>
                            </div>
                            
                        </div>

                        <div class="space-y-2">
                            <Label>Áreas de Problema</Label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 border p-4 rounded-md">
                                <div v-for="area in problemAreas" :key="area.id" class="flex items-center space-x-2">
                                    <Checkbox :id="`area-${area.id}`" :checked="form.problem_areas.includes(area.id)"
                                        @update:checked="(checked) => {
                                            if (checked) form.problem_areas.push(area.id);
                                            else form.problem_areas = form.problem_areas.filter(id => id !== area.id);
                                        }" />
                                    <Label :for="`area-${area.id}`">{{ area.name }}</Label>
                                </div>
                            </div>
                            <p v-if="form.errors.problem_areas" class="text-sm text-red-500">{{
                                form.errors.problem_areas }}</p>
                        </div>

                    </CardContent>
                    <CardFooter class="flex justify-end gap-2">
                        <Button variant="outline" type="button" @click="$inertia.visit('/project')">Cancelar</Button>
                        <Button type="submit" :disabled="form.processing">Criar Projecto</Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
