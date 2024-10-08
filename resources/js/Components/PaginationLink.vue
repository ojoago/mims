<script setup>

    defineProps({
        pages:Array
    })
    defineEmits(['action'])

</script>

<template>
    <div class="mt-4">
            <!-- Render the pagination links -->
        <nav v-if="pages?.links?.length">
            <button @click="$emit('action',pages?.next_page_url)" :disabled="!pages?.prev_page_url" class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50">Previous</button>
            <button @click="$emit('action',pages?.next_page_url)" :disabled="!pages?.next_page_url" class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50">Next</button>
        </nav>
    </div>
</template>



<style scoped>

</style>