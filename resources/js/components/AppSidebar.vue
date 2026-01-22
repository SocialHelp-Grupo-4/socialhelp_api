<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import InstitutionSwitcher from '@/components/InstitutionSwitcher.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Folder,
    LayoutGrid,
    Users,
    Building2,
    MapPin,
    Heart,
    Briefcase,
    AlertCircle,
    Database,
    CheckCircle
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Utilizadores',
        href: '/users',
        icon: Users,
    },
    {
        title: 'Categorias de Instituição',
        href: '/institution/category',
        icon: Folder,
    },
    {
        title: 'Aprovações',
        href: '/admin/approvals',
        icon: CheckCircle,
    },
    {
        title: 'Instituições',
        href: '/institution',
        icon: Building2,
    },
    {
        title: 'Localizações',
        href: '/location',
        icon: MapPin,
    },
    {
        title: 'Familias',
        href: '/family',
        icon: Heart,
    },
    {
        title: 'Projectos',
        href: '/project',
        icon: Briefcase,
    },
    {
        title: 'Areas de Problema',
        href: '/problem_area',
        icon: AlertCircle,
    },
    {
        title: 'Tipos de Dados Socioeconomicos',
        href: '/socioeconomic_data_type',
        icon: Database,
    },
];

const footerNavItems: NavItem[] = [
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <InstitutionSwitcher />
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
