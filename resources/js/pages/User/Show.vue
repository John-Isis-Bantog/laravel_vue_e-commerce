<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: user.index().url,
    },
];

interface Product {
    id: number,
    name: string,
    description: string,
    price: number,
    image: string
}
const props = defineProps<{
    product: Product;
}>()
const form = useForm<Product>({
    id: props.product.id,
    name: props.product.name,
    description: props.product.description,
    image: props.product.image,
    price: props.product.price,
});
</script>
<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex justify-center w-full">
            <Card class="min-w-2xl">
                <CardHeader>
                    <img v-if="form.image" :src="form.image" alt=""><span v-else>No Picture Available</span>
                    <CardTitle class="text-center">{{ form.name }}</CardTitle>
                    <CardDescription>
                        {{ form.description }}
                    </CardDescription>
                </CardHeader>
                <CardContent class="text-center">
                    ₱{{ form.price }}
                </CardContent>
                <CardFooter class="flex justify-center space-x-2">

                    <Button type="submit">Add to Cart</Button>
                    <Link> <Button type="submit">Buy</Button></Link>

                </CardFooter>
            </Card>
        </div>
    </AppLayout>
</template>