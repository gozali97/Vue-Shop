<script setup>
import {router, usePage} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import {ElNotification} from "element-plus";
import {Plus} from "@element-plus/icons-vue";

defineProps({
    categories:Object
})

const searchValue = usePage().props.search;
const isAddItem = ref(false);
const isEditItem = ref(false);
const dialogVisible = ref(false);

//form data banner
const id = ref('');
const name = ref('');
const slug = ref('');
const image = ref('');
const disabled = ref(true)

const getDefaultImage = () => {
    return '../../images/no_image.jpg';
};

const openAddModal = () => {
    isAddItem.value = true;
    isEditItem.value = false;
    dialogVisible.value = true;
    resetFormData();
}

const openEditModal = (item) => {

    id.value = item.id;
    name.value = item.name;
    slug.value = item.slug;
    image.value = item.image;
    images.value = '';

    isEditItem.value = true;
    isAddItem.value = false;
    dialogVisible.value = true;

}

const dialogPreviewImg = ref(false)
const dialogImageUrl = ref('')
const images = ref([])
const handleFileChange = (file) => {
    // console.log(file)
    images.value.push(file)
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogPreviewImg.value = true
}

const handleRemove = (file) => {
    console.log(file)
}

//delete image from product image
const deleteImage = async (slug) => {
    try {
        await router.delete('/admin/category/image/' + slug, {
            onSuccess: (page) => {
                // dialogVisible.value = false;
                resetImage();
                ElNotification({
                    title: 'Success',
                    message: page.props.flash.success,
                    type: 'success',
                })
            }
        })
    } catch (err) {
        console.log(err);
    }
}

const resetImage = () => {
    image.value = '';
    images.value = '';
};

//search
const search = ref(searchValue);
watch(search, (value) =>{
    router.get(
        "/admin/category/index",
        {search: value},
        {preserveState: false,
        }
    );
});
// function onFileChange(e){
//     console.log(e.target.files[0])
//     image.value = e.target.files[0];
// }

//add product method
const AddCategory = async ()=>{

    const formData = new FormData();
    formData.append('name', name.value);
    for (const image of images.value) {
        formData.append('image', image.raw);
    }
    try {
        await router.post('store', formData, {
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

const updateCategory = async () => {
    const formData = new FormData();
    formData.append('name', name.value);
    formData.append("_method", 'PUT');
    // formData.append('image', image.value);
    for (const image of images.value) {
        formData.append('image', image.raw);
    }

    try {
        await router.post('update/' + id.value, formData, {
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
const deleteCategory = (item, index) => {
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
                router.delete('destroy/' + item.id, {
                    onSuccess: (page) => {
                        this.delete(item, index);
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
    name.value = '';
    image.value = '';
    images.value = '';
};
</script>

<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">

        <!-- Start modal -->
        <el-dialog
            v-model="dialogVisible"
            class="text-gray-800 dark:bg-gray-800 dark:text-gray-200"
            width="30%"
        >
            <h3 class="text-lg text-gray-800 dark:text-white mb-6">{{ isEditItem ? 'Edit Category' : 'Add Category' }}</h3>
            <form @submit.prevent="isEditItem ? updateCategory() : AddCategory()">
                <div class="mb-6">
                    <label for="form_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" v-model="name" name="name" id="form_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Category name" required>
                </div>
                <div class="mt-6">
                    <div class="relative z-0 w-full mb-6 group" :class="image ? 'hidden' : ''">
                        <el-upload v-model:file-list="images" accept=".jpg, .jpeg, .png" list-type="picture-card" :limit="1" multiple
                                   :on-preview="handlePictureCardPreview" :on-remove="handleRemove" :on-change="handleFileChange">
                            <el-icon>
                                <Plus />
                            </el-icon>

                            <el-dialog v-model="dialogPreviewImg">
                                <img w-full :src="dialogImageUrl" alt="Preview Image" />
                            </el-dialog>
                        </el-upload>
                    </div>
                    <div v-if="image" class="flex flex-nowrap mb-8 ">
                        <div class="relative w-32 h-32 ">
                            <img class="w-48 h-32 rounded-lg border" :src="image" alt="">
                            <span
                                class="absolute top-0 -right-2 transform -translate-y-1/2 w-6 h-6 bg-red-400 border-2 border-white dark:border-gray-800 rounded-full">
                                        <span @click="deleteImage(slug)"
                                              class="text-white text-lg font-bold absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 cursor-pointer">x</span>
                                </span>
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
                                <input type="search" v-model.lazy="search" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                            </div>
                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button type="button" @click="openAddModal" class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add category
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
                            <th scope="col" class="px-4 py-3">Name</th>
                            <th scope="col" class="px-4 py-3">Image</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in categories.data" :key="item.id" class="border-b dark:border-gray-700">
                            <td class="px-4 py-3">{{index+1}}</td>
                            <th scope="row" class="px-4 py-3 font-medium dark:text-gray-200 text-gray-900 whitespace-nowrap">{{item.name}}</th>
                            <td class="px-4 py-3">
                                <img v-if="item.image" class="w-16 h-10 rounded" :src="item.image" :aria-label="item.name"/>
                                <img v-else class="w-16 h-10 rounded" :src="getDefaultImage()"/>
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
                                        <a href="#" @click="deleteCategory(item, index)" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">

                </nav>
            </div>
        </div>
    </section>
</template>
