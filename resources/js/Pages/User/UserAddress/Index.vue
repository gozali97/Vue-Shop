<script setup>
import Pagination from "@/Components/Pagination.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {ref, watch, onMounted, computed} from "vue";
import Select from "@/Components/Select.vue";
import {ElNotification} from "element-plus";
import App from "@/Layouts/App.vue";
import {Plus} from "@element-plus/icons-vue";
import Banner from "@/Pages/User/components/Banner.vue";

const address = computed(() => usePage().props.address)
const provinces = usePage().props.provinces;

const searchValue = usePage().props.search;
const isAddItem = ref(false);
const isEditItem = ref(false);
const dialogVisible = ref(false);

//form data address
const id = ref('');
const type = ref('');
const address1 = ref('');
const no_hp = ref('');
const city = ref('');
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
    isEditItem.value = false;
    dialogVisible.value = true;

    prov_id.value = null;
    resetFormData();
}

const openEditModal = (item) => {

    id.value = item.id;
    type.value = item.type;
    address1.value = item.address1;
    no_hp.value = item.no_hp;
    city.value = item.city;
    prov_id.value = item.prov_id;
    isMain.value = item.isMain;
    postcode.value = item.postcode;
    country_code.value = item.country_code;
    city_id.value = item.city_id;

    isEditItem.value = true;
    isAddItem.value = false;
    dialogVisible.value = true;

    getCityByProvince(prov_id.value)

}

//search
const search = ref(searchValue);
watch(search, (value) =>{
    router.get(
        "/address",
        {search: value},
        {preserveState: false,
        }
    );
});

//add product method
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
        await router.post('address/store', formData, {
            onSuccess: page => {
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
                dialogVisible.value = false;
                resetFormData();
            },
        })
    } catch (err) {
        console.log(err)
    }
}

const updateAddress = async () => {
    const formData = new FormData();
    formData.append('address1', address1.value);
    formData.append('no_hp', no_hp.value);
    formData.append('prov_id', prov_id.value);
    formData.append('city_id', city_id.value);
    formData.append('postcode', postcode.value);
    formData.append('country_code', country_code.value);
    formData.append('isMain', isMain.value);
    formData.append('type', type.value);
    formData.append("_method", 'PUT');

    try {
        await router.post('address/update/' + id.value, formData, {
            onSuccess: (page) => {
                dialogVisible.value = false;
                resetFormData();
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
            }
        })
    } catch (err) {
        console.log(err)
    }

}

//delete product method
const deleteAddress = (item, index) => {
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
                router.delete('address/delete/' + item.id, {
                    onSuccess: (page) => {
                        // this.delete(item, index);
                        ElNotification({
                            title: 'Success',
                            message: page.props.flash.success,
                            type: 'success',
                        })
                    }
                })
            } catch (err) {
                console.log(err)
            }
        }
    })
}

const resetFormData = () => {
    id.value = '';
    type.value = '';
    address1.value = '';
    no_hp.value = '';
    city.value = '';
    prov_id.value = '';
    isMain.value = false;
    postcode.value = '';
    country_code.value = '';
    city_id.value = '';
};


</script>

<template>
    <App>
        <Head title="Address" />
        <Banner/>
        <div class="h-screen pt-10">
            <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
                <!-- Start modal -->
                <el-dialog
                    v-model="dialogVisible"
                    class="text-gray-800 dark:bg-gray-800 dark:text-gray-200"
                    width="60%"
                >
                    <h3 class="text-lg text-gray-800 dark:text-white mb-6">{{ isEditItem ? 'Edit Address' : 'Add Address' }}</h3>
                    <form @submit.prevent="isEditItem ? updateAddress() : AddAddress()">
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

                <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
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
                                        <input type="text" v-model.lazy="search" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                                    </div>
                                </form>
                            </div>
                            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <button type="button" @click="openAddModal" class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                    <el-icon><Plus /></el-icon>
                                   <span class="ml-2"> Add Address</span>
                                </button>
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
                                    <th scope="col" class="px-4 py-3">Address 1</th>
                                    <th scope="col" class="px-4 py-3">No Handphone</th>
                                    <th scope="col" class="px-4 py-3">Province</th>
                                    <th scope="col" class="px-4 py-3">City</th>
                                    <th scope="col" class="px-4 py-3">Country Code</th>
                                    <th scope="col" class="px-4 py-3">Type</th>
                                    <th scope="col" class="px-4 py-3">isMain</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in address.data" :key="item.id" class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">{{index+1}}</td>
                                    <td scope="row" class="px-4 py-3 font-medium dark:text-gray-200 text-gray-900 whitespace-nowrap">{{item.address1}}</td>
                                    <td scope="row" class="px-4 py-3 font-medium dark:text-gray-200 text-gray-900 whitespace-nowrap">{{item.no_hp}}</td>
                                    <td scope="row" class="px-4 py-3 font-medium dark:text-gray-200 text-gray-900 whitespace-nowrap">{{item.province}}</td>
                                    <td scope="row" class="px-4 py-3 font-medium dark:text-gray-200 text-gray-900 whitespace-nowrap">{{item.city}}</td>
                                    <td scope="row" class="px-4 py-3 font-medium dark:text-gray-200 text-gray-900 whitespace-nowrap">{{item.country_code}}</td>
                                    <td scope="row" class="px-4 py-3 font-medium dark:text-gray-200 text-gray-900 whitespace-nowrap capitalize">
                                        {{item.type}}
                                    </td>
                                    <td scope="row" class="px-4 py-3 font-medium dark:text-gray-200 text-gray-900 whitespace-nowrap capitalize">
                                        <span v-if="item.isMain" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Main Address</span>
                                        <span v-else class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Secondary Address</span>

                                    </td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button :id="`${item.id}-button`" :data-dropdown-toggle="`${item .id}`"
                                                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                                type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div :id="`${item.id}`"
                                             class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                :aria-labelledby="`${item.id}-button`">

                                                <li>
                                                    <a href="#" @click="openEditModal(item)"
                                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                </li>
                                            </ul>
                                            <div class="py-1">
                                                <a href="#" @click="deleteAddress(item, index)" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="mt-4 py-4 px-10">
                                <Pagination :data="address"/>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </App>
</template>
