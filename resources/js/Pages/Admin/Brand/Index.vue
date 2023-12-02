<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import BrandList from "@/Pages/Admin/Brand/BrandList.vue";
defineProps({
    brands:Object,
})
</script>

<template>
    <AdminLayout>
            <Head title="Brand" />
            <BrandList :brands="brands"></BrandList>
    </AdminLayout>
</template>
