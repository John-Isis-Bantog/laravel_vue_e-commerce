<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { categoryProduct, dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import user from '@/routes/products';
import Button from '@/components/ui/button/Button.vue';
import { computed, ref } from 'vue';
import { MoveLeft, MoveRight } from 'lucide-vue-next';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

interface Product {
    id: number,
    name: string,
    description: string,
    image: string | null,
    price: number
}

interface Category {
    id: number
    title: string,
    image: string | null,
}

const props = defineProps<{
    products: Product[]
    categories: Category[]
}>()

const startIndex = 0
const seenCategories = ref(startIndex)
const visibleCategories = computed(() => {
    return props.categories.slice(seenCategories.value, seenCategories.value + 5)

})
const canGoNext = computed(() => {
    return seenCategories.value < props.categories.length - 5
})
</script>

<template>

    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex overflow-hidden gap-5 my-4 flex-nowrap relative">
            <div class="absolute top-1/3"><Button v-if="seenCategories > 0" @click="seenCategories--">
                    <MoveLeft />
                </Button>
            </div>
            <Link :href="categoryProduct(category.id).url" v-for="category in visibleCategories" :key="category.id"
                class="w-1/5">
                <Card class="w-full max-w-sm">
                    <CardHeader>
                        <img v-if="category.image" :src=category.image alt="">
                        <span v-else><img
                                src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                                alt=""></span>
                        <CardTitle class="text-center"> {{ category.title }}</CardTitle>
                    </CardHeader>
                </Card>
            </Link>
            <Button class="absolute top-1/3 right-0" v-if="canGoNext" @click="seenCategories++">
                <MoveRight />
            </Button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <Link :href="user.show(product.id)" v-for="product in props.products" :key="product.id">
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
