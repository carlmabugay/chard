<script setup lang="ts">
import Table from '@/pages/strategy/components/data-table/table/index.vue'
import Search from '@/components/shared/datatable/search/index.vue'
import Pagination from '@/components/shared/datatable/pagination/index.vue'
import type { PageProps } from '@/pages/strategy/props.type'

defineProps<PageProps>()

const emit = defineEmits<{
    (e: 'edit', item: any): void
}>()

const handleEdit = (item) => {
    emit('edit', item)
}
</script>

<template>
    <div class="space-y-3">
        <Search/>
        <Table :headers :items @edit="handleEdit"/>
        <Pagination :pagination/>
    </div>
</template>
