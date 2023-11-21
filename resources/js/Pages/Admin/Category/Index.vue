<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CategoryList from "@/Pages/Admin/Category/CategoryList.vue";

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <AdminLayout>
            <Head title="Category" />
            <CategoryList></CategoryList>
    </AdminLayout>
</template>
