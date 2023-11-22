<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CategoryList from "@/Pages/Admin/Category/CategoryList.vue";

</script>

<template>
    <AdminLayout>
            <Head title="Category" />
            <CategoryList></CategoryList>
    </AdminLayout>
</template>
