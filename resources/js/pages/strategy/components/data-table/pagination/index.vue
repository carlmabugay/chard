<script setup lang="ts">
import Label from '@/pages/strategy/components/data-table/pagination/label/index.vue'
import PageSize from '@/pages/strategy/components/data-table/pagination/page-size/index.vue'
import PaginationNumber from '@/pages/strategy/components/data-table/pagination/number/index.vue'
import type { PaginationLabelProps, PaginationNumberProps } from '@/pages/strategy/props.type'

type Props = PaginationLabelProps & PaginationNumberProps;

defineProps<Props>()

</script>

<template>
    <div class="flex items-center justify-between">
        <Label
            :to
            :from
            :total
        />
        <div class="flex items-center justify-between space-x-6">
            <PageSize/>
            <PaginationNumber
                :per_page
                :current_page
                :total
            />
        </div>
    </div>
</template>
