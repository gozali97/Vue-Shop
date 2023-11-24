<script setup>
defineProps({
    categories:Object,
})
</script>

<template>
    <div class="flex flex-col bg-white py-6 px-10 w-full justify-center">
        <h1 class="text-xl text-gray-900 font-semibold mb-4">Shop by Category</h1>
        <div class="flex w-full gap-6">
            <div v-for="(category, index) in categories">
                <div class="max-w-xs rounded-md border overflow-hidden shadow-lg hover:scale-105 transition duration-500 cursor-pointer">
                    <div class="flex w-72 h-72">
                        <img :src="category.image" alt="" class="w-72 h-72"/>
                    </div>
                    <div class="py-2 px-4 bg-white">
                        <h3 class="text-lg font-semibold text-gray-600">{{category.name}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
