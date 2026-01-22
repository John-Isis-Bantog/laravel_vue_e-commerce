<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { edit } from '@/routes/profile';
import { BreadcrumbItem } from '@/types';
import { Form, Head, router, useForm } from '@inertiajs/vue3';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import Button from '@/components/ui/button/Button.vue';
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
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import DialogFooter from '@/components/ui/dialog/DialogFooter.vue';
import DialogClose from '@/components/ui/dialog/DialogClose.vue';
import DialogTrigger from '@/components/ui/dialog/DialogTrigger.vue';
import Dialog from '@/components/ui/dialog/Dialog.vue';
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: addressesRoute.index().url,
    },
];



const provinces = ref<any[]>([])
const cities = ref<any[]>([])
const isAddressModalOpen = ref(false)
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
type AddressForm = Omit<Address, 'id'>
const form = useForm<AddressForm>({
    recipient_name: '',
    phone: '09',
    address_line_1: '',
    city: '',
    postal_code: '',
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
    form.post(addressesRoute.store().url, {
        onSuccess: () => {
            form.reset()
            isAddressModalOpen.value = false
        }
    })
}

function onPhoneInput(e: Event) {
    let value = (e.target as HTMLInputElement).value

    value = value.replace(/\D/g, '');

    if (!value.startsWith('09')) {
        value = value.slice(0, 11)
    }
    form.phone = value
}

function deleteAddress(id: number) {
    router.delete(addressesRoute.destroy(id).url, {
        preserveScroll: true
    })
}
function onlyNumbers(e: KeyboardEvent) {
    const allowed = [
        'Backspace',
        'Delete',
        'ArrowLeft',
        'ArrowRight',
        'Tab',
    ]

    if (allowed.includes(e.key)) return

    if (!/^\d$/.test(e.key)) {
        e.preventDefault()
    }
}

function onPostalCodeInput(value: string | number | boolean) {
    form.postal_code = String(value).replace(/\D/g, '')
}

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Profile settings" />
        <SettingsLayout>
            <Dialog v-model:open="isAddressModalOpen">
                <DialogTrigger as-child>
                    <Button variant="outline">
                        Add Address
                    </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Add Address</DialogTitle>
                        <DialogDescription>
                            You May Add Multiple Address Here
                        </DialogDescription>
                    </DialogHeader>
                    <Form class="space-y-2" @submit.prevent="submitForm()">
                        <div class="grid gap-4">

                            <div class="">
                                <Label for="recepient_name">Recepient Name</Label>
                                <Input type="text" v-model="form.recipient_name"></Input>
                                <span v-if="form.errors.recipient_name" class="text-red-600">{{
                                    form.errors.recipient_name }}</span>
                            </div>
                            <div class="">
                                <Label for="phone">Phone Number</Label>
                                <Input type="tel" v-model="form.phone" maxlength="11" inputmode="numeric"
                                    placeholder="09XXXXXXXXX" @input="onPhoneInput" />
                                <span v-if="form.errors.phone" class="text-red-600">{{ form.errors.phone }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <div>
                                    <Label for="province">Province</Label>

                                    <Select v-model="form.province" required>
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

                                    <span v-if="form.errors.province" class="text-red-600">
                                        {{ form.errors.province }}
                                    </span>
                                </div>
                                <div>
                                    <Label for="city">City</Label>

                                    <Select v-model="form.city" :disabled="!form.province" required>
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

                                    <span v-if="form.errors.city" class="text-red-600">
                                        {{ form.errors.city }}
                                    </span>
                                </div>

                            </div>
                            <div class="">
                                <Label for="address">Address</Label>
                                <Input type="text" v-model="form.address_line_1"></Input>
                                <span v-if="form.errors.address_line_1" class="text-red-600">{{
                                    form.errors.address_line_1 }}</span>
                            </div>

                            <div class="">
                                <Label for="postalCode">Postal Code</Label>
                                <Input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="10"
                                    :model-value="form.postal_code" @keydown="onlyNumbers"
                                    @update:model-value="onPostalCodeInput" />

                                <span v-if="form.errors.postal_code" class="text-red-600">{{ form.errors.postal_code
                                    }}</span>
                            </div>
                        </div>

                        <DialogFooter>
                            <DialogClose as-child>
                                <Button variant="outline">
                                    Cancel
                                </Button>
                            </DialogClose>
                            <Button type="submit">Submit</Button>
                        </DialogFooter>
                    </Form>
                </DialogContent>

            </Dialog>

            <div class="space-y-4">
                <!-- Addresses Grid -->
                <div class="grid md:grid-cols-2 gap-4">
                    <Card v-for="address in props.addresses" :key="address.id"
                        class="shadow-md hover:shadow-lg transition">

                        <!-- Header -->
                        <CardHeader class="flex justify-between items-center">
                            <div>
                                <CardTitle class="text-lg font-semibold">
                                    {{ address.recipient_name }}
                                </CardTitle>
                                <CardDescription class="text-sm text-gray-500">
                                    {{ address.phone }}
                                </CardDescription>
                            </div>
                        </CardHeader>
                        <!-- Content -->
                        <CardContent class="gap-2 mt-2">
                            <div class="space-y-1">
                                <p class="text-gray-700">
                                    {{ address.address_line_1 }} , {{ address.province }} , {{ address.city }}</p>

                                <p class="text-gray-700"><span class="font-semibold">Postal Code:</span> {{
                                    address.postal_code }}</p>
                            </div>
                        </CardContent>
                        <!-- Actions -->
                        <div class="flex space-x-2 mx-auto">
                            <Button variant="outline" size="sm">
                                Edit
                            </Button>
                            <Button variant="destructive" size="sm" @click="deleteAddress(address.id)">
                                Delete
                            </Button>
                        </div>
                    </Card>
                </div>
            </div>

        </SettingsLayout>
    </AppLayout>

</template>