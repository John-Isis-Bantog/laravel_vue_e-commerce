<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Chart, PieController, ArcElement } from 'chart.js';
import { ref, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const ctxPie = ref<HTMLCanvasElement | null>(null);
Chart.register(PieController, ArcElement)
onMounted(() => {

    new Chart(ctxPie.value!.getContext('2d')!, {
        type: 'pie',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
            datasets: [{
                data: [12, 19, 3, 5, 2],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        }
    });
})


</script>

<template>

    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="w-1/2 h-1/2 flex justify-center  mx-auto">
            <canvas id="pieChart" ref="ctxPie"></canvas>
        </div>

        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-5 mx-auto my-2">
            <div class="bg-blue-500 p-4 flex justify-center hover:bg-blue-600 rounded-lg">Categories</div>
            <div class="bg-red-500 p-4 flex justify-center hover:bg-red-600 rounded-lg">Items</div>
            <div class="bg-green-500 p-4 flex justify-center hover:bg-green-600 rounded-lg">Total Orders</div>
            <div class="bg-cyan-500 p-4 flex justify-center hover:bg-cyan-600 rounded-lg">Revenue $102</div>
        </div>
    </AppLayout>
</template>
