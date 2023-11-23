<script setup>

import App from "@/Layouts/App.vue";
import {Head, router} from "@inertiajs/vue3";
import Feature from "@/Pages/User/components/Feature.vue";
import Paginate from "@/Components/Paginate.vue";
import Review from "@/Pages/User/components/Review.vue";
import Contact from "@/Pages/User/components/Contact.vue";
import {ElNotification} from "element-plus";


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

const addToCart = (product) => {
    // console.log(product)
    router.post(route('cart.store', product), {
        onSuccess: (page) => {
            if (page.props.flash.success) {
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
            }
        },
    })
}

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

                        <div
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-blue-200 cursor-pointer ">
                            <div class="bg-cyan-700 hover:bg-cyan-500 transition duration-150 hover:scale-105 p-2 rounded-full cursor-pointer">
                                <a @click="addToCart(product)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="bg-emerald-500 p-2 rounded-full ml-2">
                                <a href="detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <!-- end -->

                        <div class="mt-4 flex justify-between px-4">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a :href="route('user.home')" class="text-gray-900 font-semibold dark:text-gray-100">
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
                <div data-aos="fade-left" class="mt-10 flex justify-end gap-3">
                    <Paginate :products="products"/>
                </div>
            </div>
        </div>
        <Review/>
        <Feature/>
        <Contact/>

    </App>
</template>
