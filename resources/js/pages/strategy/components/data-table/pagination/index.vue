<script setup lang="ts">
import Label from '@/pages/strategy/components/data-table/pagination/label/index.vue'
import PageSize from '@/pages/strategy/components/data-table/pagination/page-size/index.vue'
import PaginationNumber from '@/pages/strategy/components/data-table/pagination/number/index.vue'
</script>

<template>
    <div class="flex items-center justify-between">
        <Label/>
        <div class="flex items-center justify-between space-x-6">
            <PageSize/>
            <PaginationNumber/>
        </div>
    </div>
</template>
