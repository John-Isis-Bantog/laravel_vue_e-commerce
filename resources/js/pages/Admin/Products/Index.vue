<script lang="ts" setup>
import Alert from '@/components/ui/alert/Alert.vue';
import AlertDescription from '@/components/ui/alert/AlertDescription.vue';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import productRoute from '@/routes/product';
import { BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';



interface Product {
    id: number,
    name: string,
    image: string | null,
    is_active: boolean,
    description: string,
    price: number
}


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Product Index Page',
        href: productRoute.index().url,
    },
];

const props = defineProps<{
    products: Product[];
}>()
function deleteProduct($id: number) {
    router.delete(productRoute.destroy($id));
}

const search = ref('');

watch(search, (Newvalue) => {
    router.get(productRoute.index(), { search: Newvalue }, { preserveState: true, replace: true })
})
</script>

<template>

    <Head title="Product Index" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Alert class=" mx-auto w-1/2" v-if="$page.props.flash?.success || $page.props.flash?.error">
            <AlertTitle>Info</AlertTitle>
            <AlertDescription>
                {{ $page.props.flash.success }}
                {{ $page.props.flash.error }}
            </AlertDescription>
        </Alert>
        <div class="flex justify-end">
            <div class="">
                <Link :href="productRoute.create().url"><Button>Add Product</Button></Link>
            </div>

        </div>
        <div class="flex w-1/2 mx-auto">
            <Input type="text" v-model="search"></Input>
            <Link :href="productRoute.index()"><Button>Clear</Button></Link>
        </div>
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>ID</TableHead>
                    <TableHead>Title</TableHead>
                    <TableHead>Description</TableHead>
                    <TableHead>Image</TableHead>
                    <TableHead>Active</TableHead>
                    <TableHead>Price</TableHead>
                    <TableHead>Action</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="product in props.products" :key="product.id">
                    <TableCell>{{ product.id }}</TableCell>
                    <TableCell>{{ product.name }}</TableCell>
                    <TableCell>{{ product.description }}</TableCell>
                    <TableCell><img :src="product.image" v-if="product.image" alt=""><span v-else><img
                                src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                                alt=""></span></TableCell>
                    <TableCell>{{ product.is_active ? 'Yes' : 'No' }}</TableCell>
                    <TableCell>{{ product.price }}</TableCell>

                    <TableCell>
                        <Link :href="productRoute.edit(product.id)"><Button variant="primary">Edit</Button></Link>
                        <Button variant="destructive" @click="deleteProduct(product.id)">Delete</Button>
                    </TableCell>

                </TableRow>
            </TableBody>
        </Table>
    </AppLayout>
</template>