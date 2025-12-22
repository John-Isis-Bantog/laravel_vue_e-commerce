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
import AppLayout from '@/layouts/AppLayout.vue';
import productRoute from '@/routes/product';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Form } from 'vee-validate';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Category Index Page',
        href: productRoute.index().url,
    },
];

interface Product {
    name: string,
    image: File | null,
    is_active: boolean,
}

const props = defineProps<{
    product: Product;
}>()

const form = useForm({
    name: props.product.name,
    image: props.product.image,
    is_active: props.product.is_active
});

</script>

<template>

    <Head title="Category Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-1/2 mx-auto">
            <Form class="space-y-3">
                <Label for="name">Name</Label>
                <Input type="text" v-model="form.name"></Input>

                <Label for="image">Image</Label>
                <Input type="file"></Input>

                <Label for="is_active">Active</Label>
                <Select>
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
                <Button type="submit">Submit</Button>
            </Form>
        </div>
    </AppLayout>
</template>