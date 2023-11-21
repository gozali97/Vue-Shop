<script setup>
import Navigation from "@/Pages/Admin/Components/Navigation.vue";
import Sidebar from "@/Pages/Admin/Components/Sidebar.vue";
</script>

<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <Navigation/>
        <!-- Sidebar -->

        <Sidebar/>

        <main class="p-4 md:ml-64 h-screen pt-20">
            <slot />
        </main>
    </div>
</template>
