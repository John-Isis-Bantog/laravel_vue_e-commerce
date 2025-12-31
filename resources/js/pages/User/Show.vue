<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import cart from '@/routes/cart';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Form, Head, Link, useForm } from '@inertiajs/vue3';

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
    image: string,
    quantity: number
}
interface cartForm {
    id: number,
    quantity: number
}
const props = defineProps<{
    product: Product;
}>()
const form = useForm<cartForm>({
    id: props.product.id,
    quantity: 1
});


function addToCart() {
    // console.log(form.quantity)
    form.post(cart.store().url)
}
</script>
<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Link :href="dashboard()"><Button>Back</Button></Link>
        <div class="flex justify-center w-full">


            <Card class="min-w-2xl">
                <CardHeader>
                    <img v-if="props.product.image" :src="props.product.image" alt=""><span v-else><img
                            src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                            alt=""></span>
                    <CardTitle>{{ props.product.name }}</CardTitle>
                    <CardDescription>
                        {{ props.product.description }}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    ₱{{ props.product.price }}
                    <Label for="quantity">quantity</Label>
                    <Input type="number" min="1" v-model="form.quantity" max="5"></Input>
                </CardContent>
                <CardFooter class="flex justify-center space-x-2">
                    <Button type="submit" @click="addToCart">Add to Cart</Button>
                    <Link> <Button type="submit">Buy</Button></Link>
                </CardFooter>
            </Card>
        </div>
    </AppLayout>
</template>