<script setup lang="ts">
import { ChevronFirstIcon, ChevronLeftIcon, ChevronRightIcon, ChevronLastIcon } from 'lucide-vue-next'
import { Pagination, PaginationContent, PaginationItem, PaginationPrevious } from '@/components/ui/pagination'
import type { PaginationNumberProps } from '@/pages/strategy/props.type'
import { useDataTable } from '@/pages/strategy/composables/useDataTable'

type Props = PaginationNumberProps & { total: number }

defineProps<Props>()

const { updateQuery } = useDataTable()

const goToPage = (page: number) => updateQuery({ page })
</script>

<template>
    <Pagination
        v-slot="{ page }"
        :items-per-page="per_page"
        :total
        :default-page="current_page"
        @update:page="goToPage"
        class="text-muted-foreground"
    >
        <PaginationContent v-slot="{ items }">

            <PaginationFirst>
                <ChevronFirstIcon class="size-4"/>
            </PaginationFirst>

            <PaginationPrevious>
                <ChevronLeftIcon class="size-4"/>
            </PaginationPrevious>

            <template v-for="(item, index) in items" :key="index">
                <PaginationItem
                    v-if="item.type === 'page'"
                    :value="item.value"
                    :is-active="item.value === page"
                    size="sm"
                    @click="goToPage(item.value)"
                >
                    {{ item.value }}
                </PaginationItem>
            </template>

            <PaginationNext>
                <ChevronRightIcon class="size-4"/>
            </PaginationNext>

            <PaginationLast>
                <ChevronLastIcon class="size-4"/>
            </PaginationLast>
        </PaginationContent>
    </Pagination>
</template>
