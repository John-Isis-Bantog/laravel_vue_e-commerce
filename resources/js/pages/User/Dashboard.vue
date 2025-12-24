<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import user from '@/routes/user';

import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: user.index().url,
    },
];
</script>

<template>

    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Dashboard</h1>
    </AppLayout>
</template>
