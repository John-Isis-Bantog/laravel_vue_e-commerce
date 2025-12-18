<script lang="ts" setup>

import AppLayout from '@/layouts/AppLayout.vue';
import categoryRoute from '@/routes/category';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: categoryRoute.index().url,
    },
];
</script>


<template>

    <Head title="Category Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Category Page</h1>
        <h1>hello from categories</h1>
    </AppLayout>
</template>