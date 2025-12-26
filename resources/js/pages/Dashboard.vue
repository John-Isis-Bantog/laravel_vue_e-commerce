<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import user from '@/routes/user';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

interface Product {
    id: number,
    name: string,
    description: string,
    image: string | null,
    price: number
}

const props = defineProps<{
    products: Product[]
}>()
</script>

<template>

    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <Link :href="user.show(product.id)" v-for="product in props.products" :key="product.id">
                <Card class="w-full max-w-sm">
                    <CardHeader>
                        <CardTitle class="text-center">{{ product.name }}</CardTitle>
                        <img v-if="product.image" :src="product.image" alt=""><span v-else>No Picture Available</span>
                        <CardDescription>
                            {{ product.description }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="text-center">
                        {{ product.price }}
                    </CardContent>
                </Card>
            </Link>
        </div>
    </AppLayout>
</template>
