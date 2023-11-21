<script setup>
import PageLink from "@/Components/PageLink.vue";

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>


<template>
    <div v-if="data.links.length > 3" class="flex justify-center mt-4 space-x-4">
        <PageLink
            v-for="(link, k) in data.links"
            :key="k"
            class="px-4 py-3 text-sm leading-4 bg-white rounded hover:bg-white focus:text-indigo-500 hover:shadow"
            :class="{'bg-blue-500 text-white hover:bg-blue-600': link.active}"
            :href="link.url"
            v-html="link.label"
        />
    </div>
</template>

