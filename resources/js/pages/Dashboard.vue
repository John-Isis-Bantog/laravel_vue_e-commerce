<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import {
    Card,
    CardAction,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'


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
    image: File | null,
    price: number
}


</script>

<template>

    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <Link>
                <Card class="w-full max-w-sm">
                    <CardHeader>
                        <CardTitle>Title</CardTitle>
                        <CardDescription>
                            Description
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        price
                    </CardContent>
                </Card>
            </Link>
            <Link>
                <Card class="w-full max-w-sm">
                    <CardHeader>
                        <CardTitle>Title</CardTitle>
                        <CardDescription>
                            Description
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        price
                    </CardContent>
                </Card>
            </Link>
            <Link>
                <Card class="w-full max-w-sm">
                    <CardHeader>
                        <CardTitle>Title</CardTitle>
                        <CardDescription>
                            Description
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        price
                    </CardContent>
                </Card>
            </Link>
        </div>
    </AppLayout>
</template>
