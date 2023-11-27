<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AddressList from "@/Pages/User/UserAddress/AddressList.vue";

defineProps({
    address:Object,
})

</script>

<template>
    <AdminLayout>
            <Head title="Banner" />
            <AddressList :address="address"></AddressList>
    </AdminLayout>
</template>
