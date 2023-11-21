<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import ProductList from "@/Pages/Admin/Product/ProductList.vue";

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <AdminLayout>
            <Head title="Product" />
            <ProductList></ProductList>
    </AdminLayout>
</template>
