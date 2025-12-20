<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoute from '@/routes/admin';
import categoryRoute from '@/routes/category';
import { BreadcrumbItem } from '@/types';
import { Form, Head, useForm } from '@inertiajs/vue3';

import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select/'
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Edit Page',
        href: adminRoute.create().url,
    },
];

interface Category {
    id: number,
    title: string,
    image: string | null,
    is_featured: number,
    is_active: number
}
const props = defineProps<{
    category: Category;
}>()

const form = useForm<Category>({
    id: props.category.id,
    title: props.category.title,
    image: null,
    is_featured: props.category.is_featured,
    is_active: props.category.is_active,
});
function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    form.image = target.files ? target.files[0] : null;
}
function submitForm(id: number) {

    form.post(categoryRoute.update(id).url)
    console.log(form.is_active, form.is_featured)
}

</script>


<template>


    <Head title="Category Edit Page" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="text-center">Category edit Page</h1>
        <div class="" v-if="form.is_featured">{{ form.is_featured }}</div>
        <Form class="w-1/2 mx-auto space-y-3" @submit.prevent="submitForm(props.category.id)">
            <Label for="">Title</Label>
            <Input type="text" name="title" v-model="form.title" placeholder="Enter Title"></Input>
            <div class="" v-if="form.errors.title">{{ form.errors.title }}</div>
            <Label for="">Image</Label>
            <img v-if="category.image" :src="category.image" alt="">
            <Input type="file" name="image" v-on:change="handleFileChange" placeholder="Select a file"></Input>
            <div class="" v-if="form.errors.image">{{ form.errors.image }}</div>
            <div class="flex gap-5 ">
                <Label for="">Featured</Label>
                <Select v-model="form.is_featured">
                    <SelectTrigger class="w-[180px]">
                        <SelectValue>
                            {{ form.is_featured === 1 ? 'Yes' : 'No' }}
                        </SelectValue>
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="1">Yes</SelectItem>
                            <SelectItem value="0">No</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>


                <div class="" v-if="form.errors.is_featured">{{ form.errors.is_featured }}</div>
                <Label for="">Active</Label>
                <Select v-model="form.is_active">
                    <SelectTrigger class="w-[180px]">
                        <SelectValue>
                            {{ form.is_active === 1 ? 'Yes' : 'No' }}
                        </SelectValue>
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="1">Yes</SelectItem>
                            <SelectItem value="0">No</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>


                <div class="" v-if="form.errors.is_active">{{ form.errors.is_active }}</div>
            </div>
            <Button type="submit" class="">Submit</Button>
        </Form>


    </AppLayout>
</template>