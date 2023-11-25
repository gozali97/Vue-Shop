<script setup>

import App from "@/Layouts/App.vue";
import {Head, router, Link, usePage} from "@inertiajs/vue3";
import Feature from "@/Pages/User/components/Feature.vue";
import Paginate from "@/Components/Paginate.vue";
import Review from "@/Pages/User/components/Review.vue";
import Contact from "@/Pages/User/components/Contact.vue";
import {ElNotification} from "element-plus";
import CategoryList from "@/Pages/User/components/CategoryList.vue";
import BrandList from "@/Pages/User/components/BrandList.vue";
import Header from "@/Pages/User/components/Header.vue";
import Panel from "@/Pages/User/components/Panel.vue";


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
    products:Object,
});
const auth = usePage().props.auth;
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
        <Header/>
        <Panel/>
        <CategoryList/>
        <div class="bg-white dark:bg-gray-900">
            <div class="mx-auto flex flex-col w-full px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Latest Product List</h2>
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8 ">
                    <div v-for="product in products.data" :key="product.id" class="shadow-lg rounded-lg p-4">
                        <el-carousel :interval="5000" trigger="click" class="rounded-lg">
                            <el-carousel-item  v-if="product.product_images.length" v-for="(pimg, index) in product.product_images" :key="index">
                                <img :src="pimg.image ? pimg.image : sampleImage" :alt="product.title" class="h-20 w-20 object-cover object-center lg:h-full lg:w-full" />
                            </el-carousel-item>
                            <el-carousel-item v-else v-for="(simg, key) in sampleImage" :key="key">
                                <img :src="simg.imageSrc" :alt="simg.name" class="h-20 w-20 object-cover object-center lg:h-full lg:w-full" />
                            </el-carousel-item>
                        </el-carousel>

                        <div class="px-4 mt-4">
                                <Link :href="route('cart.show', product)" class="text-gray-900 font-semibold dark:text-gray-100">
                                        <span aria-hidden="true" class="absolute inset-0 " />
                                        {{ product.title }}
                                </Link>
                        </div>
                        <div class="flex justify-between px-4">
                            <div>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ product.brand.name }}</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-50">Rp. {{ Number(product.price).toLocaleString() }}</p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <div>
                                    <div class="bg-blue-600 p-2 rounded-full transition duration-200 hover:scale-110 hover:bg-blue-800">
                                        <a v-if="auth.user" @click="addToCart(product)" class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </a>
                                        <Link v-else :href="route('login')" class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div data-aos="fade-left" class="mt-10 flex justify-end gap-3">
                    <Paginate :products="products"/>
                </div>
            </div>
        </div>
        <BrandList/>
        <Review/>
        <Feature/>
        <Contact/>

    </App>
</template>
