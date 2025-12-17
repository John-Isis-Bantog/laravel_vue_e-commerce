<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: admin.create().url,
    },
];
interface Admin {
    name: string,
    email: string
}

const props = defineProps<{
    admin: Admin;
}>();
const form = useForm({
    name: props.admin.name,
    email: props.admin.email
})
</script>

<template>

    <Head title="Admin Edit" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Edit Page</h1>
        <Form class="w-1/2 mx-auto space-y-2" @submit.prevent>
            <Label for="name">name</Label>
            <Input type="text" v-model="form.name" name="name" placeholder="Enter Admin Name"></Input>

            <Label for="adminEmail">Email</Label>
            <Input type="email" v-model="form.email" name="adminEmail" placeholder="Enter Admin Email"></Input>
            <Label for=""></Label>
            <div class="flex justify-center">
                <Button type="submit">Submit</Button>
            </div>

        </Form>
    </AppLayout>
</template>