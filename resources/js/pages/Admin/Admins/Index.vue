<script setup lang="ts">
// UI
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table/'
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import Button from '@/components/ui/button/Button.vue';
// Route

import { dashboard } from '@/routes';
import adminRoute from '@/routes/admin';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
// Vue
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User',
        href: dashboard().url,
    },
];


// const ctxPie = ref<HTMLCanvasElement | null>(null);
// Chart.register(PieController, ArcElement)
// onMounted(() => {

//     new Chart(ctxPie.value!.getContext('2d')!, {
//         type: 'pie',
//         data: {
//             labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
//             datasets: [{
//                 data: [12, 19, 3, 5, 2],
//                 backgroundColor: [
//                     'rgba(255, 99, 132, 0.7)',
//                     'rgba(54, 162, 235, 0.7)',
//                     'rgba(255, 206, 86, 0.7)',
//                     'rgba(75, 192, 192, 0.7)',
//                     'rgba(153, 102, 255, 0.7)'
//                 ],
//                 borderColor: '#fff',
//                 borderWidth: 2
//             }]
//         }
//     });
// })

interface Admin {
    id: number;
    name: string;
    email: string;
    categories: string,
    allProducts: string,
    activeProducts: string
}
const props = defineProps<{
    admins: Admin[];
    categories: number[];
    allProducts: number[];
    activeProducts: number[];
}>();

function removeAdmin(id: number) {
    if (!confirm('Are you sure you want to delete this user?')) return;
    router.delete(adminRoute.destroy(id))
}

const search = ref('');

watch(search, (newValue) => {
    router.get(adminRoute.index().url, { search: newValue }, { preserveState: true, replace: true })
})
</script>

<template>

    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Dashboard</h1>
        <!-- <div class="w-1/2 h-1/2 flex justify-center  mx-auto">
            <canvas id="pieChart" ref="ctxPie"></canvas>
        </div> -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 mb-2 mx-3">
            <Card class="w-full max-w-sm">
                <CardHeader>
                    <CardTitle class="text-center">Categories</CardTitle>
                </CardHeader>
                <CardContent class="text-center">
                    <span>{{ props.categories }} Categories</span>
                </CardContent>
            </Card>

            <Card class="w-full max-w-sm">
                <CardHeader>
                    <CardTitle class="text-center">Products</CardTitle>
                </CardHeader>
                <CardContent class="text-center flex flex-col">
                    <span>Active Products {{ props.activeProducts }} </span>
                    <span>All Products{{ props.allProducts }} </span>
                </CardContent>
            </Card>

            <Card class="w-full max-w-sm">
                <CardHeader>
                    <CardTitle class="text-center">Total Orders</CardTitle>
                </CardHeader>
                <CardContent class="text-center">
                    <span>4 Orders</span>
                </CardContent>
            </Card>

            <Card class="w-full max-w-sm">
                <CardHeader>
                    <CardTitle class="text-center">Revenue</CardTitle>
                </CardHeader>
                <CardContent class="text-center">
                    <span>$120</span>
                </CardContent>
            </Card>
        </div>
        <div class="">
            <div class="flex justify-between max-w-3/4 mx-auto">
                <div class="flex gap-2">
                    <Input type="search" v-model="search" placeholder="Search by Name or Email"></Input>
                    <Link :href="adminRoute.index().url"><Button variant="primary">Clear</Button></Link>
                </div>

                <Link :href="adminRoute.create()"><Button>Add admin</Button></Link>
            </div>
            <div class="w-3/4 mx-auto">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="admin in admins" :key="admin.id">
                            <TableCell>{{ admin.id }}</TableCell>
                            <TableCell>{{ admin.name }}</TableCell>
                            <TableCell>{{ admin.email }}</TableCell>
                            <TableCell class="gap-2 flex">
                                <Link :href="adminRoute.edit(admin.id)"> <Button variant="primary">Edit</Button></Link>
                                <Button variant="destructive" @click="removeAdmin(admin.id)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
