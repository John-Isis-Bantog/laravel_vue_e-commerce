<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import admin from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ErrorMessage, Field, Form } from 'vee-validate';
import * as yup from 'yup';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: admin.create().url,
    },
];
const schema = yup.object({
    email: yup.string().required().email(),
    name: yup.string().required(),
    password: yup.string().required().min(8).matches(/[a-z]/, 'Must contain a lowercase letter').matches(/[A-Z]/, 'Must contain an uppercase letter').matches(/\d/, 'Must contain a number').matches(/[^a-zA-Z0-9]/, 'Must contain a special character'),
});
const form = useForm({
    email: '',
    password: '',
    name: ''
})
function submitForm(values: any) {

    form.name = values.name;
    form.email = values.email;
    form.password = values.password;
    form.post(admin.store().url);


}

</script>


<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Create Page</h1>
        <Form :validation-schema="schema" class="w-1/2 mx-auto space-y-2" @submit="submitForm">
            <Label for="name">Name</Label>
            <Field type="text" name="name" :validate-on-input="true" placeholder="Enter Admin Name" autocomplete="name">
            </Field>
            <ErrorMessage class="text-red-500" name="name" />
            <p v-if="form.errors.name">{{ form.errors.name }}</p>
            <Label for="email">Email</Label>
            <Field type="email" name="email" :validate-on-input="true" placeholder="Enter Admin Email"
                autocomplete="email"></Field>
            <p v-if="form.errors.email">{{ form.errors.email }}</p>
            <ErrorMessage class="text-red-500" name="email" />
            <Label for="password">Password</Label>
            <Field type="password" :validate-on-input="true" name="password" placeholder="Enter Password"
                autocomplete="current-password">
            </Field>
            <p v-if="form.errors.password">{{ form.errors.password }}</p>
            <ErrorMessage class="text-red-500" name="password" />
            <div class="flex justify-center">
                <Button type="submit">Submit</Button>
            </div>
        </Form>
    </AppLayout>
</template>