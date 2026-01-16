<script setup lang="ts">
import { Moon, Sun } from 'lucide-vue-next';
import { ref, onMounted, watch } from 'vue';

const theme = ref<'light' | 'dark'>('light');

const toggleTheme = () => {
    theme.value = theme.value === 'light' ? 'dark' : 'light';
};

onMounted(() => {
    const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | null;

    theme.value =
        savedTheme ??
        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
});

watch(
    theme,
    (value) => {
        document.documentElement.classList.remove('light', 'dark');
        document.documentElement.classList.add(value);
        localStorage.setItem('theme', value);
    },
    { immediate: true }
);
</script>

<template>
    <button @click="toggleTheme" aria-label="Toggle theme">
        <Sun v-if="theme === 'dark'" />
        <Moon v-else />
    </button>
</template>
