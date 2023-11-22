<script setup>
import Link from "@/Components/Link.vue";
import {DArrowLeft, DArrowRight} from "@element-plus/icons-vue";

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>


<template>
    <div v-if="data.links.length > 3" class="flex justify-center mt-4 space-x-4">
        <div v-for="(link, k) in data.links" class="flex justify-center items-center gap-3">
            <Link v-if="link.label.includes('Previous')"
                  class="px-4 py-3 text-sm leading-4 rounded focus:text-blue-500 hover:shadow" :href="link.url ? data.prev_page_url : data.first_page_url" aria-label="Previous">
                <el-icon>
                    <DArrowLeft />
                </el-icon>
            </Link>
            <Link v-else-if="link.label.includes('Next')"
                  class="px-4 py-3 text-sm leading-4 rounded focus:text-blue-500 hover:shadow" :href="link.url ? data.next_page_url : data.last_page_url" aria-label="Previous">
                <el-icon>
                    <DArrowRight />
                </el-icon>
            </Link>
            <Link v-else
            :key="k"
            class="px-4 py-3 text-sm leading-4 rounded focus:text-blue-500 hover:shadow"
            :class="link.active ? 'bg-blue-500 text-white hover:bg-blue-700 hover:text-white': 'bg-white hover:bg-gray-100'"
            :href="link.url"
            v-html="link.label"
        />
        </div>
    </div>
</template>

