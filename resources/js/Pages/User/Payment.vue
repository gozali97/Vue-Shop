<script setup>
import App from "@/Layouts/App.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {ElNotification} from "element-plus";
const auth = usePage().props.auth;
defineProps({
    order:Object,
    token:String,
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
                <div class="mb-3">
                    <label class="font-bold text-sm mb-2 ml-1">Name</label>
                    <div>
                        <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="John Smith" type="text" :value="auth.user.name"/>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="font-bold text-sm mb-2 ml-1">Order ID</label>
                    <div>
                        <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="John Smith" type="text" :value="order.order_id"/>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="font-bold text-sm mb-2 ml-1">Total Price</label>
                    <div>
                        <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" :value="Number(order.total_price).toLocaleString()" type="text"/>
                    </div>
                </div>
                <div>
                    <button @click="handlePayment(token)" class="block w-full max-w-xs mx-auto bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 text-white rounded-lg px-3 py-3 font-semibold"><i class="mdi mdi-lock-outline mr-1"></i> PAY NOW</button>
                </div>
            </div>
        </div>
    </App>
</template>
