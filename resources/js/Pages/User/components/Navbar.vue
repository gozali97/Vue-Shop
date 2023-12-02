<script setup>
import {computed, onMounted} from 'vue'
import { initFlowbite } from 'flowbite'
import { Link, usePage } from '@inertiajs/vue3';
import { useDark, useToggle } from '@vueuse/core';
import {Moon, Sunny} from "@element-plus/icons-vue";

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})

const canLogin = usePage().props.canLogin;
const canRegister = usePage().props.canRegister;
const auth = usePage().props.auth;
const carts_global_count = computed(() => usePage().props.carts_global_count);

const isDark = useDark();
const toggleDark = useToggle(isDark);

</script>

<template>
    <nav class="bg-white dark:bg-gray-800 fixed w-full z-20 top-0 start-0 scroll-smooth dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <Link :href="route('home')" class="flex items-center space-x-3  rtl:space-x-reverse">
                <img :src="`/images/logo.png`" class="h-6 lg:h-8" alt="Logo" />
                <span class="self-center text-sm lg:text-2xl font-semibold whitespace-nowrap dark:text-white">V-Shop</span>
            </Link>
            <div v-if="canLogin" class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
<!--                <el-switch-->
<!--                    v-model="isDark"-->
<!--                    class="mr-3 mt-1 cursor-pointer"-->
<!--                    :active-action-icon="Moon"-->
<!--                    style="&#45;&#45;el-switch-on-color: #13ce66; &#45;&#45;el-switch-off-color: #427D9D"-->
<!--                    :inactive-action-icon="Sunny"-->
<!--                />-->
                <button @click="toggleDark()" type="button" class="focus:outline-none font-medium rounded-full font-semibold text-sm px-3 text-center inline-flex items-center mr-4" :class="isDark ? 'text-gray-100' : 'text-yellow-500'">
                    <el-icon v-if="isDark" :size="20"><Moon /></el-icon>
                    <el-icon v-else :size="20"><Sunny /></el-icon>
                </button>

                <div v-if="auth.user" class="mr-6">
                    <Link :href="route('cart.show')"
                          class="relative mr-4 inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 dark:text-white rounded-lg focus:ring-4 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6 ">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span class="sr-only">cart</span>
                        <div
                            class="absolute inline-flex items-center text-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full top-0 right-0 dark:border-gray-900">
                            <span class="mt-0.5">
                                {{ carts_global_count }}
                            </span>
                        </div>
                    </Link>
                </div>
                <button v-if="auth.user" type="button"
                        class="flex mr-3 mt-2 text-sm rounded-full md:mr-0"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">
                    <span class="mr-2 capitalize md:block hidden mt-0.5">{{auth.user.name}}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>

                <div v-else class="flex">
                    <Link :href="route('login')" type="button"
                          class="hidden lg:block text-white  bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-1 mt-2 text-center me-2 mb-2">
                        Login</Link>
                    <Link :href="route('register')" v-if="canRegister" type="button"
                          class="hidden lg:block text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-1 mt-2 text-center me-2 mb-2">
                        Register</Link>

                </div>
                <div v-if="auth.user"
                     class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                     id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">{{ auth.user.name }}</span>
                        <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ auth.user.email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <Link :href="route('dashboard')"
                                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                Dashboard</Link>
                        </li>
                        <li>
                            <Link :href="route('profile.edit')"
                                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                Profile</Link>
                        </li>
                        <li>
                            <Link :href="route('address')"
                                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                Address</Link>
                        </li>
                        <li>
                            <Link :href="route('logout')" method="post" as="button"
                                  class="flex px-4 py-2 w-full text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                Sign
                                out</Link>
                        </li>
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-800 dark:border-gray-700">
                    <li>
                        <Link :href="route('home')" :class="route().current('home') ? 'md:text-blue-700 md:dark:text-blue-500' : 'md:text-gray-800 md:dark:text-gray-100'" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:p-0 md:dark:text-blue-500" aria-current="page">Home</Link>
                    </li>
                    <li>
                        <Link :href="route('product.index')" :class="route().current('product.index') ? 'md:text-blue-700 md:dark:text-blue-500' : 'md:text-gray-800 md:dark:text-gray-100'" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:p-0" aria-current="page">Product</Link>
                    </li>
                    <li>
                        <Link :href="route('about')" :class="route().current('about') ? 'md:text-blue-700 md:dark:text-blue-500' : 'md:text-gray-800 md:dark:text-gray-100'" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</Link>
                    </li>
                    <li>
                        <Link :href="route('contact')" :class="route().current('contact') ? 'md:text-blue-700 md:dark:text-blue-500' : 'md:text-gray-800 md:dark:text-gray-100'" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</Link>
                    </li>
                    <li v-if="auth" >
                        <Link :href="route('dashboard')"
                              class="block lg:hidden py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Dashboard</Link>
                    </li>
                    <li v-if="!auth">
                        <Link :href="route('login')"
                              class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Login</Link>
                    </li>
                    <li v-if="!auth">
                        <Link :href="route('Register')"
                              class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Register</Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</template>


