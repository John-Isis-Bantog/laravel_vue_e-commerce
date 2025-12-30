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
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { changeQuantity } from '@/routes';
import cart from '@/routes/cart';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';
import { Minus, Plus, Proportions } from 'lucide-vue-next';
import { reactive, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: user.index().url,
    },
];

interface CartItem {
    id: number,
    product_id: number,
    quantity: number,
    is_selected: boolean,
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
const localCartItems = reactive(
    props.cartItems.map(item => ({ ...item }))
)
function minusQuantity(id: number) {
    const item = localCartItems.find(i => i.id === id)
    if (!item) return
    if (item.quantity > 1) {
        item.quantity--
    }
}
function addQuantity(id: number) {
    const item = localCartItems.find(i => i.id === id)
    if (!item) return
    item.quantity++
}

const totalItem = computed(() => {
    return localCartItems.filter(item => item.is_selected).reduce((sum, item) => sum + item.quantity, 0)
});
const totalPrice = computed(() => {
    return localCartItems.filter(item => item.is_selected).reduce((sum, item) => sum + Number(item.product.price) * item.quantity, 0)
});


function selectedItem(id: number) {
    const item = localCartItems.find(item => item.id === id)
    if (item) {
        item.is_selected = !item.is_selected
    }
}
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Dashboard</h1>
        <div class="flex w-1/2 mx-auto gap-2">
            <Input type="search"></Input>
            <Link :href="cart.index()"> <Button>Clear</Button></Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            <Card v-for="cartItem in localCartItems" class="w-full max-w-sm" :key="cartItem.id">
                <!-- <Link :href="user.show(cartItem.id)"> -->
                <CardHeader>
                    <Checkbox v-model="cartItem.is_selected"></Checkbox>
                    <img v-if="cartItem.product.image" :src="cartItem.product.image" alt=""><span v-else><img
                            src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                            alt=""></span>
                    <CardTitle>{{ cartItem.product.name }}</CardTitle>
                    <CardDescription>
                        {{ cartItem.product.description }}
                    </CardDescription>
                </CardHeader>
                <CardContent class="text-center flex justify-between">
                    <div class="">₱{{ cartItem.product.price }}</div>
                    <div class="flex gap-2 justify-around">
                        <div class="">
                            <Minus @click="minusQuantity(cartItem.id)" />
                        </div>
                        <div class="flex w-15">
                            <Input type="number" v-model="cartItem.quantity"></Input>
                        </div>

                        <div class="">
                            <Plus @click="addQuantity(cartItem.id)" />
                        </div>
                    </div>

                </CardContent>
                <CardFooter class="flex justify-center">
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

            <div class="flex gap-2 items-center">
                <h1>Subtotal: ${{ totalPrice }}</h1>
                <Button>Check Out({{ totalItem }})</Button>
            </div>
        </div>
    </AppLayout>
</template>