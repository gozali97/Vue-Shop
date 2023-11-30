<script setup>
import Navigation from "@/Pages/Admin/Components/Navigation.vue";
import Sidebar from "@/Pages/Admin/Components/Sidebar.vue";
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <Navigation/>
        <!-- Sidebar -->

        <Sidebar/>

        <main class="p-4 md:ml-64 h-screen pt-20 bg-gray-50 dark:bg-gray-900">
            <slot />
        </main>
    </div>
</template>
