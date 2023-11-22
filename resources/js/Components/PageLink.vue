<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    }
});
</script>

<template>
    <Link :href="href">
        <slot />
    </Link>
</template>
