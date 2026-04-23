<script setup lang="ts">
import type { Props as PageProps } from '@/pages/strategy/props.type'
import Table from '@/pages/strategy/components/data-table/table/index.vue'
import Search from '@/pages/strategy/components/data-table/search/index.vue'
import Pagination from '@/pages/strategy/components/data-table/pagination/index.vue'

const props = defineProps<PageProps>()
</script>

<template>
    <div class="space-y-3">
        <Search/>
        <Table :strategies="props.strategies"/>
        <Pagination/>
    </div>


</template>
