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
  category: {
    id: number
    name: string
  }
}>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Categorias de Instituição',
    href: '/institution/category',
  },
  {
    title: 'Editar',
    href: `/institution/category/${props.category.id}/edit`,
  },
]

const form = useForm({
  name: props.category.name,
})

function submit() {
  form.put(`/institution/category/${props.category.id}`)
}
</script>

<template>

  <Head title="Editar Categoria" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6 max-w-2xl mx-auto w-full">
      <form @submit.prevent="submit">
        <Card>
          <CardHeader>
            <CardTitle>Editar Categoria</CardTitle>
            <CardDescription>Atualize o nome da categoria.</CardDescription>
          </CardHeader>
          <CardContent class="space-y-4">
            <div class="space-y-2">
              <Label for="name">Nome</Label>
              <Input id="name" v-model="form.name" placeholder="Ex: Hospital, Escola, etc."
                :class="{ 'border-red-500': form.errors.name }" />
              <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
            </div>
          </CardContent>
          <CardFooter class="flex justify-end gap-2">
            <Button variant="outline" type="button" @click="$inertia.visit('/institution/category')">Cancelar</Button>
            <Button type="submit" :disabled="form.processing">Gravar Alterações</Button>
          </CardFooter>
        </Card>
      </form>
    </div>
  </AppLayout>
</template>
