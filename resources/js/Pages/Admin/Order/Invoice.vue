<script setup>
import App from "@/Layouts/App.vue";
import moment from 'moment';
import Link from "@/Components/Link.vue";
import {Head, usePage} from "@inertiajs/vue3";

defineProps({
    user:Object,
    total_price:Number,
    sub_total:Number,
})

const order = usePage().props.order;
const data = usePage().props.data;

</script>

<template>
    <App>
        <Head title="Invoice" />
        <div class="py-10">
            <div class="bg-white rounded-lg shadow-lg px-8 py-10 max-w-xl mx-auto dark:bg-gray-800">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <img class="h-8 w-8 mr-2" :src="`/images/logo.png`"
                             alt="Logo" />
                        <div class="text-gray-700 font-semibold text-xl dark:text-gray-100">Vue-Shop</div>
                    </div>
                    <div class="text-gray-700 dark:text-gray-200">
                        <div class="font-bold text-xl mb-2 dark:text-gray-100">INVOICE</div>
                        <div class="text-sm dark:text-gray-200">Date: {{ moment(String(order.paid_at)).format('MM/DD/YYYY hh:mm') }}</div>
                        <div class="text-sm dark:text-gray-200">No: {{ order.order_id }}</div>
                    </div>
                </div>
                <div class="border-b-2 border-gray-300 pb-8 mb-8">
                    <h2 class="text-2xl font-bold mb-4">Bill To:</h2>
                    <div class="text-gray-700 mb-2 dark:text-gray-200">{{ user.user.name }}</div>
                    <div class="text-gray-700 mb-2 dark:text-gray-200">{{ user.address1 }}</div>
                    <div class="text-gray-700 mb-2 dark:text-gray-200">{{ user.city }}, {{ user.country_code }} {{ user.postcode }}</div>
                    <div class="text-gray-700 dark:text-gray-200">{{ user.user.email }}</div>
                </div>
                <table class="w-full text-left mb-8">
                    <thead>
                    <tr>
                        <th class="text-gray-700 font-bold uppercase py-2 dark:text-gray-200">Description</th>
                        <th class="text-gray-700 font-bold uppercase py-2 dark:text-gray-200">Quantity</th>
                        <th class="text-gray-700 font-bold uppercase py-2 dark:text-gray-200">Price</th>
                        <th class="text-gray-700 font-bold uppercase py-2 dark:text-gray-200">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, i) in data">
                        <td class="py-4 text-gray-700 dark:text-gray-200">
                            {{ item.title }}
                        </td>
                        <td class="py-4 text-gray-700 dark:text-gray-200">{{item.quantity}}</td>
                        <td class="py-4 text-gray-700 dark:text-gray-200">Rp. {{ Number(item.unit_price).toLocaleString() }}</td>
                        <td class="py-4 text-gray-700 dark:text-gray-200">RP. {{ Number(item.quantity * item.unit_price).toLocaleString() }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-end mb-2">
                    <div class="text-gray-700 mr-2 dark:text-gray-200">Subtotal:</div>
                    <div class="text-gray-700 dark:text-gray-200">Rp. {{ Number(sub_total).toLocaleString() }}</div>
                </div>
                <div class="flex justify-end mb-8">
                    <div class="text-gray-700 mr-2 dark:text-gray-200">Shipping:</div>
                    <div class="text-gray-700 dark:text-gray-200">Rp. {{ Number(order.courir_price).toLocaleString() }}</div>

                </div>
                <div class="flex justify-end mb-8">
                    <div class="text-gray-700 mr-2">Total:</div>
                    <div class="text-gray-700 font-bold text-xl">Rp. {{ Number(total_price).toLocaleString() }}</div>
                </div>
                <div class="border-t-2 border-gray-300 pt-8 mb-8">
                    <div class="text-gray-700 mb-2">Payment is due within 30 days. Late payments are subject to fees.</div>
                    <div class="text-gray-700 mb-2">Please make checks payable to Your Company Name and mail to:</div>
                    <div class="text-gray-700">123 Main St., Anytown, USA 12345</div>
                </div>
                <div class="flex justify-center">
                    <Link :href="route('admin.order.index')" class="text-white bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Back</Link>
                </div>
            </div>
        </div>
    </App>
</template>
