<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoute from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, router, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: adminRoute.create().url,
    },
];
interface Admin {
    id: number,
    name: string,
    email: string
}

const props = defineProps<{
    admin: Admin;
}>();
const form = useForm({
    id: props.admin.id,
    name: props.admin.name,
    email: props.admin.email
})
function updateUser($id: number) {
    form.name
    form.email
    form.put(adminRoute.update($id).url)
}

</script>

<template>

    <Head title="Admin Edit" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Edit Page</h1>
        <Form class="w-1/2 mx-auto space-y-2" @submit.prevent="updateUser(form.id)">
            <Label for="name">name</Label>
            <Input type="text" v-model="form.name" name="name" placeholder="Enter Admin Name"></Input>
            <div class="" v-if="form.errors.name">{{ form.errors.name }}</div>
            <Label for="adminEmail">Email</Label>
            <Input type="email" v-model="form.email" name="email" placeholder="Enter Admin Email"></Input>
            <div class="" v-if="form.errors.email">{{ form.errors.email }}</div>
            <div class="flex justify-center">
                <Button type="submit">Submit</Button>
            </div>

        </Form>
    </AppLayout>
</template>