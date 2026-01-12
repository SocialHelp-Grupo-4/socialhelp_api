<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
})

function submit() {
  form.post('/institution/category')
}
</script>

<template>
  <Head title="Nova Categoria" />

  <AppLayout>
    <form @submit.prevent="submit" class="p-4 space-y-4">
      <input
        v-model="form.name"
        class="input"
        placeholder="Nome da categoria"
      />

      <button class="btn btn-primary" :disabled="form.processing">
        Guardar
      </button>
    </form>
  </AppLayout>
</template>
