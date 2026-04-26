<script setup lang="ts">
import Search from '@/components/shared/datatable/search/index.vue'
import Pagination from '@/components/shared/datatable/pagination/index.vue'
import Table from '@/pages/portfolio/components/data-table/table/index.vue'
import type { PageProps } from '@/pages/portfolio/props.type'

defineProps<PageProps>()
</script>

<template>
    <div class="space-y-3">
        <Search/>
        <Table :headers :items/>
        <Pagination :pagination/>
    </div>
</template>
