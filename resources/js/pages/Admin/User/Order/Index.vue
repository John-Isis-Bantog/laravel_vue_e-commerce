<script lang="ts" setup>
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User',
        href: dashboard().url,
    },
];


interface Product {
    id: number
    name: string
    description: string
    image: string | null
    price: number
}
interface order_item {
    id: number
    quantity: number
    price: number
    product: Product
}
interface Order {
    id: number
    grand_total: number
    status: 'pending' | 'paid' | 'cancelled' | 'refunded'
    order_items: order_item[]
    createdAt: string
}

const props = defineProps<{
    orders: Order[];
}>() 
</script>

<template>

    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col">
            <Card v-for="order in props.orders" :key="order.id">
                <div class="" v-for="item in order.order_items" :key="item.id">

                    <!-- <Link :href="user.show(cartItem.id)"> -->
                    <CardHeader class="flex justify-between">
                        <div class="flex space-x-2">
                            <img class="max-w-3xs" alt=""><span><img class="max-w-3xs"
                                    src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                                    alt=""></span>
                            <div class="">
                                <CardTitle>{{ }}</CardTitle>
                                <CardDescription>
                                    {{ }}
                                </CardDescription>
                            </div>
                        </div>

                        <CardContent class="  ">
                            <div class="">₱{{ item.price }}</div>
                            <div class="space-2 ">
                                <div class=" ">
                                    <div class="">
                                        <Label>Quantity:{{ item.quantity }} </Label>
                                        <!-- <Input type="number" min="0" max="5"></Input> -->
                                    </div>
                                    <div class="">
                                        <!-- <Label>Status:{{ order.status }} </Label> -->
                                    </div>
                                </div>
                            </div>
                        </CardContent>


                    </CardHeader>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>