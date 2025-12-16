<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: admin.edit().url,
    },
];
</script>

<template>

    <Head title="Admin Edit" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Edit Page</h1>
        <Form class="w-1/2 mx-auto space-y-2" @submit.prevent>
            <Label for="adminEmail">Email</Label>
            <Input type="email" name="adminEmail" placeholder="Enter Admin Email"></Input>

            <Label for="password">Password</Label>
            <Input type="password" name="password" placeholder="Enter Password"></Input>

            <Label for=""></Label>
            <div class="flex justify-center">
                <Button type="submit">Submit</Button>
            </div>

        </Form>
    </AppLayout>
</template>