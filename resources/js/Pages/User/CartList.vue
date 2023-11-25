<script setup>
import App from "@/Layouts/App.vue";
import {DeleteFilled} from "@element-plus/icons-vue";
import {computed, reactive} from "vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {ElNotification} from "element-plus";
const carts = computed(() => usePage().props.carts)
const total = computed(() => usePage().props.total)


const reduceQuantity = async (item) => {
    if (item.quantity === 1) {
        return;
    }
    try {
        await router.patch(route('cart.update', item.product_id), {
            quantity: item.quantity - 1,
            onSuccess: page => {
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
            },
        });
    } catch (err) {
        alert(err)
    }
};

const addQuantity = async (item) => {
    try {
        await router.patch(route('cart.update', item.product_id), {
            quantity: item.quantity + 1,
            onSuccess: page => {
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
            },
        });
    } catch (err) {
        alert(err)
    }
};

//remove form cart
// const remove = (product) => router.delete(route('cart.delete', product));

const deleteProduct = (product) => {
    Swal.fire({
        title: 'Are you Sure',
        text: "This actions cannot undo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No',
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete(route('cart.delete', product), {
                    onSuccess: (page) => {
                        this.delete(product);
                        Swal.fire({
                            toast: true,
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            title: page.props.flash.success
                        });
                    }
                })
            } catch (err) {
                console.log(err)
            }
        }
    })
}

const form = reactive({
    address1: null,
    state: null,
    city: null,
    zipcode: null,
    country_code: null,
    type: null,

})
const formFilled = computed(()=>{
    return (form.address1 !== null &&
        form.state !== null &&
        form.city !== null &&
        form.zipcode !== null &&
        form.country_code !== null &&
        form.type !== null )
})

//confirm order

function submit() {
    router.visit(route('checkout.store'), {
        method: 'post',
        data: {
            carts: usePage().props.cart.data.items,
            products: usePage().props.cart.data.products,
            total: usePage().props.cart.data.total,
            address: form
        }
    })
}

</script>

<template>
    <App>

        <Head title="Cart" />
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
                <div class="relative overflow-x-auto sm:rounded-lg lg:w-2/3 md:w-1/2 lg:px-6">
                    <h1 class="text-xl font-semibold mb-4">Your Cart</h1>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg">
                        <thead class="text-xs text-white uppercase bg-gray-800 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-16 py-3 rounded-tl-lg">
                                <span class="sr-only">Image</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Product
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Qty
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 rounded-tr-lg">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in carts" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <div class="w-32 max-w-32">
                                    <img class="w-32 h-36" v-if="item.product_image.length > 0"
                                         :src="`/${item.product_image[0].image}`" alt="image">
                                    <img class="w-32 h-36" v-else
                                         src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png"
                                         alt="image">
                                </div>

                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ item.product.title }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <button @click.prevent="reduceQuantity(item)" :disabled="item.quantity === 1" :class="item.quantity === 1 ? 'cursor-not-allowed text-gray-500 bg-white hover:bg-gray-100' : 'cursor-pointer bg-red-500 text-white hover:bg-red-600'" class="inline-flex items-center justify-center p-1 text-sm font-medium h-6 w-6 border border-gray-300 rounded-full focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                        <span class="sr-only">Minus button</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                        </svg>
                                    </button>
                                    <div class="ms-3">
                                        <input type="number" id="first_product" class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="item.quantity" required>
                                    </div>
                                    <button @click.prevent="addQuantity(item)" class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-mediu cursor-pointer bg-green-500 text-white hover:bg-green-600 border border-gray-300 rounded-full focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                        <span class="sr-only">Plus button</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{Number(item.product.price).toLocaleString() }}
                            </td>
                            <td class="px-6 py-4">
                                <a @click="deleteProduct    (item)" class="font-medium cursor-pointer text-red-600 dark:text-red-500 hover:underline">
                                    <el-icon class="mt-2"><DeleteFilled /></el-icon>
                                   <span class="ml-2">Delete</span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="lg:w-1/3 md:w-1/2 bg-white px-6 flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                    <h2 class="text-gray-900 text-2xl mb-1 font-bold">Summary</h2>
                    <p class="leading-relaxed font-semibold mb-5 text-gray-600">Total : Rp. {{ Number(total).toLocaleString() }}</p>
                    <h2 class="text-gray-900 text-xl mb-1 font-semibold">Shipping Address</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <p class="leading-relaxed mb-5 text-gray-600">or you can add below</p>
                    <div class="relative mb-4">
                        <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                        <input type="text" id="name" name="name" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                        <input type="email" id="email" name="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                        <textarea id="message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                    <button class="text-white bg-blue-600 border-0 py-2 px-6 focus:outline-none hover:bg-blue-700 rounded text-lg">Checkout</button>
                    <p class="text-xs text-gray-500 mt-3">Continue shopping</p>
                </div>
            </div>
        </section>
    </App>
</template>
