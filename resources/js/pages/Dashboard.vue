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
        <div class="my-4">
            <div class="flex overflow-hidden gap-5 flex-nowrap relative m-2">
                <div class="absolute top-1/3 hover:opacity-60 duration-500 ease-out"><Button v-if="seenCategories > 0"
                        @click="seenCategories--">
                        <MoveLeft />
                    </Button>
                </div>
                <Link :href="categoryProduct(category.id).url" v-for="category in visibleCategories" :key="category.id"
                    class="w-1/5">
                    <Card class="w-full max-w-sm">
                        <CardHeader class="space-y-3">
                            <div class="h-40 w-full overflow-hidden rounded-md">
                                <img :src="category.image
                                    ?? 'https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg'"
                                    class="h-full w-full object-cover" alt="" />
                            </div>

                            <CardTitle class="text-center">
                                {{ category.title }}
                            </CardTitle>
                        </CardHeader>
                    </Card>

                </Link>
                <Button class="absolute top-1/3 right-0 hover:opacity-60 duration-500 ease-out" v-if="canGoNext"
                    @click="seenCategories++">
                    <MoveRight />
                </Button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <Link v-for="product in props.products" :key="product.id" :href="user.show(product.id)">
                    <Card class="w-full max-w-sm h-full">
                        <CardHeader class="space-y-3">
                            <div class="h-48 w-full overflow-hidden rounded-md">
                                <img :src="product.image
                                    ?? 'https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg'"
                                    alt=""
                                    class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
                            </div>

                            <CardTitle class="line-clamp-2">
                                {{ product.name }}
                            </CardTitle>
                        </CardHeader>

                        <CardContent class="mt-auto text-center font-semibold">
                            ₱{{ product.price }}
                        </CardContent>
                    </Card>
                </Link>
            </div>

        </div>
    </AppLayout>
</template>
