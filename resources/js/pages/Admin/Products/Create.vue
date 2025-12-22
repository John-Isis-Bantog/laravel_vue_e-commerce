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
}

const formData = useForm({
    name: '',
    description: '',
    price: '',
    is_active: '0'

});
function submitProduct() {
    formData.post(productRoute.store().url);
    console.log(formData.is_active);
}

</script>

<template>

    <Head title="Product Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Link :href="productRoute.index()"><Button>Back</Button></Link>
        <div class="w-1/2 mx-auto">
            <Form @submit.prevent="submitProduct()">
                <Label for="name">Name</Label>
                <Input type="text" name="name" v-model="formData.name" placeholder="Name"></Input>
                <span class="text-red-500" v-if="formData.errors.name">{{ formData.errors.name }}</span>

                <Label for="description">Description</Label>
                <Textarea name="description" v-model="formData.description"></Textarea>
                <span class="text-red-500" v-if="formData.errors.description">{{ formData.errors.description }}</span>
                <Label for="price">Price</Label>
                <Input type="number" min="1" v-model="formData.price"></Input>
                <Input type="file"></Input>
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