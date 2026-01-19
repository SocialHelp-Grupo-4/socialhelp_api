<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps<{
    socioeconomicDataType: {
        id: number;
        name: string;
        description: string;
    }
}>();

const form = useForm({
  name: props.socioeconomicDataType.name,
  description: props.socioeconomicDataType.description,
})

function submit() {
  form.put(`/socioeconomic_data_type/${props.socioeconomicDataType.id}`)
}
</script>

<template>
  <Head title="Editar Tipo de Dado" />

  <AppLayout>
     <div class="p-4 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Editar Tipo de Dado</h1>
        <form @submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <input
                v-model="form.name"
                class="input w-full border rounded p-2"
                placeholder="Nome da categoria"
            />
             <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
        </div>

         <div>
            <label class="block text-sm font-medium mb-1">Descrição</label>
            <textarea
                v-model="form.description"
                class="input w-full border rounded p-2"
                placeholder="Descrição"
                rows="3"
            ></textarea>
             <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</div>
        </div>

        <button class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded" :disabled="form.processing">
            Atualizar
        </button>
        </form>
    </div>
  </AppLayout>
</template>
