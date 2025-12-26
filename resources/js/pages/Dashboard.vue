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
        <div v-for="product in props.products" :key="product.id"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <Link>
                <Card class="w-full max-w-sm">
                    <CardHeader>
                        <CardTitle>{{ product.name }}</CardTitle>
                        <CardDescription>
                            {{ product.description }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        {{ product.price }}
                    </CardContent>
                </Card>
            </Link>
        </div>
    </AppLayout>
</template>
