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
import { Head, Link } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Category Index Page',
        href: categoryRoute.index().url,
    },
];
</script>


<template>

    <Head title="Category Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Category Page</h1>
        <div class="flex justify-between">
            <div class="">title</div>
            <div class=""><Button>Add Product</Button></div>
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
                <TableRow>
                    <TableCell>{{ }}</TableCell>
                    <TableCell>{{ }}</TableCell>
                    <TableCell>{{ }}</TableCell>
                    <TableCell>{{ }}</TableCell>
                    <TableCell>{{ }}</TableCell>
                    <TableCell>
                        <Link> <Button variant="primary">Edit</Button></Link>
                        <Button variant="destructive" @click="">Delete</Button>
                    </TableCell>

                </TableRow>
            </TableBody>
        </Table>
    </AppLayout>
</template>