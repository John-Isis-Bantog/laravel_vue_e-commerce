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
import { Form, Head, Link } from '@inertiajs/vue3';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Product Create Page',
        href: productRoute.index().url,
    },
];
</script>

<template>

    <Head title="Product Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Link :href="productRoute.index()"><Button>Back</Button></Link>
        <div class="w-1/2 mx-auto">
            <Form>
                <Label for="name">Name</Label>
                <Input type="text" name="name" placeholder="Name"></Input>

                <Label for="description">Description</Label>
                <Textarea name="description"></Textarea>

                <Label for="price">Price</Label>
                <Input type="number" min="1"></Input>

                <Select>
                    <SelectTrigger class="w-[180px]">
                        <SelectValue placeholder="Active?" />
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
                <Button type="submit">Add Product</Button>
            </Form>
        </div>
    </AppLayout>
</template>