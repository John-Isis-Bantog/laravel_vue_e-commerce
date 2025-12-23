<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
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



interface Product {
    id: number,
    name: string,
    image: File | null,
    is_active: boolean,
    description: string
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
</script>

<template>

    <Head title="Product Index" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex justify-end">
            <div class="">
                <Link :href="productRoute.create().url"><Button>Add Product</Button></Link>
            </div>

        </div>

        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>ID</TableHead>
                    <TableHead>Title</TableHead>
                    <TableHead>Image</TableHead>
                    <TableHead>Image</TableHead>
                    <TableHead>Description</TableHead>
                    <TableHead>Action</TableHead>

                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="product in products">
                    <TableCell>{{ product.id }}</TableCell>
                    <TableCell>{{ product.name }}</TableCell>
                    <TableCell><img :src="product.image" v-if="product.image" alt=""><span v-else>N/A</span></TableCell>
                    <TableCell>{{ product.is_active ? 'Yes' : 'No' }}</TableCell>
                    <TableCell>{{ product.description }}</TableCell>
                    <TableCell>
                        <Link :href="productRoute.edit(product.id)"><Button variant="primary">Edit</Button></Link>
                        <Button variant="destructive" @click="deleteProduct(product.id)">Delete</Button>
                    </TableCell>

                </TableRow>
            </TableBody>
        </Table>
    </AppLayout>
</template>