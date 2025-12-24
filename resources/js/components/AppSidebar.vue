<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';

import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import admin from '@/routes/admin';
import category from '@/routes/category';
import product from '@/routes/product';
import user from '@/routes/user';

const mainNavItems: NavItem[] = [
    {
        title: 'user.index',
        href: user.index(),
        icon: LayoutGrid,
    },
    {
        title: 'Admin Dashboard',
        href: admin.index(),
        icon: LayoutGrid,
    },
    {
        title: 'Category Index',
        href: category.index(),
        icon: LayoutGrid,
    },
    {
        title: 'Product Index',
        href: product.index(),
        icon: LayoutGrid,
    },
    // {
    //     title: 'Admin Create',
    //     href: admin.create(),
    //     icon: LayoutGrid,
    // },
    // {
    //     title: 'Admin Create',
    //     href: admin.edit(),
    //     icon: LayoutGrid,
    // },
    // {
    //     title: 'Admin Create',
    //     href: admin.show(),
    //     icon: LayoutGrid,
    // },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },

];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="user.index()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
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
