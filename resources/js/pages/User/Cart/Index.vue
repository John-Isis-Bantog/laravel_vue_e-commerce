<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: user.index().url,
    },
];
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            <Card class="w-full max-w-sm">
                <CardHeader>

                    <img src="" alt=""><span><img
                            src="https://hsaubfbdbzpjgwazahvz.supabase.co/storage/v1/object/public/laravel_vue_e_commerce_bucket/public/image_not_available.jpg"
                            alt=""></span>
                    <CardTitle>{{ }}</CardTitle>
                    <CardDescription>
                        {{ }}
                    </CardDescription>
                </CardHeader>
                <CardContent class="text-center">
                    ₱{{ }}
                </CardContent>
                <CardFooter>
                    <Button>Edit</Button>
                    <Button>Delete</Button>
                </CardFooter>
            </Card>

        </div>
    </AppLayout>
</template>