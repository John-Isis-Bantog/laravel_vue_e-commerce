<script lang="ts" setup>
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoute from '@/routes/admin';
import { BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: adminRoute.create().url,
    },
];
</script>


<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Create Page</h1>
        <Form>
            <Label for="">Title</Label>
            <Input type="text" placeholder="Enter Title"></Input>
            <Label for="">Image</Label>
            <Input type="file" placeholder="Slect a file"></Input>
            <Label for="">Featured</Label>
            <Input type="checkbox"></Input>
            <Label for="">Active</Label>
            <Input type="checkbox"></Input>

        </Form>
    </AppLayout>
</template>