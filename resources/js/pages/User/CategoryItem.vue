<script lang="ts" setup>
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import products from '@/routes/products';
import userRoute from '@/routes/users';
import { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <Link :href="products.show(product.id)" v-for="product in props.products" :key="product.id">
                <Card class="w-full max-w-sm">
                    <CardHeader>
                        <img v-if="product.image" :src="product.image" alt=""><span v-else><img
                                src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                                alt=""></span>
                        <CardTitle>{{ product.name }}</CardTitle>
                        <!-- <CardDescription>
                            {{ product.description }}
                        </CardDescription> -->
                    </CardHeader>
                    <CardContent class="text-center">
                        ₱{{ product.price }}
                    </CardContent>
                </Card>
            </Link>
        </div>
    </AppLayout>
</template>