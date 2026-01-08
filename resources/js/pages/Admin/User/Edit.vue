<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import products from '@/routes/products';
import userRoute from '@/routes/Users';
import { BreadcrumbItem } from '@/types';
import { Form, Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: products.index().url,
    },
];

interface User {
    id: number,
    name: string,
    email: string,
}
const props = defineProps<{
    user: User
}>()

const form = useForm({
    name: props.user.name,
    email: props.user.email
})


</script>


<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Link :href="userRoute.index.url()"><Button variant="outline">Back</Button></Link>
        <Form class="space-y-2 w-1/2 mx-auto">
            <div class="">
                <Label for="name">Name</Label>
                <Input type="text"></Input>
            </div>

            <div class="">
                <Label for="email">Email</Label>
                <Input type="email"></Input>
            </div>
            <div class="flex justify-center">
                <Button variant="primary">Submit</Button>
            </div>

        </Form>
    </AppLayout>
</template>