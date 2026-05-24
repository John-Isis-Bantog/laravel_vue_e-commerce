<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
</script>

<template>
    <footer class="py-16 mt-10 border-t">

        <div class="max-w-2xl mx-auto text-center space-y-6">

            <h2 class="text-3xl font-semibold">
                Ready to Start Shopping?
            </h2>

            <p class="text-muted-foreground">
                Create an account or start browsing products today. No friction, just shopping.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <Button variant="primary">Create Account</Button>
                <Button variant="secondary">Browse Products</Button>
            </div>

            <p class="text-xs text-muted-foreground pt-4">
                Secure checkout • Fast delivery • Easy returns
            </p>

        </div>

    </footer>
</template>