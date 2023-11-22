<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import BrandList from "@/Pages/Admin/Brand/BrandList.vue";

</script>

<template>
    <AdminLayout>
            <Head title="Brand" />
            <BrandList></BrandList>
    </AdminLayout>
</template>
