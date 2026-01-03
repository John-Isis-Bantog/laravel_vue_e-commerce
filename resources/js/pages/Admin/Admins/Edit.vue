<script setup lang="ts">
// layout
import AppLayout from '@/layouts/AppLayout.vue';
// UI
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, Link, useForm } from '@inertiajs/vue3';
// route
import adminRoute from '@/routes/admin';

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
    name: props.admin.name,
    email: props.admin.email
})
function updateAdmin($id: number) {
    form.put(adminRoute.update($id).url)
}
</script>

<template>

    <Head title="Admin Edit" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Link :href="adminRoute.index()"><Button>Back</Button></Link>
        <h1 class="text-center">Admin Edit Page</h1>
        <Form class="w-1/2 mx-auto space-y-2" @submit.prevent="updateAdmin(admin.id)">
            <div class="">
                <Label for="name">name</Label>
                <Input type="text" v-model="form.name" name="name" placeholder="Enter Admin Name"></Input>
                <div class="text-red-500" v-if="form.errors.name">{{ form.errors.name }}</div>
            </div>

            <div class="">
                <Label for="adminEmail">Email</Label>
                <Input type="email" v-model="form.email" name="adminEmail" placeholder="Enter Admin Email"></Input>
                <div class="text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>

            <div class="flex justify-center">
                <Button variant="primary" type="submit">Submit</Button>
            </div>

        </Form>
    </AppLayout>
</template>