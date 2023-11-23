
<script setup>
import {CircleCheck, RefreshRight, ShoppingCartFull, TrophyBase} from "@element-plus/icons-vue";
</script>
<template>
    <section class="bg-white dark:bg-gray-900 py-4">
        <div class="py-8 mx-auto max-w-screen-xl px-4 border rounded-lg shadow-lg dark:bg-gray-800 dark:border-none">
            <div class="grid grid-cols-2 gap-8 text-gray-500 sm:gap-12 lg:grid-cols-4 dark:text-gray-400">
                <div class="flex space-x-5 items-center">
                    <div>
                        <span>
                            <el-icon color="#409EFC" :size="50">
                                <ShoppingCartFull/>
                            </el-icon>
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-900 text-xl font-bold tracking-wide mb-1 dark:text-gray-200">Free Shipping</p>
                        <p class="text-sm text-gray-500 dark:text-gray-300">When ordering over $100</p>
                    </div>
                </div>
                <div class="flex space-x-5 items-center">
                    <div>
                        <span>
                            <el-icon color="#409EFC" :size="50">
                                <RefreshRight/>
                            </el-icon>
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-900 text-xl font-bold tracking-wide mb-1 dark:text-gray-200">Free Return</p>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Get Return within 30 days</p>
                    </div>
                </div>
                <div class="flex space-x-5 items-center">
                    <div>
                        <span>
                            <el-icon color="#409EFC" :size="50">
                                <CircleCheck/>
                            </el-icon>
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-900 text-xl font-bold tracking-wide mb-1 dark:text-gray-200">Secure Payment</p>
                        <p class="text-sm text-gray-500 dark:text-gray-300">100% Secure Online Payment</p>
                    </div>
                </div>
                <div class="flex space-x-5 items-center">
                    <div>
                        <span>
                            <el-icon color="#409EFC" :size="50">
                                <TrophyBase/>
                            </el-icon>
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-900 text-xl font-bold tracking-wide mb-1 dark:text-gray-200">Best Quality</p>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Original Product Guarenteed</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
