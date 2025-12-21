<script lang="ts" setup>
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
import { Head } from '@inertiajs/vue3';
import { Form } from 'vee-validate';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Category Index Page',
        href: productRoute.index().url,
    },
];
</script>

<template>

    <Head title="Category Create" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Form>
            <Label for="name">Name</Label>
            <Input type="text"></Input>

            <Label for="image">Image</Label>
            <Input type="file"></Input>

            <Label for="active">Active</Label>
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
        </Form>
    </AppLayout>
</template>