<script setup lang="ts">
import Alert from '@/components/ui/alert/Alert.vue';
import AlertDescription from '@/components/ui/alert/AlertDescription.vue';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Alert class=" mx-auto w-1/2 top-5 sticky" v-if="$page.props.flash?.success || $page.props.flash?.error">
            <AlertTitle>Info</AlertTitle>
            <AlertDescription>
                {{ $page.props.flash.success }}
                {{ $page.props.flash.error }}
            </AlertDescription>
        </Alert>
        <slot />
    </AppLayout>
</template>
