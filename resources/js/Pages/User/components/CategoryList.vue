<script setup>
import {Splide, SplideSlide} from "@splidejs/vue-splide";
import {usePage} from "@inertiajs/vue3";

const category_global = usePage().props.category_global;
</script>

<template>
    <div class="flex flex-col bg-white dark:bg-gray-900 py-6 px-8 w-full justify-center">
        <h1 class="text-2xl text-gray-900 font-bold mb-4">Shop by Category</h1>
            <Splide :options="{ type : 'loop', gap: '1rem', perPage: 5, autoplay: true}" aria-label="My Favorite Images">
                <SplideSlide v-for="(category, index) in category_global" class="bg-white dark:bg-gray-900 py-6">
                    <div class="flex w-full gap-6 bg-white dark:bg-gray-900">
                        <div class="max-w-xs rounded-md bg-white dark:bg-gray-900 border overflow-hidden shadow-lg hover:scale-105 transition duration-500 cursor-pointer">
                            <div class="flex w-72 h-72">
                                <img :src="category.image" alt="" class="w-72 h-72"/>
                            </div>
                            <div class="py-2 px-4 bg-white dark:bg-gray-900">
                                <h3 class="text-lg font-semibold text-gray-600">{{category.name}}</h3>
                            </div>
                        </div>
                    </div>
                </SplideSlide>
            </Splide>
    </div>

</template>
