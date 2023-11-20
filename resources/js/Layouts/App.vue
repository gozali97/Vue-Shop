<script setup>
import Navigation from "@/Components/Navigation.vue";
import Container from "@/Components/Container.vue";
import Sidebar from "@/Components/Sidebar.vue";
</script>

<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <Navigation/>
        <Sidebar/>
        <main class="p-4 md:ml-64 mt-10 pt-20 h-screen">
            <slot />
        </main>
    </div>
</template>
