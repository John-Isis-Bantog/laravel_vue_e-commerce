<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: admin.edit().url,
    },
];
</script>

<template>

    <Head title="Admin Edit" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Edit Page</h1>
    </AppLayout>
</template>