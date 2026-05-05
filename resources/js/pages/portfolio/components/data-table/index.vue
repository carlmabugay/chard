<script setup lang="ts">
import Search from '@/components/shared/datatable/search/index.vue'
import Pagination from '@/components/shared/datatable/pagination/index.vue'
import Table from '@/pages/portfolio/components/data-table/table/index.vue'
import type { PageProps, Portfolio } from '@/pages/portfolio/props.type'

defineProps<PageProps>()

const emit = defineEmits<{
    (e: 'edit', item: any): void
}>()

const handleEdit = (item: Portfolio) => {
    emit('edit', item)
}
</script>

<template>
    <div class="space-y-3">
        <Search/>
        <Table :headers :items @edit="handleEdit"/>
        <Pagination v-if="items.length > 0" :pagination/>
    </div>
</template>
