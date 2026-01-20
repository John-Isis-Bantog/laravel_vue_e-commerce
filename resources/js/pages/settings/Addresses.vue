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

import { ref, onMounted, watch } from 'vue'

const provinces = ref<any[]>([])
const cities = ref<any[]>([])

const selectedProvince = ref('')
const selectedCity = ref('')

onMounted(async () => {
    const res = await fetch('https://psgc.cloud/api/provinces')
    provinces.value = await res.json()
})

watch(selectedProvince, async (provinceCode) => {
    if (!provinceCode) return

    const res = await fetch(
        `https://psgc.cloud/api/provinces/${provinceCode}/cities-municipalities`
    )
    cities.value = await res.json()

    selectedCity.value = '' // reset city
})
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Profile settings" />
        <SettingsLayout>
            <Form class="space-y-2">
                <div class="">
                    <Label for="recepient_name">Recepient Name</Label>
                    <Input type="text"></Input>
                </div>
                <div class="">
                    <Label for="phone">Phone Number</Label>
                    <Input type="text"></Input>
                </div>
                <div class="">
                    <Label for="province">Province</Label>
                    <select v-model="selectedProvince">
                        <option value="">Select province</option>
                        <option v-for="province in provinces" :key="province.code" :value="province.code">
                            {{ province.name }}
                        </option>
                    </select>

                </div>
                <div class="">
                    <Label for="city">City</Label>
                    <select v-model="selectedCity" :disabled="!selectedProvince">
                        <option value="">Select city</option>
                        <option v-for="city in cities" :key="city.code" :value="city.code">
                            {{ city.name }}
                        </option>
                    </select>
                </div>
                <div class="">
                    <Label for="address">Address</Label>
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

            <div class="">

            </div>
        </SettingsLayout>
    </AppLayout>

</template>