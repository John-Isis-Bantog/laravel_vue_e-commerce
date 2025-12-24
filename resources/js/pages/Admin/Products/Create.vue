<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectGroup from '@/components/ui/select/SelectGroup.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import productRoute from '@/routes/product';
import { BreadcrumbItem } from '@/types';
import { Form, Head, Link, useForm } from '@inertiajs/vue3';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Product Create Page',
        href: productRoute.index().url,
    },
];

interface Product {
    name: string,
    description: string,
    price: number,
    is_active: string
    image: File | null,
}

const formData = useForm<Product>({
    name: '',
    description: '',
    price: 0,
    is_active: '0',
    image: null,

});
function submitProduct() {
    formData.post(productRoute.store().url);

}
function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    formData.image = target.files ? target.files[0] : null;
}

</script>

<template>

    <Head title="Product Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Link :href="productRoute.index()"><Button>Back</Button></Link>
        <div class="w-1/2 mx-auto">
            <Form @submit.prevent="submitProduct()" class="space-y-2">
                <Label for="name">Name</Label>
                <Input type="text" name="name" v-model="formData.name" placeholder="Name"></Input>
                <span class="text-red-500" v-if="formData.errors.name">{{ formData.errors.name }}</span>
                <Label for="description">Description</Label>
                <Textarea name="description" v-model="formData.description"></Textarea>
                <Label for="image">Image</Label>
                <Input type="file" name="image" v-on:change="handleFileChange"></Input>
                <span v-if="formData.errors.image" class="text-red-500">{{ formData.errors.image }}</span>
                <span class="text-red-500" v-if="formData.errors.description">{{ formData.errors.description }}</span>
                <Label for="price">Price</Label>
                <Input type="number" min="1" v-model="formData.price"></Input>

                <span class="text-red-500" v-if="formData.errors.price">{{ formData.errors.price }}</span>

                <Label for="is_active">Active</Label>
                <Select v-model="formData.is_active">
                    <SelectTrigger class="w-[180px]">
                        <SelectValue placeholder="is_Active?" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="1">
                                Yes
                            </SelectItem>
                            <SelectItem value="0">
                                No
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <span v-if="formData.errors.is_active">{{ formData.errors.price }}</span>
                <Button type="submit">Add Product</Button>
            </Form>
        </div>
    </AppLayout>
</template>