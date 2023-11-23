<script setup>
import { ref, reactive, watch } from 'vue';


defineProps({
    value: Object,
    placeholder: String,
    items: Array,
})

const isOpen = ref(false);
const searchValue = ref('');
const filteredData = ref(items);
const selectedItems = reactive([]);

const activeItem = ref(null);

const handleSearch = (value) => {
    searchValue.value = value;
    filteredData.value = items.filter((item) =>
        item.name.toLowerCase().includes(value.toLowerCase())
    );
};

        const selectItem = (item) => {
            if (selectedItems.includes(item)) {
                selectedItems.splice(selectedItems.indexOf(item), 1);
            } else {
                selectedItems.push(item);
            }
            activeItem.value = item;
            emit('update:value', item);
        };

        watch(
            () => props.value,
            (newValue) => {
                selectedItems.splice(0, selectedItems.length);
                if (newValue) {
                    selectedItems.push(newValue);
                }
            }
        );
</script>

<template>
    <div class="relative z-0 rounded-xl w-full">
        <button
            class="flex h-11 w-full items-center justify-between gap-x-2 rounded-lg border px-3 focus:outline-none"
            @click="isOpen = !isOpen"
        >
            <span class="capitalize line-clamp-1">{{ value.name || placeholder }}</span>
            <div @click.stop="isOpen = !isOpen">
                <svg
                    class="h-5 w-5 text-gray-400"
                    viewBox="0 0 20 20"
                    fill="none"
                    stroke="currentColor"
                >
                    <path
                        d="M7 7l3-3 3 3m0 6l-3 3-3-3"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>
        </button>
        <transition name="fade">
            <div
                v-if="isOpen"
                class="z-50 absolute right-0 mt-1 max-h-[10rem] w-full overflow-y-auto rounded-lg border bg-white py-1 shadow-sm"
            >
                <div class="mx-2 rounded-lg">
                    <input
                        type="text"
                        placeholder="Search..."
                        v-model="searchValue"
                        @input="handleSearch"
                        class="px-2 py-1 w-full border-none focus:outline-none focus:border-none rounded-md"
                    />
                </div>
                <template v-for="item in filteredData" :key="item.id">
                    <div
                        @click="selectItem(item)"
                        :class="[
              'flex cursor-pointer items-center py-1.5 px-4',
              { 'bg-gray-100': activeItem === item },
              { 'bg-primary-50 font-semibold text-primary-600 hover:bg-primary-100': selectedItems.includes(item) }
            ]"
                    >
                        <span class="capitalize line-clamp-1">{{ item.name }}</span>
                    </div>
                </template>
            </div>
        </transition>
    </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
