<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: user.index().url,
    },
];

interface Product {
    name: string,
    description: string,
    price: number,
    image: string
}
const props = defineProps<{
    product: Product;
}>()
const form = useForm<Product>({
    name: props.product.name,
    description: props.product.description,
    image: props.product.image,
    price: props.product.price,
});
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="text-center flex justify-center">
            <img v-if="form.image" :src="form.image" alt=""><span v-else>No Image Available</span>
        </div>
        <Form class="mx-auto w-1/2 space-y-2">
            <Label for="name">Name</Label>
            <Input type="text" v-model="form.name"></Input>

            <Label for="description">Description</Label>
            <Input type="text" v-model="form.description"></Input>

            <Label for="price">Price</Label>
            <Input type="number" min="0" v-model="form.price"></Input>
            <div class="flex justify-center">
                <Button type="submit">Add to Cart</Button>
                <Button type="submit">Buy</Button>
            </div>
        </Form>
    </AppLayout>
</template>