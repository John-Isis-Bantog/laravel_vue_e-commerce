<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import addressesRoute from '@/routes/addresses';
import { BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectGroup from '@/components/ui/select/SelectGroup.vue';
import SelectLabel from '@/components/ui/select/SelectLabel.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import Button from '@/components/ui/button/Button.vue';
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: addressesRoute.index().url,
    },
];


</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Profile settings" />
        <SettingsLayout>
            <Form class="space-y-2" @submit.prevent="">
                <div class="grid gap-4">

                    <div class="">
                        <Label for="recepient_name">Recepient Name</Label>
                        <Input type="text"></Input>
                        <span class="text-red-600">
                            {{ }}</span>
                    </div>
                    <div class="">
                        <Label for="phone">Phone Number</Label>
                        <Input type="tel" maxlength="11" inputmode="numeric" placeholder="09XXXXXXXXX" />
                        <span class="text-red-600">{{ }}</span>
                    </div>
                    <div class="flex space-x-4">
                        <div>
                            <Label for="province">Province</Label>

                            <Select required>
                                <SelectTrigger class="w-[200px]">
                                    <SelectValue placeholder="Select the Province" />
                                </SelectTrigger>

                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Provinces</SelectLabel>
                                        <!-- <SelectItem>
                                        </SelectItem> -->
                                    </SelectGroup>
                                </SelectContent>
                            </Select>

                            <span class="text-red-600">

                            </span>
                        </div>
                        <div>
                            <Label for="city">City</Label>

                            <Select required>
                                <SelectTrigger class="w-[150px]">
                                    <SelectValue placeholder="Select the City" />
                                </SelectTrigger>

                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Cities</SelectLabel>
                                        <!-- <SelectItem>
                                            {{ }}
                                        </SelectItem> -->
                                    </SelectGroup>
                                </SelectContent>
                            </Select>

                            <span class="text-red-600">
                                {{ }}
                            </span>
                        </div>

                    </div>
                    <div class="">
                        <Label for="address">Address</Label>
                        <Input type="text"></Input>
                        <span class="text-red-600">{{}}</span>
                    </div>

                    <div class="">
                        <Label for="postalCode">Postal Code</Label>
                        <Input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="10" />

                        <span class="text-red-600">{{ }}</span>
                    </div>
                </div>
                <Button type="submit">Submit</Button>

            </Form>
        </SettingsLayout>
    </AppLayout>
</template>