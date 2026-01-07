<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps<{
  categoria: {
    id: number
    nome: string
  }
}>()

const form = useForm({
  nome: props.categoria.nome,
})

function submit() {
  form.put(`/categorias-instituicao/${props.categoria.id}`)
}
</script>

<template>
  <Head title="Editar Categoria" />

  <AppLayout>
    <form @submit.prevent="submit" class="p-4 space-y-4">
      <input v-model="form.nome" class="input" />

      <button class="btn btn-primary">
        Atualizar
      </button>
    </form>
  </AppLayout>
</template>
