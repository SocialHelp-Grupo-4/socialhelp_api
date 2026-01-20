<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Building2, Plus, LogOut } from 'lucide-vue-next';

defineProps<{
    institutions: Array<any>;
    current_institution_id: number | null;
}>();

const logout = () => {
    router.post(route('logout'));
};

const selectInstitution = (id: number) => {
    router.post(route('institution.select.store'), {
        institution_id: id
    });
};
</script>

<template>

    <Head title="Selecionar Instituição" />

    <div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Selecione uma Instituição
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ou <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500" @click.prevent="logout">sair da
                    conta</a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="space-y-4">
                    <button v-for="institution in institutions" :key="institution.id"
                        @click="selectInstitution(institution.id)"
                        class="w-full flex items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors group"
                        :class="{ 'ring-2 ring-indigo-500 border-indigo-500': current_institution_id === institution.id }">
                        <div
                            class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 group-hover:bg-indigo-200">
                            <img v-if="institution.logo" :src="institution.logo" class="h-10 w-10 rounded-full" />
                            <Building2 v-else class="h-6 w-6" />
                        </div>
                        <div class="ml-4 text-left">
                            <div class="text-sm font-medium text-gray-900">
                                {{ institution.name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ institution.category?.name || 'Instituição' }}
                            </div>
                        </div>
                    </button>

                    <div v-if="institutions.length === 0" class="text-center py-4 text-gray-500">
                        Você ainda não pertence a nenhuma instituição.
                    </div>

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">
                                Opções
                            </span>
                        </div>
                    </div>

                    <button
                        class="w-full flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <Plus class="mr-2 h-4 w-4" />
                        Criar Nova Instituição
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
