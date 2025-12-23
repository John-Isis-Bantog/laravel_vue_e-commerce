<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { dashboard, login, register } from '@/routes';
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
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link v-if="$page.props.auth.user" :href="dashboard()"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                    Dashboard
                </Link>
                <template v-else>
                    <Link :href="login()"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">
                        Log in
                    </Link>
                    <Link v-if="canRegister" :href="register()"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                        Register
                    </Link>
                </template>
            </nav>
        </header>
        <div class="mx-auto opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0 text-white">
            <main class="flex max-w-[335px] lg:max-w-4xl flex-col gap-16">
                <!-- Hero -->
                <section class="text-center space-y-4">
                    <h1 class="text-3xl font-bold">
                        Everything You Need, Delivered Simply
                    </h1>

                    <p class="text-muted-foreground">
                        Discover quality products at great prices. Shop easily, securely,
                        and get what you need delivered to your door.
                    </p>

                    <div class="flex justify-center gap-4">
                        <Button variant="primary">Shop Now</Button>
                        <Button variant="secondary">Browse Categories</Button>
                    </div>
                </section>

                <!-- How it works -->
                <section class="space-y-8">
                    <h2 class="text-center text-2xl font-semibold">
                        How It Works
                    </h2>

                    <div class="flex  gap-6">
                        <div>
                            🛒 <strong>Browse Products</strong>
                            <p class="text-sm text-muted-foreground">
                                Explore our catalog and find products that fit your needs.
                            </p>
                        </div>

                        <div>
                            📦 <strong>Add to Cart</strong>
                            <p class="text-sm text-muted-foreground">
                                Select your items and manage your cart with ease.
                            </p>
                        </div>

                        <div>
                            💳 <strong>Checkout Securely</strong>
                            <p class="text-sm text-muted-foreground">
                                Complete your purchase with a fast and secure checkout.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Value proposition -->
                <section class="text-center space-y-4">
                    <h2 class="text-2xl font-semibold">
                        Why Shop With Us?
                    </h2>

                    <p class="text-muted-foreground">
                        We focus on quality, simplicity, and a smooth shopping experience —
                        from browsing to delivery.
                    </p>
                </section>

                <!-- Call to action -->
                <footer class="text-center space-y-4">
                    <h2 class="text-2xl font-semibold">
                        Ready to Start Shopping?
                    </h2>

                    <p class="text-muted-foreground">
                        Create an account or start browsing products today.
                    </p>

                    <div class="flex justify-center">
                        <Button variant="primary">Create an Account</Button>
                    </div>
                </footer>
            </main>

        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
