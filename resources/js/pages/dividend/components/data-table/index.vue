<script setup lang="ts">
import Search from '@/components/shared/datatable/search/index.vue'
import Pagination from '@/components/shared/datatable/pagination/index.vue'
import Table from '@/pages/dividend/components/data-table/table/index.vue'
import type { PageProps } from '@/pages/dividend/props.type'

defineProps<PageProps>()
</script>

<template>
    <div class="space-y-3">
        <Search/>
        <Table :headers :items/>
        <Pagination v-if="items.length > 0" :pagination/>
    </div>
</template>
