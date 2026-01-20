<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { edit } from '@/routes/profile';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Form } from 'vee-validate';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import Button from '@/components/ui/button/Button.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: edit().url,
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Profile settings" />
        <SettingsLayout>
            <Form class="space-y-2">
                <div class="">
                    <Label for="phone">Phone Number</Label>
                    <Input type="text"></Input>
                </div>
                <div class="">
                    <Label for="city">City</Label>
                    <Input type="text"></Input>
                </div>
                <div class="">
                    <Label for="address">Address</Label>
                    <Input type="text"></Input>
                </div>
                <div class="">
                    <Label for="province">Province</Label>
                    <Input type="text"></Input>
                </div>
                <div class="">
                    <Label for="postalCode">Postal Code</Label>
                    <Input type="text"></Input>
                </div>
                <div class="">
                    <Button>Submit</Button>
                </div>
            </Form>
        </SettingsLayout>
    </AppLayout>

</template>