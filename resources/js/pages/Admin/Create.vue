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
        title: 'Admin Create Page',
        href: admin.create().url,
    },
];

const form = useForm({
    email: '',
    password: '',
    name: ''
})
function submitForm() {
    form.post(admin.store().url)
}
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Create Page</h1>
        <Form class="w-1/2 mx-auto space-y-2" @submit.prevent="submitForm">
            <Label for="adminName">Name</Label>
            <Input type="text" v-model="form.name" name="adminName" placeholder="Enter Admin Name"
                autocomplete="username"></Input>

            <Label for="adminEmail">Email</Label>
            <Input type="email" v-model="form.email" name="adminEmail" placeholder="Enter Admin Email"
                autocomplete="email"></Input>

            <Label for="password">Password</Label>
            <Input type="password" v-model="form.password" name="password" placeholder="Enter Password"
                autocomplete="current-password"></Input>


            <div class="flex justify-center">
                <Button type="submit">Submit</Button>
            </div>
        </Form>
    </AppLayout>
</template>