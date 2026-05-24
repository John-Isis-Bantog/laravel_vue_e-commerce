<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
</script>

<template>
    <section class="grid items-center gap-10 md:grid-cols-2 py-16">

        <!-- Left content -->
        <div class="space-y-6 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                Everything You Need,<br class="hidden md:block" />
                Delivered Simply
            </h1>

            <p class="text-muted-foreground text-lg max-w-md mx-auto md:mx-0">
                Discover quality products at great prices. Shop easily, securely, and get what you need delivered to
                your door.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                <Button variant="primary">Shop Now</Button>
                <Button variant="secondary">Browse Categories</Button>
            </div>

            <div class="flex justify-center md:justify-start gap-6 text-sm text-muted-foreground pt-2">
                <span>✔ Secure Checkout</span>
                <span>✔ Fast Delivery</span>
                <span>✔ Quality Guaranteed</span>
            </div>
        </div>

        <!-- Right visual placeholder -->
        <div class="relative">
            <div class="aspect-square rounded-2xl bg-muted/40 border flex items-center justify-center">
                <span class="text-muted-foreground">Product / Promo Image</span>
            </div>
        </div>

    </section>
</template>