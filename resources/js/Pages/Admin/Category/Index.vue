<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CategoryList from "@/Pages/Admin/Category/CategoryList.vue";
defineProps({
    categories:Object,
})
</script>

<template>
    <AdminLayout>
            <Head title="Category" />
            <CategoryList :categories="categories"></CategoryList>
    </AdminLayout>
</template>
