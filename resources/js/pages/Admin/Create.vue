<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: admin.create().url,
    },
];
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Create Page</h1>
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