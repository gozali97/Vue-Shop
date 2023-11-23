<script setup>

import App from "@/Layouts/App.vue";
import {Head, usePage} from "@inertiajs/vue3";
import Feature from "@/Pages/User/components/Feature.vue";
import Paginate from "@/Components/Paginate.vue";
import Review from "@/Pages/User/components/Review.vue";
import Contact from "@/Pages/User/components/Contact.vue";
import {Top} from "@element-plus/icons-vue";

const sampleImage = [
    {
        id: 1,
        name: 'Sample 1',
        href: '#',
        imageSrc: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqEWgS0uxxEYJ0PsOb2OgwyWvC0Gjp8NUdPw&usqp=CAU',
    },{
        id: 2,
        name: 'Sample 2',
        href: '#',
        imageSrc: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqEWgS0uxxEYJ0PsOb2OgwyWvC0Gjp8NUdPw&usqp=CAU',
    },{
        id: 2,
        name: 'Sample 3',
        href: '#',
        imageSrc: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqEWgS0uxxEYJ0PsOb2OgwyWvC0Gjp8NUdPw&usqp=CAU',
    }
];

defineProps({
    products:Object
});

// const products = usePage().props.products;
</script>

<template>
    <App>
        <Head title="Dashboard" />
        <div class="bg-white dark:bg-gray-900">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Latest Product List</h2>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8 ">
                    <div data-aos="fade-up" data-aos-duration="1500" v-for="product in products.data" :key="product.id" class="group relative shadow-lg rounded-lg p-4">
                        <el-carousel :interval="5000" trigger="click" class="rounded-lg">
                            <el-carousel-item  v-if="product.product_images.length" v-for="(pimg, index) in product.product_images" :key="index">
                                <img :src="pimg.image ? pimg.image : sampleImage" :alt="product.title" class="h-20 w-20 object-cover object-center lg:h-full lg:w-full" />
                            </el-carousel-item>
                            <el-carousel-item v-else v-for="(simg, key) in sampleImage" :key="key">
                                <img :src="simg.imageSrc" :alt="simg.name" class="h-20 w-20 object-cover object-center lg:h-full lg:w-full" />
                            </el-carousel-item>
                        </el-carousel>
                        <div class="mt-4 flex justify-between px-4">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a :href="product.href" class="text-gray-900 font-semibold dark:text-gray-100">
                                        <span aria-hidden="true" class="absolute inset-0 " />
                                        {{ product.title }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ product.brand.name }}</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-50">Rp. {{ Number(product.price).toLocaleString() }}</p>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left" class="mt-10 flex justify-end">
                    <Paginate :products="products"/>
                </div>
            </div>
        </div>
        <Review/>
        <Feature/>
        <Contact/>

    </App>
</template>
