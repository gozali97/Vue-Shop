<script setup>
import App from "@/Layouts/App.vue";
import {DeleteFilled} from "@element-plus/icons-vue";
import {computed, reactive} from "vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {ElNotification} from "element-plus";
const carts = computed(() => usePage().props.carts)
const total = computed(() => usePage().props.total)

defineProps({
    userAddress:Object,
})


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
            <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap gap-4">
                <div class="relative overflow-x-auto sm:rounded-lg lg:w-2/3 md:w-1/2 lg:px-6">
                    <h1 class="text-xl font-semibold mb-4 dark:text-white">Your Cart</h1>
                    <table class="w-full text-sm text-left overflow-y-scroll max-h-[800px] text-gray-500 dark:text-gray-400 rounded-lg">
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
                        <tr v-if="carts" v-for="(item, index) in carts" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                Rp. {{Number(item.product.price).toLocaleString() }}
                            </td>
                            <td class="px-6 py-4">
                                <a @click="deleteProduct    (item)" class="font-medium cursor-pointer text-red-600 dark:text-red-500 hover:underline">
                                    <el-icon class="mt-2"><DeleteFilled /></el-icon>
                                   <span class="ml-2">Delete</span>
                                </a>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="5"  class="px-6 flex justify-center items-center font-semibold text-gray-900 dark:text-white">
                              <p class="mt-6 text-red-500">The Cart is currently empty</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="mt-8 text-lg font-medium">Shipping Methods</p>
                    <form class="mt-5 grid gap-6">
                        <div class="relative">
                            <input class="peer hidden" id="radio_1" type="radio" name="radio" checked />
                            <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
                            <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_1">
                                <img class="w-14 object-contain" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png" alt="" />
                                <div class="ml-5">
                                    <span class="mt-2 font-semibold">Fedex Delivery</span>
                                    <p class="text-slate-500 text-sm leading-6">Delivery: 2-4 Days</p>
                                </div>
                            </label>
                        </div>
                        <div class="relative">
                            <input class="peer hidden" id="radio_2" type="radio" name="radio" checked />
                            <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
                            <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_2">
                                <img class="w-14 object-contain" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png" alt="" />
                                <div class="ml-5">
                                    <span class="mt-2 font-semibold">Fedex Delivery</span>
                                    <p class="text-slate-500 text-sm leading-6">Delivery: 2-4 Days</p>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="lg:w-1/3 md:w-1/2 bg-white px-6 flex flex-col md:ml-auto w-full h-fit md:py-8 mt-8 md:mt-0 dark:bg-gray-800 rounded-lg">
                    <h2 class="text-gray-900 text-2xl mb-1 font-bold dark:text-white">Summary</h2>
                    <p v-if="total" class="leading-relaxed font-semibold mb-5 text-gray-600 dark:text-gray-200">Total : Rp. {{ Number(total).toLocaleString() }}</p>
                    <p v-else class="leading-relaxed font-semibold mb-5 text-gray-600 dark:text-gray-200">Total : Rp. 0</p>
                    <h2 class="text-gray-900 text-xl mb-1 font-semibold dark:text-white">Shipping Address</h2>
                    <p v-if="userAddress" class="leading-relaxed mb-5 text-gray-600 dark:text-gray-200">{{userAddress.address1}}, {{userAddress.city}}, {{userAddress.zipcode}}</p>
                    <p class="leading-relaxed mb-5 text-gray-600 dark:text-gray-200">or you can add below</p>
                    <form @submit.prevent="submit">
                        <div class="relative mb-4">
                            <label for="address1" class="leading-7 text-sm text-gray-600 dark:text-gray-100">Address 1</label>
                            <input type="text" id="address1" name="address1" v-model="form.address1" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="city" class="leading-7 text-sm text-gray-600 dark:text-gray-100">City</label>
                            <input type="text" id="city" name="city" v-model="form.city" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">State</label>
                            <input type="text" id="email" name="state" v-model="form.state"
                                   class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="zipcode" class="leading-7 text-sm text-gray-600 dark:text-gray-100">Zipcode</label>
                            <input type="text" id="zipcode" name="zipcode" v-model="form.zipcode" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="country_code" class="leading-7 text-sm text-gray-600 dark:text-gray-100">Coutry Code</label>
                            <input type="text" id="country_code" name="country_code" v-model="form.country_code" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="type" class="leading-7 text-sm text-gray-600 dark:text-gray-100">Address Type</label>
                            <input type="text" id="type" name="type" v-model="form.type" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <button v-if="formFilled" type="submit" class="text-white bg-blue-600 border-0 py-2 px-6 focus:outline-none w-full hover:bg-blue-700 rounded-lg text-lg">Checkout</button>
                        <button v-else type="submit" class="text-white w-full bg-blue-600 border-0 py-2 px-6 focus:outline-none hover:bg-blue-700 rounded-lg text-lg">Add Address</button>
                    </form>
                        <p class="text-xs text-gray-500 mt-3 dark:text-gray-100">Continue shopping</p>
                </div>
                </div>
        </section>
    </App>
</template>
