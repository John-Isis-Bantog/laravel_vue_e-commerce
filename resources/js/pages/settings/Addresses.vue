<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { edit } from '@/routes/profile';
import { BreadcrumbItem } from '@/types';
import { Form, Head, useForm } from '@inertiajs/vue3';
import SettingsLayout from '@/layouts/settings/Layout.vue';

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

import { ref, onMounted, watch } from 'vue'
import addresses from '@/routes/addresses';

const provinces = ref<any[]>([])
const cities = ref<any[]>([])

interface Address {
    recipient_name: string,
    phone: number | null,
    address_line_1: string,
    city: string,
    postal_code: number | null,
    address_line_2: string,
    province: string
}
const form = useForm<Address>({
    recipient_name: '',
    phone: null,
    address_line_1: '',
    city: '',
    postal_code: null,
    address_line_2: '',
    province: ''
})

onMounted(async () => {
    const res = await fetch('https://psgc.cloud/api/provinces')
    provinces.value = await res.json()
})

watch(() => form.province, async (provinceCode) => {
    if (!provinceCode) return

    const res = await fetch(
        `https://psgc.cloud/api/provinces/${provinceCode}/cities-municipalities`
    )
    cities.value = await res.json()

    form.city = ''
})


function submitForm() {
    console.log(form.recipient_name, form.phone, form.address_line_1, form.city, form.postal_code, form.address_line_1)
    form.post(addresses.store().url)
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Profile settings" />
        <SettingsLayout>
            <Form class="space-y-2" @submit.prevent="submitForm()">
                <div class="">
                    <Label for="recepient_name">Recepient Name</Label>
                    <Input type="text" v-model="form.recipient_name"></Input>
                    <span v-if="form.errors.recipient_name" class="text-red-600">{{ form.errors.recipient_name }}</span>
                </div>
                <div class="">
                    <Label for="phone">Phone Number</Label>
                    <Input type="number" :model-value="form.phone ?? ''"
                        @update:model-value="value => form.phone = value === '' ? null : Number(value)" />
                    <span v-if="form.errors.phone" class="text-red-600">{{ form.errors.phone }}</span>
                </div>
                <div class="flex space-x-4">
                    <div class="">
                        <Label for="province">Province</Label>
                        <select v-model="form.province">
                            <option value="">Select province</option>
                            <option v-for="province in provinces" :key="province.code" :value="province.code">
                                {{ province.name }}
                            </option>
                        </select>
                        <span v-if="form.errors.province" class="text-red-600">{{ form.errors.province
                        }}</span>
                    </div>
                    <div class="">
                        <Label for="city">City</Label>
                        <select v-model="form.city" :disabled="!form.province">
                            <option value="">Select city</option>
                            <option v-for="city in cities" :key="city.code" :value="city.code">
                                {{ city.name }}
                            </option>
                            <span v-if="form.errors.city" class="text-red-600">{{ form.errors.city }}</span>
                        </select>
                    </div>
                </div>
                <div class="">
                    <Label for="address">Address</Label>
                    <Input type="text" v-model="form.address_line_1"></Input>
                    <span v-if="form.errors.address_line_1" class="text-red-600">{{ form.errors.address_line_1 }}</span>
                </div>

                <div class="">
                    <Label for="postalCode">Postal Code</Label>
                    <Input type="number" :model-value="form.postal_code ?? ''"
                        @update:model-value="value => form.postal_code = value === '' ? null : Number(value)" />
                    <span v-if="form.errors.postal_code" class="text-red-600">{{ form.errors.postal_code }}</span>
                </div>
                <div class="">
                    <Button>Submit</Button>
                </div>
            </Form>

            <div class="">

            </div>
        </SettingsLayout>
    </AppLayout>

</template>