<script setup lang="ts">
import Label from '@/components/shared/datatable/pagination/label/index.vue'
import PageSize from '@/components/shared/datatable/pagination/size/index.vue'
import PaginationNumber from '@/components/shared/datatable/pagination/number/index.vue'
import type { PaginationProps } from '@/components/shared/datatable/props.type'

defineProps<PaginationProps>()

</script>

<template>
    <div class="flex items-center justify-between">
        <Label
            :to="pagination.to"
            :from="pagination.from"
            :total="pagination.to"
        />
        <div class="flex items-center justify-between space-x-6">
            <PageSize/>
            <PaginationNumber
                :per_page="pagination.per_page"
                :current_page="pagination.current_page"
                :total="pagination.total"
            />
        </div>
    </div>
</template>
