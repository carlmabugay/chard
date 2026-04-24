<script setup lang="ts">
import Table from '@/pages/strategy/components/data-table/table/index.vue'
import Search from '@/pages/strategy/components/data-table/search/index.vue'
import Pagination from '@/pages/strategy/components/data-table/pagination/index.vue'
import type { PageProps } from '@/pages/strategy/props.type'

defineProps<PageProps>()
</script>

<template>
    <div class="space-y-3">
        <Search/>
        <Table :items="result.data"/>
        <Pagination
            :to="result.to"
            :from="result.from"
            :total="result.total"
            :current_page="result.current_page"
            :per_page="result.per_page"
        />
    </div>
</template>
