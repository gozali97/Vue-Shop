<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Navbar from "@/Pages/User/components/Navbar.vue";
import Footer from "@/Pages/User/components/Footer.vue";
import Header from "@/Pages/User/components/Header.vue";
import AOS from "aos";

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
    AOS.init();
})
</script>

<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <Navbar/>
        <Header/>
        <main>
            <slot />
        </main>
        <Footer/>
    </div>
</template>
