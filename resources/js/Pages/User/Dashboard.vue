<script setup>
import {Head, usePage, Link, router} from '@inertiajs/vue3';
import App from "@/Layouts/App.vue";
import Banner from "@/Pages/User/components/Banner.vue";
import {computed} from "vue";
import Paginate from "@/Components/Paginate.vue";
import {DArrowLeft, DArrowRight} from "@element-plus/icons-vue";

const orders = computed(() => usePage().props.orders)

function payOrder(order) {
    router.visit(route('pay'), {
        method: 'post',
        data: {
            order: order
        }
    })
}
</script>

<template>
    <Head title="Dashboard" />
    <App>
        <Banner/>
        <div class="block py-10 h-auto">
            <div class="mx-auto mt-2 max-w-screen-lg px-2">
                <div class="sm:flex sm:items-center sm:justify-between flex-col sm:flex-row">
                    <p class="flex-1 text-base font-bold text-gray-900">Latest Order</p>

                    <div class="mt-4 sm:mt-0">
                        <div class="flex items-center justify-start sm:justify-end">
                            <div class="flex items-center">
                                <label for="" class="mr-2 flex-shrink-0 text-sm font-medium text-gray-900"> Sort by: </label>
                                <select name="" class="sm: mr-4 block w-full whitespace-pre rounded-lg border p-1 pr-10 text-base outline-none focus:shadow sm:text-sm">
                                    <option class="whitespace-no-wrap text-sm">Recent</option>
                                </select>
                            </div>

                            <button type="button" class="inline-flex cursor-pointer items-center rounded-lg border border-gray-400 bg-white py-2 px-3 text-center text-sm font-medium text-gray-800 shadow hover:bg-gray-100 focus:shadow">
                                <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" class=""></path>
                                </svg>
                                Export to CSV
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-6 overflow-hidden rounded-xl border shadow">
                    <table class="min-w-full border-separate border-spacing-y-2 border-spacing-x-2">
                        <thead class="hidden border-b lg:table-header-group">
                        <tr class="">
                            <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6">Order ID</td>

                            <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6">Product</td>

                            <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6">Amount</td>

                            <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6">Status</td>
                            <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6"></td>
                        </tr>
                        </thead>
                        <tbody class="lg:border-gray-300">
                        <tr v-if="orders.data.length" v-for="(order, key) in orders.data" :key="key" class="">
                            <td class="whitespace-no-wrap py-4 text-sm font-bold text-gray-900 sm:px-6">
                                {{ order.order_id }}
                            </td>
                            <td class="whitespace-no-wrap hidden py-4 text-sm font-normal text-gray-500 sm:px-6 lg:table-cell">
                                <div v-for="(item, i) in order.items">
                                    <ol>
                                        <li v-for="(product, key) in item.product">
                                            - {{product.title}} ({{item.quantity}})
                                        </li>
                                    </ol>
                                </div>
                            </td>
                            <td class="whitespace-no-wrap py-4 px-6 text-right text-sm text-gray-600 lg:text-left">
                                Rp. {{Number(order.gross_amount).toLocaleString() }}
                            </td>
                            <td class="whitespace-no-wrap hidden py-4 text-sm font-normal text-gray-500 sm:px-6 lg:table-cell">
                                <div class="inline-flex items-center rounded-full py-1.5 px-3 text-xs text-white" :class="order.status == 'Unpaid' ? 'bg-yellow-500' : 'bg-blue-500'">
                                    {{ order.status }}</div>
                            </td>
                            <td class="whitespace-no-wrap hidden py-4 text-sm font-normal text-gray-500 sm:px-6 lg:table-cell">
                                <button @click="payOrder(order)" v-if="order.status == 'Unpaid'" class="inline-flex items-center rounded-lg py-1.5 px-3 text-xs text-white bg-emerald-600 hover:bg-emerald-700">Payment</button>
                                <Link :href="route('invoice', order.id)"  v-else class="inline-flex items-center rounded-lg py-1.5 px-3 text-xs text-white bg-rose-600 hover:bg-rose-700">Invoice</Link>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="5" class="w-full">
                                <div class="flex text-red-500 justify-center">
                                No have order yet
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="orders.data.length" class="mx-auto mt-4 flex max-w-md justify-center space-x-2 rounded-lg bg-gray-50 py-2">
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
    </App>
</template>
