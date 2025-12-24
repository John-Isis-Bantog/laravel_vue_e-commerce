<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import categoryRoute from '@/routes/category';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Category Index Page',
        href: categoryRoute.index().url,
    },
];

</script>


<template>

    <Head title="Category Create" />
    <AppLayout :breadcrumbs="breadcrumbs"></AppLayout>
</template>