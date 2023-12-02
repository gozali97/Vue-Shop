<script setup>
import App from "@/Layouts/App.vue";
import {DeleteFilled, Plus} from "@element-plus/icons-vue";
import {computed, reactive, ref} from "vue";
import {Head, router, usePage, Link} from "@inertiajs/vue3";
import {ElNotification} from "element-plus";
import Select from "@/Components/Select.vue";
import Banner from "@/Pages/User/components/Banner.vue";
const carts = computed(() => usePage().props.carts)
const total = computed(() => usePage().props.total)
const shippings = computed(() => usePage().props.shippings)

defineProps({
    userAddress:Object,
    provinces:Object
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
    shipping: null,
})

//confirm order

function submit() {
    router.visit(route('checkout.store'), {
        method: 'post',
        data: {
            carts: usePage().props.cart.data.items,
            products: usePage().props.cart.data.products,
            total: usePage().props.cart.data.total,
            items: form
        },
        onSuccess: page => {
            ElNotification({
                title: 'Success',
                message: page.props.flash.success,
                type: 'success',
            })
        },
    })
}

const isAddItem = ref(false);
const dialogVisible = ref(false);

//form data address
const id = ref('');
const type = ref('');
const address1 = ref('');
const no_hp = ref('');
const isMain = ref(false);
const postcode = ref('');
const country_code = ref('');
const city_id = ref('');
const prov_id = ref(1);
const cities = ref([]);

const getCityByProvince = async () => {
    try {
        const response = await fetch(`/address/city/${prov_id.value}`);
        const data = await response.json();
        cities.value = data.data;
    } catch (error) {
        console.error(error);
    }
}

const openAddModal = () => {
    isAddItem.value = true;
    dialogVisible.value = true;

    prov_id.value = null;
}

const AddAddress = async ()=>{

    const formData = new FormData();
    formData.append('address1', address1.value);
    formData.append('no_hp', no_hp.value);
    formData.append('prov_id', prov_id.value);
    formData.append('city_id', city_id.value);
    formData.append('postcode', postcode.value);
    formData.append('country_code', country_code.value);
    formData.append('isMain', isMain.value);
    formData.append('type', type.value);

    try {
        await router.post('address', formData, {
            onSuccess: page => {
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
                dialogVisible.value = false;
            },
        })
    } catch (err) {
        console.log(err)
    }
}

</script>

<template>
    <App>
        <Head title="Cart" />
        <Banner/>
        <section class="text-gray-600 body-font pb-10">
            <div class="container px-5 pt-12 mx-auto h-screen flex sm:flex-nowrap flex-wrap gap-4">
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
                                <a @click="deleteProduct(item)" class="font-medium cursor-pointer text-red-600 dark:text-red-500 hover:underline">
                                    <el-icon class="mt-2"><DeleteFilled /></el-icon>
                                   <span class="ml-2">Delete</span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="!carts">
                        <div colspan="5"  class="px-6 flex flex-col justify-center items-center font-semibold text-gray-900 dark:text-white">
                            <p class="mt-6 text-red-500">The Cart is currently empty</p>
                            <Link :href="route('product.index')" class="bg-blue-500 text-white px-3 py-0.5 mt-2 rounded-lg shadow">Add Product</Link>
                        </div>
                    </div>
                </div>

                <!-- Start modal -->
                <el-dialog
                    v-model="dialogVisible"
                    class="text-gray-800 dark:bg-gray-800 dark:text-gray-200"
                    width="60%"
                >
                    <h3 class="text-lg text-gray-800 dark:text-white mb-6">Add Address</h3>
                    <form @submit.prevent="AddAddress()">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-6">
                                    <label for="form_address1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address 1</label>
                                    <input type="text" v-model="address1" name="form_address1" id="form_address1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Address 1" required>
                                </div>
                                <div class="mb-6">
                                    <label for="form_no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Handphone</label>
                                    <input type="text" v-model="no_hp" name="form_no_hp" id="form_no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="No Handphone">
                                </div>
                                <div class="mb-6">
                                    <label for="form_province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>
                                    <select id="form_province" name="form_province" @change="getCityByProvince" v-model="prov_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option v-for="(prov, index) in provinces" :key="index" :value="prov.province_id" >{{prov.province}}</option>
                                    </select>
                                </div>

                                <div class="mb-6">
                                    <label for="form_city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                    <select id="form_city" name="form_city" v-model="city_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option v-for="(city, index) in cities" :key="index" :value="city.city_id" >{{city.city_name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="mb-6">
                                    <label for="form_countrycode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country Code</label>
                                    <input type="text" v-model="country_code" name="form_countrycode" id="form_countrycode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Country Code" required>
                                </div>

                                <div class="mb-6">
                                    <label for="form_postcode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Postcode</label>
                                    <input type="text" v-model="postcode" name="form_postcode" id="form_postcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Postcode" required>
                                </div>

                                <div class="mb-6">
                                    <label for="form_active" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                                    <select id="form_active" name="form_active" v-model="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value=home selected>Home</option>
                                        <option value="office">Office</option>
                                        <option value="school">School</option>
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label for="form_active" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                    <select id="form_active" name="form_active" v-model="isMain" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Non Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="flex w-full justify-center items-center gap-4">
                            <button type="button" @click="dialogVisible = false" class="text-white bg-black hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-900 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-dark dark:hover:bg-slate-900 dark:focus:ring-black">Cancel</button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </el-dialog>
                <!-- End modal -->

                <div class="lg:w-1/3 md:w-1/2 bg-white px-6 flex flex-col md:ml-auto w-full h-fit md:py-8 mt-8 md:mt-0 dark:bg-gray-800 rounded-lg">
                    <h2 class="text-gray-900 text-2xl mb-1 font-bold dark:text-white">Summary</h2>
                    <p v-if="total" class="leading-relaxed font-semibold mb-5 text-gray-600 dark:text-gray-200">Total : Rp. {{ Number(total).toLocaleString() }}</p>
                    <p v-else class="leading-relaxed font-semibold mb-5 text-gray-600 dark:text-gray-200">Total : Rp. 0</p>
                    <h2 class="text-gray-900 text-xl mb-1 font-semibold dark:text-white">Shipping Address</h2>
                    <p v-if="userAddress" class="leading-relaxed mb-5 text-gray-600 dark:text-gray-200">{{userAddress.address1}}, {{userAddress.city}}, {{userAddress.postcode}}</p>
                    <button v-else type="button" @click="openAddModal" class="flex my-2 items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <el-icon><Plus /></el-icon>
                        <span class="ml-2"> Add Address</span>
                    </button>
                    <form @submit.prevent="submit">
                        <div v-if="userAddress">
                            <p class="mt-2 text-lg font-medium">Shipping Methods</p>
                            <div class="my-5 grid gap-6">
                                <div v-for="(ship, index) in shippings" :key="index" class="relative">
                                    <input
                                        class="peer hidden"
                                        v-model="form.shipping"
                                        :value="`${ship.name}-${ship.type}-${ship.price}`"
                                        :id="'radio_' + index"
                                        type="radio"
                                        name="radio"
                                        required
                                        :checked="form.shipping === `${ship.name}-${ship.type}-${ship.price}`"
                                    />
                                    <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
                                    <label
                                        class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4"
                                        :for="'radio_' + index"
                                    >
                                        <img class="w-14 object-contain" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png" alt="" />
                                        <div class="ml-5">
                                            <span class="mt-2 font-semibold capitalize">{{ ship.name }} ({{ ship.type }})</span>
                                            <p class="text-slate-500 text-sm leading-6">Rp. {{ Number(ship.price).toLocaleString() }}</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button v-if="carts && userAddress" type="submit" class="text-white w-full bg-blue-600 border-0 py-1 px-6 focus:outline-none hover:bg-blue-700 rounded-lg text-lg">Checkout</button>
                    </form>
                        <Link :href="route('product.index')" class="text-xs text-gray-500 mt-3 dark:text-gray-100">Continue shopping</Link>
                </div>
                </div>
        </section>
    </App>
</template>
