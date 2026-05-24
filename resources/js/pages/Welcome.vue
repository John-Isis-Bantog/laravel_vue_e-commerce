<script setup lang="ts">
import HeroSection from '@/Landing/HeroSection.vue';
import HowItWorks from '@/Landing/HowItWorks.vue';
import LandingFooter from '@/Landing/LandingFooter.vue';
import Value from '@/Landing/Value.vue';
import { homeRedirect, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="flex min-h-screen flex-col items-center bg-white text-gray-900 p-6 lg:justify-center lg:p-8
               dark:bg-gray-950 dark:text-gray-100">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">

                <Link v-if="$page.props.auth.user" :href="homeRedirect()" class="inline-block rounded-sm border border-gray-300 px-5 py-1.5 text-sm leading-normal text-gray-900
                           hover:border-gray-400 dark:border-gray-700 dark:text-gray-100 dark:hover:border-gray-500">
                    Dashboard
                </Link>

                <template v-else>
                    <Link :href="login()" class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-gray-900
                               hover:border-gray-300 dark:text-gray-100 dark:hover:border-gray-700">
                        Log in
                    </Link>

                    <Link v-if="canRegister" :href="register()"
                        class="inline-block rounded-sm border border-gray-300 px-5 py-1.5 text-sm leading-normal text-gray-900
                               hover:border-gray-400 dark:border-gray-700 dark:text-gray-100 dark:hover:border-gray-500">
                        Register
                    </Link>
                </template>

            </nav>
        </header>

        <div class="mx-auto opacity-100 transition-opacity duration-300 starting:opacity-0
                    text-gray-900 dark:text-gray-100 lg:grow">

            <main class="flex max-w-[335px] lg:max-w-4xl flex-col gap-16">
                <HeroSection />
                <HowItWorks />
                <Value />
                <LandingFooter />
            </main>

        </div>

        <div class="hidden h-14.5 lg:block"></div>
    </div>

</template>