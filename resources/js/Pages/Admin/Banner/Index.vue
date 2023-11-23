<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import BannerList from "@/Pages/Admin/Banner/BannerList.vue";

defineProps({
    banners:Object,
})

</script>

<template>
    <AdminLayout>
            <Head title="Banner" />
            <BannerList :banners="banners"></BannerList>
    </AdminLayout>
</template>
