<script setup>
import {usePage} from "@inertiajs/vue3";

const brand_global = usePage().props.brand_global;

</script>

<template>
    <div class="container-x flex flex-col justify-center items-center mx-auto px-6 bg-white dark:bg-gray-900">
        <div class=" section-title flex justify-between items-center mb-5">
            <div>
                <h1 data-aos="fade-up" class="text-md lg:text-3xl font-bold text-gray-900 dark:text-gray-100">Shop by Brand</h1>
            </div>
        </div>
        <div class="flex flex-row items-center justify-center">
            <div v-for="(item, index) in brand_global" class="item">
                <div data-aos="fade-up" class="bg-white border border-gray-200 w-full flex justify-center">
                    <div class="w-full"></div>
                        <img class="w-full h-32" alt="logo" :src="item.image" decoding="async" data-nimg="fill" />
                    </div>
            </div>
        </div>
    </div>
</template>
