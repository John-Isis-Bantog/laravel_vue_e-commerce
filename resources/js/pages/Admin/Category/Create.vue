<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoute from '@/routes/admin';
import category from '@/routes/category';
import { BreadcrumbItem } from '@/types';
import { Form, Head, router, useForm } from '@inertiajs/vue3';
import { Checkbox } from '@/components/ui/checkbox'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Create Page',
        href: adminRoute.create().url,
    },
];

interface Category {
    title: string,
    image: File | null,
    is_featured: boolean,
    is_active: boolean
}

const form = useForm<Category>({
    title: '',
    image: null,
    is_featured: false,
    is_active: false,
});
function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    form.image = target.files ? target.files[0] : null;
}
function submitForm() {
    console.log(form.title, form.is_featured, form.is_active)
    form.post(category.store().url)
}


</script>


<template>

    <Head title="Admin Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Admin Create Page</h1>

        <Form class="w-1/2 mx-auto space-y-3" @submit.prevent="submitForm">
            <Label for="">Title</Label>
            <Input type="text" name="title" v-model="form.title" placeholder="Enter Title"></Input>
            <div class="" v-if="form.errors.title">{{ form.errors.title }}</div>
            <Label for="">Image</Label>
            <Input type="file" name="image" v-on:change="handleFileChange" placeholder="Select a file"></Input>
            <div class="" v-if="form.errors.image">{{ form.errors.image }}</div>
            <div class="flex">

                <Label for="">Featured</Label>
                <Checkbox name="is_featured" v-model="form.is_featured" :default-value="false" />
                <div class="" v-if="form.errors.is_featured">{{ form.errors.is_featured }}</div>
                <Label for="">Active</Label>
                <Checkbox name="is_active" v-model="form.is_active" :default-value="false" />
                <div class="" v-if="form.errors.is_active">{{ form.errors.is_active }}</div>
            </div>
            <Button type="submit" class="">Submit</Button>
        </Form>


    </AppLayout>
</template>