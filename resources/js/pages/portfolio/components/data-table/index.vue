<script setup lang="ts">

import Table from '@/pages/portfolio/components/data-table/table/index.vue'
import { PageProps } from '@/pages/portfolio/props.type'
import Pagination from '@/pages/portfolio/components/data-table/pagination/index.vue'

defineProps<PageProps>()
</script>

<template>
    <div class="space-y-3">
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
