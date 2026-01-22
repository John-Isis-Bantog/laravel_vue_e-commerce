<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import addressesRoute from '@/routes/addresses';
import { BreadcrumbItem } from '@/types';
import { Form, Head, useForm } from '@inertiajs/vue3';
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
import { onMounted, ref, watch } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: addressesRoute.index().url,
    },
];

interface Address {
    id: number,
    recipient_name: string,
    phone: string,
    address_line_1: string,
    city: string,
    postal_code: string,
    address_line_2: string,
    province: string
}
const props = defineProps<{
    address: Address
}>()
const form = useForm({
    recipient_name: props.address.recipient_name,
    phone: props.address.phone,
    address_line_1: props.address.address_line_1,
    city: props.address.city,
    postal_code: props.address.postal_code,
    address_line_2: props.address.address_line_2,
    province: props.address.province,
})
const provinces = ref<any[]>([])
const cities = ref<any[]>([])
let prefilled = false // flag to prevent watch from clearing city
onMounted(async () => {
    // fetch provinces
    const res = await fetch('https://psgc.cloud/api/provinces')
    provinces.value = await res.json()

    // Prefill province code based on saved province name
    const matchedProvince = provinces.value.find(p => p.name === props.address.province)
    if (matchedProvince) {
        form.province = matchedProvince.code

        // fetch cities for that province
        const resCities = await fetch(
            `https://psgc.cloud/api/provinces/${matchedProvince.code}/cities-municipalities`
        )
        cities.value = await resCities.json()

        // prefill city code
        const matchedCity = cities.value.find(c => c.name === props.address.city)
        if (matchedCity) {
            form.city = matchedCity.code
        }

        prefilled = true // done prefill
    }
})

// Watch province changes to fetch cities
watch(() => form.province, async (provinceCode) => {
    if (!provinceCode) return

    const res = await fetch(
        `https://psgc.cloud/api/provinces/${provinceCode}/cities-municipalities`
    )
    cities.value = await res.json()

    // Reset city only if it's NOT prefilled
    if (!prefilled) {
        form.city = ''
    }

    prefilled = false // reset after first prefill
})



function getProvinceName(code: string) {
    return provinces.value.find(p => p.code === code)?.name ?? '';
}

function getCityName(code: string) {
    return cities.value.find(p => p.code === code)?.name ?? '';
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Profile settings" />
        <SettingsLayout>
            <Form class="space-y-2" @submit.prevent>
                <div class="grid gap-4">
                    <div class="">
                        <Label for="recepient_name">Recepient Name</Label>
                        <Input type="text" v-model="form.recipient_name"></Input>
                        <span class="text-red-600">
                            {{ form.errors.recipient_name }}</span>
                    </div>
                    <div class="">
                        <Label for="phone">Phone Number</Label>
                        <Input type="tel" maxlength="11" v-model="form.phone" inputmode="numeric"
                            placeholder="09XXXXXXXXX" />
                        <span class="text-red-600">{{ form.errors.phone }}</span>
                    </div>
                    <div class="flex space-x-4">
                        <div>
                            <Label for="province">Province</Label>
                            <Select required v-model="form.province">
                                <SelectTrigger class="w-[200px]">
                                    <SelectValue placeholder="Select the Province" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Provinces</SelectLabel>
                                        <SelectItem v-for="province in provinces" :key="province.code"
                                            :value="province.code">
                                            {{ province.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>

                            <span class="text-red-600">
                                {{ form.errors.province }}
                            </span>
                        </div>
                        <div>
                            <Label for="city">City</Label>

                            <Select required v-model="form.city" :disabled="!form.province">
                                <SelectTrigger class="w-[150px]">
                                    <SelectValue placeholder="Select the City" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Cities</SelectLabel>
                                        <SelectItem v-for="city in cities" :key="city.code" :value="city.code">
                                            {{ city.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>

                            <span class="text-red-600">
                                {{ form.errors.city }}
                            </span>
                        </div>
                    </div>
                    <div class="">
                        <Label for="address">Address</Label>
                        <Input type="text" v-model="form.address_line_1"></Input>
                        <span class="text-red-600">{{ form.errors.address_line_1 }}</span>
                    </div>
                    <div class="">
                        <Label for="postalCode">Postal Code</Label>
                        <Input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="10"
                            v-model="form.postal_code" />
                        <span class="text-red-600">{{ }}</span>
                    </div>
                </div>
                <Button type="submit">Submit</Button>

            </Form>
        </SettingsLayout>
    </AppLayout>
</template>