<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import ProductList from "@/Pages/Admin/Product/ProductList.vue";

defineProps({
    products:Object
})

</script>

<template>
    <AdminLayout>
            <Head title="Product" />
            <ProductList :products="products" ></ProductList>
    </AdminLayout>
</template>
