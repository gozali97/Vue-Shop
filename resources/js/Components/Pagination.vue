<script setup>
import PageLink from "@/Components/PageLink.vue";
import Link from "@/Components/Link.vue";

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>


<template>
    <div v-if="data.links.length > 3" class="flex justify-center mt-4 space-x-4">
<!--        <div class="flex justify-center items-center gap-3">-->
            <Link
            v-for="(link, k) in data.links"
            :key="k"
            class="px-4 py-3 text-sm leading-4 rounded focus:text-blue-500 hover:shadow"
            :class="link.active ? 'bg-blue-500 text-white hover:bg-blue-700 hover:text-white': 'bg-white hover:bg-gray-100',
            link.url ? '': 'hidden'"
            :href="link.url ? link.url : ''"
            v-html="link.label"
        />
<!--        </div>-->
    </div>
</template>

