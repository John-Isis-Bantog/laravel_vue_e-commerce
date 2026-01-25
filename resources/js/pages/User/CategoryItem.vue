<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import products from '@/routes/products';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: products.index().url,
    },
];

interface Product {
    id: number,
    name: string,
    description: string,
    image: string | null,
    price: number,

}
const props = defineProps<{
    products: Product[]
}>()
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="" v-for="product in props.products">
            {{ product.name }}
            {{ product.price }}
        </div>
    </AppLayout>
</template>