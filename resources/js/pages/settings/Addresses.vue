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
import addressesRoute from '@/routes/addresses';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectGroup from '@/components/ui/select/SelectGroup.vue';
import SelectLabel from '@/components/ui/select/SelectLabel.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';

const provinces = ref<any[]>([])
const cities = ref<any[]>([])

interface Address {
    id: number,
    recipient_name: string,
    phone: string,
    address_line_1: string,
    city: string,
    postal_code: number | null,
    address_line_2: string,
    province: string
}
type AddressForm = Omit<Address, 'id'>
const form = useForm<AddressForm>({
    recipient_name: '',
    phone: '09',
    address_line_1: '',
    city: '',
    postal_code: null,
    address_line_2: '',
    province: ''
})

const props = defineProps<{
    addresses: Address[]
}>()
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
function getProvinceName(code: string) {
    return provinces.value.find(p => p.code === code)?.name ?? '';
}

function getCityName(code: string) {
    return cities.value.find(p => p.code === code)?.name ?? '';
}

function submitForm() {
    form.province = getProvinceName(form.province)
    form.city = getCityName(form.city)
    form.post(addressesRoute.store().url)
}

function onPhoneInput(e: Event) {
    let value = (e.target as HTMLInputElement).value

    value = value.replace(/\D/g, '');

    if (!value.startsWith('09')) {
        value = value.slice(0, 11)
    }
    form.phone = value
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
                    <Input type="tel" v-model="form.phone" maxlength="11" inputmode="numeric" placeholder="09XXXXXXXXX"
                        @input="onPhoneInput" />
                    <span v-if="form.errors.phone" class="text-red-600">{{ form.errors.phone }}</span>
                </div>
                <div class="flex space-x-4">
                    <div>
                        <Label for="province">Province</Label>

                        <Select v-model="form.province" required>
                            <SelectTrigger class="w-[250px]">
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

                        <span v-if="form.errors.province" class="text-red-600">
                            {{ form.errors.province }}
                        </span>
                    </div>
                    <div>
                        <Label for="city">City</Label>

                        <Select v-model="form.city" :disabled="!form.province" required>
                            <SelectTrigger class="w-[250px]">
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

                        <span v-if="form.errors.city" class="text-red-600">
                            {{ form.errors.city }}
                        </span>
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
                <Card v-for="address in props.addresses" :key='address.id'>
                    <CardHeader class="flex">
                        <CardTitle>Name:{{ address.recipient_name }}</CardTitle>
                        <CardDescription>Phone Number:{{ address.phone }}</CardDescription>
                    </CardHeader>
                    <CardContent class="">
                        <div class="">
                            <p>City:{{ address.city }}</p>
                            <p>Province:{{ address.province }}</p>

                        </div>
                        <div class="">
                            <p>Address:{{ address.address_line_1 }}</p>
                            <p>Postal Code:{{ address.postal_code }}</p>
                        </div>

                    </CardContent>
                </Card>
            </div>
        </SettingsLayout>
    </AppLayout>

</template>