<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Chart, PieController, ArcElement } from 'chart.js';
import { ref, onMounted, computed, watch } from 'vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table/'
import Button from '@/components/ui/button/Button.vue';
import adminRoute from '@/routes/admin';
import Input from '@/components/ui/input/Input.vue';
import user from '@/routes/user';
import { dashboard } from '@/routes';
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

}
defineProps<{
    admins: Admin[];
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

        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-5 mx-auto my-2  ">
            <div class="bg-blue-500 p-4 flex justify-center hover:bg-blue-600 rounded-lg lg:w-md lg:min-h-50">
                <h1>Categories</h1>
                <span>4 Categories</span>
            </div>
            <div class="bg-red-500 p-4 flex justify-center hover:bg-red-600 rounded-lg lg:w-md lg:min-h-50">Items</div>
            <div class="bg-green-500 p-4 flex justify-center hover:bg-green-600 rounded-lg lg:w-md lg:min-h-50 ">
                <div class="">
                    <h1>Total Orders</h1>
                </div>
                <div class=""><span>4 Orders</span></div>

            </div>
            <div class="bg-cyan-500 p-4 flex justify-center hover:bg-cyan-600 rounded-lg lg:w-md lg:min-h-50">
                <h1>Revenue</h1>
                <span>$120</span>
            </div>
        </div>
        <div class="">
            <div class="flex justify-between max-w-3/4 mx-auto">
                <div class="flex">
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
                            <TableCell>
                                <Link :href="adminRoute.edit(admin.id)"> <Button variant="primary">Edit</Button>
                                </Link>
                                <Button variant="destructive" @click="removeAdmin(admin.id)">Delete</Button>
                            </TableCell>

                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
