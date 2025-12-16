<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Field, Form, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';
const schema = yup.object({
    adminName: yup
        .string()
        .required('Name is required')
        .max(255),

    adminEmail: yup
        .string()
        .required('Email is required')
        .email('Email must be valid'),

    password: yup
        .string()
        .required('Password is required')
        .min(8, 'Password must be at least 8 characters')
        .matches(/[a-z]/, 'Must contain a lowercase letter')
        .matches(/[A-Z]/, 'Must contain an uppercase letter')
        .matches(/\d/, 'Must contain a number')
        .matches(/[^a-zA-Z0-9]/, 'Must contain a special character'),
});

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
function submitForm(values: any) {
    form.name = values.adminName;
    form.email = values.adminEmail;
    form.password = values.password;
    form.post(admin.store().url);
}

</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Create Page</h1>
        <Form :validation-schema="schema" class="w-1/2 mx-auto space-y-2" @submit="submitForm">
            <Label for="adminName">Name</Label>
            <Field type="text" name="adminName" placeholder="Enter Admin Name" autocomplete="username"></Field>
            <ErrorMessage class="text-red-500" name="adminName" />

            <Label for="adminEmail">Email</Label>
            <Field type="email" name="adminEmail" placeholder="Enter Admin Email" autocomplete="email"></Field>
            <ErrorMessage class="text-red-500" name="adminEmail" />

            <Label for="password">Password</Label>
            <Field type="password" name="password" placeholder="Enter Password" autocomplete="current-password"></Field>
            <ErrorMessage class="text-red-500" name="password" />


            <div class="flex justify-center">
                <Button type="submit">Submit</Button>
            </div>
        </Form>
    </AppLayout>
</template>