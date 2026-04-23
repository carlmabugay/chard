<script setup lang="ts">

import { Pagination, PaginationContent, PaginationItem, PaginationPrevious } from '@/components/ui/pagination'
</script>

<template>
    <Pagination v-slot="{ page }" :items-per-page="10" :total="30" :default-page="2" class="text-muted-foreground">
        <PaginationContent v-slot="{ items }">
            <PaginationPrevious/>
            <template v-for="(item, index) in items" :key="index">
                <PaginationItem
                    v-if="item.type === 'page'"
                    :value="item.value"
                    :is-active="item.value === page"
                    size="sm"
                >
                    {{ item.value }}
                </PaginationItem>
            </template>
            <PaginationEllipsis :index="4"/>
            <PaginationNext/>
        </PaginationContent>
    </Pagination>
</template>
