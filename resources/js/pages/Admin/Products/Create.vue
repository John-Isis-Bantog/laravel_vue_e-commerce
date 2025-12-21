<script lang="ts" setup>
import productRoute from '@/routes/product';
import { BreadcrumbItem } from '@/types';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Category Index Page',
        href: productRoute.index().url,
    },
];
</script>

<template>

    <Head title="Category Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
    </AppLayout>
</template>