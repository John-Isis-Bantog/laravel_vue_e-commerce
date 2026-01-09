<script setup lang="ts">
import Alert from '@/components/ui/alert/Alert.vue';
import AlertDescription from '@/components/ui/alert/AlertDescription.vue';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { ref, onMounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';


interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
const page = usePage();
const successMessage = ref('');

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'true') {
        successMessage.value = 'Product has been successfully bought!';
    }
});
const alertMessage = computed(() => {
    if (page.props.flash?.error) return page.props.flash.error;
    if (page.props.flash?.success) return page.props.flash.success;
    if (successMessage.value) return successMessage.value;
    return '';
});

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Alert v-if="alertMessage" class="mx-auto w-1/2 top-5 sticky z-50">
            <AlertTitle>Info</AlertTitle>
            <AlertDescription>
                {{ alertMessage }}
            </AlertDescription>
        </Alert>

        <slot />
    </AppLayout>
</template>
