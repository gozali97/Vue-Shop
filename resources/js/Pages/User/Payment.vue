<script setup>
import App from "@/Layouts/App.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {ElNotification} from "element-plus";
import {Money} from "@element-plus/icons-vue";
const auth = usePage().props.auth;
defineProps({
    order:Object,
    token:String,
    total_product:Number,
    total_price:Number,
})

const handlePayment = (token) => {
    window.snap.pay(token, {
        onSuccess: function (result) {
            /* You may add your own implementation here */
            console.log(result);
            ElNotification({
                title: 'Success',
                message: 'payment success!',
                type: 'success',
            })
            // window.location.href = '/dashboard';
            router.visit(route('dashboard'));
        },
        onPending: function (result) {
            /* You may add your own implementation here */
            ElNotification({
                title: 'Warning',
                message: 'waiting for your payment!',
                type: 'warning',
            })
            console.log(result);
        },
        onError: function (result) {
            /* You may add your own implementation here */
            ElNotification({
                title: 'Error',
                message: 'payment failed!',
                type: 'error',
            })
            console.log(result);
        },
        onClose: function () {
            ElNotification({
                title: 'Info',
                message: 'you closed the popup without finishing the payment',
                type: 'info',
            })
        },
    });
};
</script>
<template>
    <App>
        <Head title="Payment" />
        <div class="min-w-screen min-h-screen bg-gray-200 flex items-center justify-center px-5 pb-10 pt-20">
            <div class="w-full mx-auto rounded-lg bg-white shadow-lg p-5 text-gray-700" style="max-width: 600px">
                <div class="w-full pt-1 pb-5">
                    <div class="bg-indigo-500 text-white overflow-hidden rounded-full w-20 h-20 -mt-16 mx-auto shadow-lg flex justify-center items-center">
                        <img :src="`/images/logo.png`">
                    </div>
                </div>
                <div class="mb-10">
                    <h1 class="text-center font-bold text-xl uppercase">Secure payment</h1>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-s-lg">
                                Product name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Qty
                            </th>
                            <th scope="col" class="px-6 py-3 rounded-e-lg">
                                Price
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, i) in order.items" :key="i" class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div v-for="(product, key) in item.product">
                                    {{product.title}}
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                {{item.quantity}}
                            </td>
                            <td class="px-6 py-4">
                                Rp. {{ Number(item.unit_price).toLocaleString() }}
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr class="font-semibold text-gray-900 dark:text-white">
                            <th scope="row" class="px-6 py-3 text-base">Total</th>
                            <td class="px-6 py-3">{{total_product}}</td>
                            <td class="px-6 py-3">Rp. {{ Number(order.gross_amount).toLocaleString() }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="flex justify-end mb-2 mt-4">
                    <div class="text-gray-700 mr-2 dark:text-gray-200">Subtotal:</div>
                    <div class="text-gray-700 dark:text-gray-200">Rp. {{ Number(order.gross_amount).toLocaleString() }}</div>
                </div>
                <div class="flex justify-end mb-8">
                    <div class="text-gray-700 mr-2 dark:text-gray-200">Shipping:</div>
                    <div class="text-gray-700 dark:text-gray-200">Rp. {{ Number(order.courir_price).toLocaleString() }}</div>

                </div>
                <div class="flex justify-end mb-8">
                    <div class="text-gray-700 mr-2">Total:</div>
                    <div class="text-gray-700 font-bold text-xl">Rp. {{ Number(total_price).toLocaleString() }}</div>
                </div>
                <div class="flex justify-center">
                    <button @click="handlePayment(token)" class="inline-flex justify-center w-full max-w-xs mx-auto bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 text-white rounded-lg px-3 py-2 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-0.5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        PAY NOW</button>
                </div>
            </div>
        </div>
    </App>
</template>
