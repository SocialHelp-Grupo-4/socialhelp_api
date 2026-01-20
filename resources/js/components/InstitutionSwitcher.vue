<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { usePage, router } from '@inertiajs/vue3';
import { ChevronsUpDown, Building2, Plus, Check } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage();
const { isMobile, state } = useSidebar();

const institutions = computed(() => page.props.auth.institutions || []);
const currentInstitution = computed(() => page.props.auth.current_institution);

function switchInstitution(id: number) {
    router.post(route('institution.select.store'), {
        institution_id: id
    }, {
        preserveScroll: true
    });
}
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton size="lg"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                        <div
                            class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
                            <img v-if="currentInstitution?.logo" :src="currentInstitution.logo"
                                class="size-8 rounded-lg" />
                            <Building2 v-else class="size-4" />
                        </div>
                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ currentInstitution?.name || 'Selecione Instituição'
                                }}</span>
                            <span class="truncate text-xs">{{ currentInstitution?.category?.name || 'SocialHelp'
                                }}</span>
                        </div>
                        <ChevronsUpDown class="ml-auto" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                    :side="isMobile ? 'bottom' : 'right'" align="end" :side-offset="4">
                    <DropdownMenuLabel class="text-xs text-muted-foreground">
                        Instituições
                    </DropdownMenuLabel>
                    <DropdownMenuItem v-for="team in institutions" :key="team.name" @click="switchInstitution(team.id)"
                        class="gap-2 p-2">
                        <div class="flex size-6 items-center justify-center rounded-sm border">
                            <img v-if="team.logo" :src="team.logo" class="size-6 rounded-sm" />
                            <Building2 v-else class="size-4 shrink-0" />
                        </div>
                        {{ team.name }}
                        <Check v-if="currentInstitution?.id === team.id" class="ml-auto size-4" />
                    </DropdownMenuItem>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem class="gap-2 p-2">
                        <div class="flex size-6 items-center justify-center rounded-md border bg-background">
                            <Plus class="size-4" />
                        </div>
                        <div class="font-medium text-muted-foreground">Adicionar Instituição</div>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
