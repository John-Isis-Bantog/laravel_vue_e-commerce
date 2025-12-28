<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: user.index().url,
    },
];

interface CartItem {
    id: number,
    product_id: number,
    product: {
        name: string,
        description: string,
        price: number,
        image: string
    }

}

const props = defineProps<{
    cartItems: CartItem[]
}>()
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Dashboard</h1>
        <div class="flex w-1/2 mx-auto">
            <Input type="search"></Input>
            <Button>Clear</Button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            <Card v-for="cartItem in props.cartItems" class="w-full max-w-sm" :key="cartItem.id">
                <!-- <Link :href="user.show(cartItem.id)"> -->
                <CardHeader>
                    <Checkbox></Checkbox>
                    <img v-if="cartItem.product.image" :src="cartItem.product.image" alt=""><span v-else><img
                            src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                            alt=""></span>
                    <CardTitle>{{ cartItem.product.name }}</CardTitle>
                    <CardDescription>
                        {{ cartItem.product.description }}
                    </CardDescription>
                </CardHeader>
                <CardContent class="text-center ">
                    ₱{{ cartItem.product.price }}

                </CardContent>
                <CardFooter class="flex justify-center">
                    <Button>Edit</Button>
                    <Button>Delete</Button>
                </CardFooter>
                <!-- </Link> -->
            </Card>
        </div>
        <div class="bottom-0 flex justify-between sticky bg-gray-800 p-3 items-center">
            <div class="flex  items-start gap-3">
                <Checkbox id="toggle" />
                <Label for="toggle">All</Label>
            </div>

            <div class="">
                <h1>Checkout Total: $123</h1>
            </div>
        </div>
    </AppLayout>
</template>