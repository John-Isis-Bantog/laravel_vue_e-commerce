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
import category from '@/routes/category';
import product from '@/routes/product';
import { dashboard } from '@/routes';
import adminRoute from '@/routes/admin';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
// Vue
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { CircleEllipsis, DollarSign, Package, ShoppingCart, User } from 'lucide-vue-next';
import Users from '@/routes/users';


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
    activeProducts: string,
    totalUsers: string,
    revenue: number,
    totalOrders: number
}
const props = defineProps<{
    admins: Admin[];
    categories: number[];
    allProducts: number[];
    activeProducts: number[];
    totalUsers: number[];
    revenue: number;
    totalOrders: number;
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
        <!-- <div class="w-1/2 h-1/2 flex justify-center  mx-auto">
            <canvas id="pieChart" ref="ctxPie"></canvas>
        </div> -->
        <div class="my-2">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3  mb-2 m-3 gap-5">
                <Link :href="category.index.url()">
                    <Card class="w-full max-w-sm h-44 flex flex-col justify-center">
                        <CardHeader class="space-y-2">
                            <div class="flex justify-center text-muted-foreground">
                                <CircleEllipsis class="h-8 w-8" />
                            </div>
                            <CardTitle class="text-center">
                                Categories
                            </CardTitle>
                        </CardHeader>

                        <CardContent class="text-center">
                            <span class="text-xl font-bold">
                                {{ props.categories }}
                            </span>

                        </CardContent>
                    </Card>


                </Link>

                <Link :href="product.index.url()">
                    <Link :href="product.index.url()">
                        <Card class="w-full max-w-sm h-44 flex flex-col justify-between">
                            <CardHeader class="space-y-2">
                                <div class="flex justify-center text-muted-foreground">
                                    <Package class="h-8 w-8" />
                                </div>
                                <CardTitle class="text-center">Products</CardTitle>
                            </CardHeader>

                            <CardContent class="text-center text-sm space-y-1">
                                <div>Active: <span class="font-semibold">{{ props.activeProducts }}</span></div>
                                <div>Total: <span class="font-semibold">{{ props.allProducts }}</span></div>
                            </CardContent>
                        </Card>
                    </Link>

                </Link>

                <Link>
                    <Card class="w-full max-w-sm h-44 flex flex-col justify-between">
                        <CardHeader class="space-y-2">
                            <div class="flex justify-center text-muted-foreground">
                                <ShoppingCart class="h-8 w-8" />
                            </div>
                            <CardTitle class="text-center">Total Orders</CardTitle>
                        </CardHeader>

                        <CardContent class="text-center text-lg font-semibold">
                            {{ props.totalOrders }}
                        </CardContent>
                    </Card>

                </Link>

                <Link>
                    <Card class="w-full max-w-sm h-44 flex flex-col justify-between">
                        <CardHeader class="space-y-2">
                            <div class="flex justify-center text-muted-foreground">
                                <DollarSign class="h-8 w-8" />
                            </div>
                            <CardTitle class="text-center">Revenue</CardTitle>
                        </CardHeader>

                        <CardContent class="text-center text-lg font-bold">
                            ₱{{ props.revenue }}
                        </CardContent>
                    </Card>

                </Link>

                <Link :href="Users.index.url()">
                    <Card class="w-full max-w-sm h-44 flex flex-col justify-between">
                        <CardHeader class="space-y-2">
                            <div class="flex justify-center text-muted-foreground">
                                <User class="h-8 w-8" />
                            </div>
                            <CardTitle class="text-center">Users</CardTitle>
                        </CardHeader>

                        <CardContent class="text-center text-lg font-semibold">
                            {{ props.totalUsers }}
                        </CardContent>
                    </Card>

                </Link>

                <Link :href="dashboard.url()">
                    <Card class="w-full max-w-sm h-44 flex-col flex justify-between">
                        <CardHeader>
                            <div class="flex justify-center">
                                <User />
                            </div>
                            <CardTitle class="text-center">Browse as the User </CardTitle>
                        </CardHeader>
                        <CardContent class="text-center">
                            <span>{{ props.totalUsers }} Total Users</span>
                        </CardContent>
                    </Card>
                </Link>
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
                                    <Link :href="adminRoute.edit(admin.id)"> <Button variant="primary">Edit</Button>
                                    </Link>
                                    <Button variant="destructive" @click="removeAdmin(admin.id)">Delete</Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
