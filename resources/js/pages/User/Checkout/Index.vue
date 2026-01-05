<script lang="ts" setup>
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: user.index().url,
    },
];

interface SelectedItem {
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
    selectedItems: SelectedItem[]
}>()
</script>


<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card v-for="selectedItem in selectedItems" class="w-full max-w-sm" :key="selectedItem.id">
            <!-- <Link :href="user.show(cartItem.id)"> -->
            <CardHeader>

                <img v-if="selectedItem.product.image" :src="selectedItem.product.image" alt=""><span v-else><img
                        src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                        alt=""></span>
                <CardTitle>{{ selectedItem.product.name }}</CardTitle>
                <CardDescription>
                    {{ selectedItem.product.description }}
                </CardDescription>
            </CardHeader>
            <CardContent class="text-center flex justify-between">
                <div class="">${{ selectedItem.product.price }}</div>
                <div class="flex space-x-2 justify-around">
                    <div class="flex w-15">
                        <Input type="number" min="0" max="5" v-model="selectedItem.quantity"></Input>
                    </div>
                </div>

            </CardContent>


        </Card>
    </AppLayout>
</template>