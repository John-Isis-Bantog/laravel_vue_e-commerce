<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Single Page',
        href: admin.show().url,
    },
];
</script>

<template>

    <Head title="Admin Show" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Show Page</h1>
    </AppLayout>
</template>