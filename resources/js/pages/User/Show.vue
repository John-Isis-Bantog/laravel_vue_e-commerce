<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import user from '@/routes/user';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: user.index().url,
    },
];
</script>

<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Form class="mx-auto w-1/2 space-y-2">
            <Label for="name">Name</Label>
            <Input type="text"></Input>

            <Label for="descriptioon">Description</Label>
            <Input type="text"></Input>

            <Label for="price">Price</Label>
            <Input type="number" min="0"></Input>
            <div class="flex justify-center">
                <Button type="submit">Submit</Button>
            </div>
        </Form>
    </AppLayout>
</template>