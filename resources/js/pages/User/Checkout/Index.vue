<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import cart from '@/routes/cart';
import products from '@/routes/products';
import { BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: products.index().url,
    },
];

interface SelectedItem {
    id: number,
    product_id: number,
    quantity: number,
    is_selected: boolean,
    totalPrice: number,
    product: {
        name: string,
        description: string,
        price: number,
        image: string
    },

}

const props = defineProps<{
    selectedItems: SelectedItem[]
    totalPrice: number
}>()
const goToStripe = () => {
    router.post(route('checkout.session'))
}
</script>


<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Link :href="cart.index.url()"><Button>Back</Button></Link>
        <div class="flex flex-col">
            <Card v-for="selectedItem in selectedItems" class=" " :key="selectedItem.id">
                <!-- <Link :href="user.show(cartItem.id)"> -->
                <CardHeader class="flex justify-between">
                    <div class="flex space-x-2">
                        <img v-if="selectedItem.product.image" :src="selectedItem.product.image" class="max-w-3xs"
                            alt=""><span v-else><img class="max-w-3xs"
                                src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                                alt=""></span>
                        <div class="">
                            <CardTitle>{{ selectedItem.product.name }}</CardTitle>
                            <CardDescription>
                                {{ selectedItem.product.description }}
                            </CardDescription>
                        </div>
                    </div>
                    <CardContent class="  ">
                        <div class="">${{ selectedItem.product.price }}</div>
                        <div class="space-2 ">
                            <div class="flex ">
                                <Label>Quantity: </Label>
                                <Input type="number" min="0" max="5" v-model="selectedItem.quantity"></Input>
                            </div>
                        </div>
                    </CardContent>
                </CardHeader>
            </Card>
        </div>
        <ul></ul>
        <div class="w-full">
            <h1>Select Payment Method</h1>
            <div class="">
                <div class="">
                    <Label>COD</Label>
                    <Input type="radio" name="payment_method"></Input>
                </div>
                <div class="">
                    <Label>Meetup</Label>
                    <Input type="radio" name="payment_method"></Input>
                </div>
                <div class="">
                    <Label>Credit Card</Label>
                    <Input type="radio" name="payment_method"></Input>
                </div>
            </div>
        </div>

        <ul></ul>
        <div class="">
            <h1>Order Detail</h1>
            <h1>Subtotal: ${{ props.totalPrice }}</h1>
        </div>

        <div class="bottom-0 flex justify-between sticky bg-gray-800 p-3 items-center">
            <div class="flex space-x-2 items-center">
                <Button @click="goToStripe">Pay with Card</Button>
            </div>
        </div>
    </AppLayout>
</template>