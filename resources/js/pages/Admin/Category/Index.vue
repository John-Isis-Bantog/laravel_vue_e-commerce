<script lang="ts" setup>

import Button from '@/components/ui/button/Button.vue';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import categoryRoute from '@/routes/category';
import { BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Category Index Page',
        href: categoryRoute.index().url,
    },
];

interface Category {
    id: number,
    title: string,
    image: string | null,
    is_active: boolean,
    is_featured: boolean
}

const props = defineProps<{
    category: Category[]
}>()

function deleteCategory(id: number) {

    router.delete(categoryRoute.destroy(id).url)
}
</script>


<template>

    <Head title="Category Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Category Page</h1>
        <div class="flex justify-between">
            <div class="">title</div>
            <div class="">
                <Link :href="categoryRoute.create()"><Button>Add Product</Button></Link>
            </div>
        </div>
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>ID</TableHead>
                    <TableHead>Title</TableHead>
                    <TableHead>Image</TableHead>
                    <TableHead>Featured</TableHead>
                    <TableHead>Active</TableHead>
                    <TableHead>Action</TableHead>

                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="category in props.category" :key="category.id">
                    <TableCell>{{ category.id }}</TableCell>
                    <TableCell>{{ category.title }}</TableCell>
                    <TableCell>
                        <img v-if="category.image" :src="category.image" alt="Category image"
                            class="h-16 w-16 object-cover rounded" />
                        <span v-else>N/A</span>
                    </TableCell>

                    <TableCell>{{ category.is_featured }}</TableCell>
                    <TableCell>{{ category.is_active }}</TableCell>
                    <TableCell>
                        <Link :href="categoryRoute.edit(category.id)"> <Button variant="primary">Edit</Button></Link>
                        <Button variant="destructive" @click="deleteCategory(category.id)">Delete</Button>
                    </TableCell>

                </TableRow>
            </TableBody>
        </Table>
    </AppLayout>
</template>