<script setup>
import {Head, Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Paginate from "@/Components/Paginate.vue";
import {DArrowLeft, DArrowRight, Document} from "@element-plus/icons-vue";

defineProps({
    orders:Object,
})
</script>

<template>
    <AdminLayout>
        <Head title="Order" />
        <div class="flex w-full">
            <section class="flex w-full bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
                <div class="mx-auto w-full px-4 lg:px-8">
                    <!-- Start coding here -->
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="w-full md:w-1/2">
                                <form class="flex items-center">
                                    <label for="simple-search" class="sr-only">Search</label>
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                                    </div>
                                </form>
                            </div>
                            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <div class="flex items-center space-x-3 w-full md:w-auto">
                                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                        Actions
                                    </button>
                                    <div id="actionsDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                                            <li>
                                                <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a>
                                        </div>
                                    </div>
                                    <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                        </svg>
                                        Filter
                                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </button>
                                    <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose brand</h6>
                                        <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                            <li class="flex items-center">
                                                <input id="apple" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="apple" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Apple (56)</label>
                                            </li>
                                            <li class="flex items-center">
                                                <input id="fitbit" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="fitbit" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Microsoft (16)</label>
                                            </li>
                                            <li class="flex items-center">
                                                <input id="razor" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="razor" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Razor (49)</label>
                                            </li>
                                            <li class="flex items-center">
                                                <input id="nikon" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="nikon" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nikon (12)</label>
                                            </li>
                                            <li class="flex items-center">
                                                <input id="benq" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="benq" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">BenQ (74)</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">#</th>
                                    <th scope="col" class="px-4 py-3">Product name</th>
                                    <th scope="col" class="px-4 py-3">Category</th>
                                    <th scope="col" class="px-4 py-3">Brand</th>
                                    <th scope="col" class="px-4 py-3">Price</th>
                                    <th scope="col" class="px-4 py-3">Total Amount</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(order, i) in orders.data" class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">{{i+1}}</td>
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div v-for="item in order.items">
                                            <div v-for="prod in item.product">
                                                {{prod.title}}
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-4 py-3">
                                        <div v-for="item in order.items">
                                            <div v-for="prod in item.product">
                                                    {{prod.category.name}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div v-for="item in order.items">
                                            <div v-for="prod in item.product">
                                                {{prod.brand.name}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div v-for="item in order.items">
                                           Rp. {{ Number(item.unit_price).toLocaleString() }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        Rp. {{ Number(order.gross_amount).toLocaleString() }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span v-if="order.status == 'Paid'" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Paid</span>
                                        <span v-else class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Unpaid</span>
                                    </td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <Link v-if="order.status == 'Paid'" :href="route('admin.order.invoice', order.id)" class="inline-flex font-bold bg-green-500 hover:bg-green-600 rounded-lg px-2 py-1 text-white">
                                            <el-icon class="mt-0.5 mr-1"><Document /></el-icon>  Invoice
                                        </Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="orders.data.length" class="mx-auto mt-4 flex max-w-md justify-end py-2">
                            <ul class="flex">
                                <li v-for="(link, index) in orders.links" class="flex items-center mx-2 space-x-1 font-medium ">
                                    <Link :href="link.url" v-if="link.label.includes('Previous')" class="flex p-2.5 text-gray-800 rounded-full items-center text-lg font-medium hover:bg-gray-200 hover:text-gray-900">
                                        <el-icon size="15"><DArrowLeft /></el-icon>
                                    </Link>
                                    <Link :href="link.url" v-else-if="link.label.includes('Next')" class="flex p-2.5 text-gray-800 rounded-full items-center text-lg font-medium hover:bg-gray-200 hover:text-gray-900">
                                        <el-icon size="15"><DArrowRight /></el-icon>
                                    </Link>
                                    <Link v-else :href="link.url" class="flex py-0.5 text-gray-800 rounded-full items-center text-lg font-medium sm:px-3 hover:text-gray-100" :class="link.active ? 'bg-blue-500 hover:bg-blue-600':'bg-gray-200 hover:bg-gray-400'">
                                        {{ link.label }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </AdminLayout>
</template>
