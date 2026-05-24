<script setup lang="ts">
import { computed, ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ErrorMessage, Field, Form } from 'vee-validate'
import * as yup from 'yup'

// Layout & UI
import AppLayout from '@/layouts/AppLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import Label from '@/components/ui/label/Label.vue'
import { Check, ShieldAlert, Loader2, X } from 'lucide-vue-next'

// Routes
import adminRoute from '@/routes/admin'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Admins', href: adminRoute.index().url },
    { title: 'Create', href: adminRoute.create().url },
]

const schema = yup.object({
    name: yup.string().required('Full name is required'),
    email: yup.string().required().email('Enter a valid email'),
    password: yup.string().required().min(8).matches(/[a-z]/).matches(/[A-Z]/).matches(/\d/).matches(/[^a-zA-Z0-9]/),
})

const form = useForm({ name: '', email: '', password: '' })
const password = ref('')

const passwordChecks = computed(() => [
    { label: '8+ characters', met: password.value.length >= 8 },
    { label: 'Upper & lowercase', met: /[A-Z]/.test(password.value) && /[a-z]/.test(password.value) },
    { label: 'Numbers', met: /\d/.test(password.value) },
    { label: 'Special character', met: /[^a-zA-Z0-9]/.test(password.value) },
])

const strengthScore = computed(() => passwordChecks.value.filter(c => c.met).length)

const submitForm = (values: any) => {
    form.transform(() => ({ ...values })).post(adminRoute.store().url)
}
</script>

<template>

    <Head title="Add User" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="min-h-screen bg-slate-50/50 dark:bg-gray-900 py-12 transition-colors">
            <div class="mx-auto max-w-2xl px-4">

                <!-- Header Section -->
                <div class="mb-8 flex items-center justify-between">

                    <div>
                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">
                            New Administrator
                        </h1>

                        <p class="text-slate-500 dark:text-gray-400">
                            Provide credentials for the new privileged account.
                        </p>
                    </div>

                    <Link :href="adminRoute.index().url"
                        class="text-slate-400 hover:text-slate-600 dark:text-gray-500 dark:hover:text-gray-300 transition">
                        <X class="h-6 w-6" />
                    </Link>

                </div>

                <!-- Main Form Card -->
                <div class="overflow-hidden rounded-2xl border shadow-sm
                           border-slate-200 bg-white
                           dark:border-gray-700 dark:bg-gray-800 transition-colors">

                    <Form :validation-schema="schema" @submit="submitForm" class="p-8">

                        <div class="space-y-6">

                            <!-- Name Field -->
                            <div class="space-y-2">

                                <Label for="name" class="text-xs font-bold uppercase tracking-wider
                                           text-slate-500 dark:text-gray-400">
                                    Full Name
                                </Label>

                                <Field name="name" placeholder="E.g. Alexander Hamilton" class="flex h-11 w-full rounded-lg border px-4 text-sm outline-none transition
                                           border-slate-200 bg-white text-slate-900
                                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                                           dark:border-gray-700 dark:bg-gray-900 dark:text-white
                                           dark:focus:border-blue-500 dark:focus:ring-blue-500/20" />

                                <ErrorMessage name="name" class="text-xs font-medium text-red-500" />
                            </div>

                            <!-- Email Field -->
                            <div class="space-y-2">

                                <Label for="email" class="text-xs font-bold uppercase tracking-wider
                                           text-slate-500 dark:text-gray-400">
                                    Email Address
                                </Label>

                                <Field name="email" type="email" placeholder="admin@company.com" class="flex h-11 w-full rounded-lg border px-4 text-sm outline-none transition
                                           border-slate-200 bg-white text-slate-900
                                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                                           dark:border-gray-700 dark:bg-gray-900 dark:text-white
                                           dark:focus:border-blue-500 dark:focus:ring-blue-500/20" />

                                <ErrorMessage name="email" class="text-xs font-medium text-red-500" />
                            </div>

                            <!-- Password Field -->
                            <div class="space-y-2">

                                <Label for="password" class="text-xs font-bold uppercase tracking-wider
                                           text-slate-500 dark:text-gray-400">
                                    Account Password
                                </Label>

                                <Field v-model="password" name="password" type="password" placeholder="••••••••" class="flex h-11 w-full rounded-lg border px-4 text-sm outline-none transition
                                           border-slate-200 bg-white text-slate-900
                                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                                           dark:border-gray-700 dark:bg-gray-900 dark:text-white
                                           dark:focus:border-blue-500 dark:focus:ring-blue-500/20" />

                                <!-- Strength Bar -->
                                <div class="mt-3 grid grid-cols-4 gap-2">
                                    <div v-for="n in 4" :key="n" :class="[
                                        'h-1 rounded-full transition-colors',
                                        n <= strengthScore
                                            ? 'bg-blue-500'
                                            : 'bg-slate-100 dark:bg-gray-700'
                                    ]" />
                                </div>

                                <!-- Checklist -->
                                <div class="mt-3 grid grid-cols-2 gap-x-4 gap-y-2">

                                    <div v-for="check in passwordChecks" :key="check.label"
                                        class="flex items-center gap-2 text-[11px] font-medium transition-colors"
                                        :class="check.met
                                            ? 'text-emerald-600 dark:text-emerald-400'
                                            : 'text-slate-400 dark:text-gray-500'">
                                        <Check v-if="check.met" class="h-3 w-3" />
                                        <div v-else class="h-1 w-1 rounded-full bg-current" />
                                        {{ check.label }}
                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Warning Box -->
                        <div class="mt-10 flex gap-3 rounded-xl p-4
                                   bg-amber-50 text-amber-800
                                   dark:bg-amber-900/20 dark:text-amber-300">
                            <ShieldAlert class="h-5 w-5 shrink-0" />

                            <p class="text-xs leading-relaxed">
                                <strong>Warning:</strong> This user will have access to sensitive platform data,
                                including user management and system settings.
                            </p>

                        </div>

                        <!-- Action Bar -->
                        <div class="mt-8 flex items-center justify-end gap-4 border-t pt-8
                                   border-slate-100 dark:border-gray-700">

                            <Link :href="adminRoute.index().url">
                                <Button type="button" variant="ghost" class="text-slate-600 dark:text-gray-300">
                                    Cancel
                                </Button>
                            </Link>

                            <Button type="submit" :disabled="form.processing"
                                class="bg-slate-900 hover:bg-slate-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200 px-8">
                                <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />

                                Create Account
                            </Button>

                        </div>

                    </Form>

                </div>
            </div>
        </div>

    </AppLayout>

</template>