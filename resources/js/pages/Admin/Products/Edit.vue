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
import { Form, Head, useForm } from '@inertiajs/vue3';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Category Index Page',
        href: productRoute.index().url,
    },
];

interface Product {
    id: number,
    name: string,
    description: string,
    price: number,
    image: File | null,
    is_active: number,
}

const props = defineProps<{
    product: Product;
}>()

const form = useForm({
    id: props.product.id,
    name: props.product.name,
    description: props.product.description,
    image: props.product.image,
    price: props.product.price,
    is_active: props.product.is_active
});

function updateProduct($id: number) {
    form.put(productRoute.update($id).url);
}
function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    form.image = target.files ? target.files[0] : null;
}
</script>

<template>

    <Head title="Category Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-1/2 mx-auto">
            <Form class="space-y-3" @submit.prevent="updateProduct(form.id)">
                <Label for="name">Name</Label>
                <Input type="text" v-model="form.name"></Input>
                <span v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</span>
                <img :src="form.image" v-if="form.image" alt=""><span v-else>No Image Uploaded</span>
                <Label for="image">Image</Label>
                <Input type="file" @change="handleFileChange"></Input>
                <span v-if="form.errors.image" class="text-red-500">{{ form.errors.image }}</span>
                <Label for="description">Description</Label>
                <Textarea v-model="form.description"></Textarea>
                <span v-if="form.errors.description" class="text-red-500">{{ form.errors.description }}</span>
                <Label for="price">Price</Label>
                <Input type="number" min="0" v-model="form.price"></Input>
                <span v-if="form.errors.price" class="text-red-500">{{ form.errors.price }}</span>
                <Label for="is_active">Active</Label>
                <Select v-model="form.is_active">
                    <SelectTrigger class="w-[180px]">
                        <SelectValue v-model="form.is_active">
                            {{ form.is_active ? 'Yes' : 'No' }}
                        </SelectValue>
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
                <span v-if="form.errors.is_active" class="text-red-500">{{ form.errors.is_active }}</span>
                <Button type="submit">Submit</Button>
            </Form>
        </div>
    </AppLayout>
</template>