<script lang="ts" setup>
import Alert from '@/components/ui/alert/Alert.vue';
import AlertDescription from '@/components/ui/alert/AlertDescription.vue';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
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
import { toggleIsSelected, updateQuantity } from '@/routes';
import cart from '@/routes/cart';
import checkout from '@/routes/checkout';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from '@vue/reactivity';
import { Minus, Plus } from 'lucide-vue-next';
import { reactive } from 'vue';

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

const checkoutError = ref('');
function decrementQuantity(id: number) {
    const item = localCartItems.find(i => i.id === id)
    if (!item) return
    if (item.quantity > 1) {
        item.quantity--;
        router.put(updateQuantity(id).url, {
            quantity: item.quantity,
        })
    }
}
function incrementQuantity(id: number) {
    const item = localCartItems.find(i => i.id === id)
    if (!item || item.quantity === 5) {
        return
    }
    item.quantity++
    router.put(updateQuantity(id).url, { quantity: item.quantity })
}
const itemFilter = computed(() => {
    return localCartItems.filter(item => item.is_selected)
});
const totalItem = computed(() => {
    return itemFilter.value.reduce((sum, item) => sum + item.quantity, 0)
});
const totalPrice = computed(() => {
    return itemFilter.value.reduce((sum, item) => sum + Number(item.product.price) * item.quantity, 0)
});

function deleteItemCart(id: number) {
    router.delete(cart.destroy(id), {
        onSuccess: () => {
            const index = localCartItems.findIndex(item => item.id === id)
            if (index !== -1) {
                localCartItems.splice(index, 1);
            }
            console.log('Cart Item Deleted Successfully!' + id);
        },
        onError: (errors) => {
            console.log(errors);
        },
    }
    )
}

function toggleSelection(item: CartItem, value: boolean) {
    item.is_selected = value;
    router.put(toggleIsSelected(item.id).url, {
        is_selected: value
    }, {
        preserveScroll: true,
        onError: () => {
            item.is_selected = !value;
        }
    })
}

function goToCheckout() {
    if (totalItem.value > 0) {
        router.get(checkout.index().url)
    } else {
        checkoutError.value = 'Please Select a Product Before Checkout';
    }
}
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Cart</h1>
        <Alert class=" mx-auto w-1/2 top-5 sticky z-50" v-if="checkoutError">
            <AlertTitle>Info</AlertTitle>
            <AlertDescription>
                <h1>{{ checkoutError }}</h1>
            </AlertDescription>
        </Alert>

        <div class="flex w-1/2 mx-auto space-x-2">
            <Input type="search"></Input>
            <Link :href="cart.index()"> <Button>Clear</Button></Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            <Card v-for="cartItem in localCartItems" class="w-full max-w-sm" :key="cartItem.id">
                <!-- <Link :href="user.show(cartItem.id)"> -->
                <CardHeader>
                    <Checkbox :model-value="cartItem.is_selected"
                        @update:model-value="value => toggleSelection(cartItem, value)">
                    </Checkbox>
                    <img v-if="cartItem.product.image" :src="cartItem.product.image" alt=""><span v-else><img
                            src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                            alt=""></span>
                    <CardTitle>{{ cartItem.product.name }}</CardTitle>
                    <CardDescription>
                        {{ cartItem.product.description }}
                    </CardDescription>
                </CardHeader>
                <CardContent class="text-center flex justify-between">
                    <div class="">${{ cartItem.product.price }}</div>
                    <div class="flex space-x-2 justify-around">
                        <div class="">
                            <Minus @click="decrementQuantity(cartItem.id)" />
                        </div>
                        <div class="flex w-15">
                            <Input type="number" min="0" max="5" v-model="cartItem.quantity"></Input>
                        </div>

                        <div class="">
                            <Plus @click="incrementQuantity(cartItem.id)" />
                        </div>
                    </div>

                </CardContent>
                <CardFooter class="flex justify-center space-x-2">
                    <Button variant="destructive" @click="deleteItemCart(cartItem.id)">Delete</Button>
                    <Button variant="primary">Buy</Button>
                </CardFooter>
                <!-- </Link> -->
            </Card>
        </div>
        <div class="bottom-0 flex justify-between sticky bg-gray-800 p-3 items-center">
            <div class="flex  items-start gap-3">
                <Checkbox id="toggle" />
                <Label for="toggle">All</Label>
            </div>

            <div class="flex space-x-2 items-center">
                <h1>Subtotal: ${{ totalPrice }}</h1>
                <Button variant="primary" @click="goToCheckout">Check Out({{ totalItem }})</Button>
            </div>
        </div>
    </AppLayout>
</template>