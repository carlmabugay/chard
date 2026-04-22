<script setup lang="ts">

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { EllipsisIcon } from 'lucide-vue-next'
import { Input } from '@/components/ui/input'
import { Pagination, PaginationContent, PaginationItem, PaginationPrevious } from '@/components/ui/pagination'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Label } from '@/components/ui/label'
import { Checkbox } from '@/components/ui/checkbox'

defineProps({
    strategies: Object
})
</script>

<template>
    <div class="flex justify-between items-center">
        <Input placeholder="Search..." class="w-1/2"/>
    </div>
    <div class="overflow-hidden rounded-lg border">
        <Table>
            <TableHeader class="bg-muted">
                <TableRow>
                    <TableHead/>
                    <TableHead>Name</TableHead>
                    <TableHead>Date created</TableHead>
                    <TableHead/>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="strategy in strategies" :key="strategy.id">
                    <TableCell>
                        <Checkbox/>
                    </TableCell>
                    <TableCell>
                        {{ strategy.name }}
                    </TableCell>
                    <TableCell>
                        {{ strategy.created_at }}
                    </TableCell>
                    <TableCell>
                        <EllipsisIcon :size="14"/>
                    </TableCell>
                </TableRow>

            </TableBody>
        </Table>
    </div>
    <div class="flex justify-between items-center">
        <div class="flex justify-between items-center space-x-6">
            <div class="text-xs text-muted-foreground">
                Showing 1 to 8 of 980 results
            </div>
            <div class="flex justify-between items-center space-x-4">
                <Label class="text-xs font-normal text-muted-foreground">Rows per page</Label>
                <Select class="">
                    <SelectTrigger>
                        <SelectValue placeholder="10"/>
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="apple">
                                10
                            </SelectItem>
                            <SelectItem value="banana">
                                20
                            </SelectItem>
                            <SelectItem value="blueberry">
                                50
                            </SelectItem>
                            <SelectItem value="grapes">
                                All
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
        </div>

        <div class="flex content-end flex-col gap-6">
            <Pagination v-slot="{ page }" :items-per-page="10" :total="30" :default-page="2">
                <PaginationContent v-slot="{ items }">
                    <PaginationPrevious/>
                    <template v-for="(item, index) in items" :key="index">
                        <PaginationItem
                            v-if="item.type === 'page'"
                            :value="item.value"
                            :is-active="item.value === page"
                        >
                            {{ item.value }}
                        </PaginationItem>
                    </template>
                    <PaginationEllipsis :index="4"/>
                    <PaginationNext/>
                </PaginationContent>
            </Pagination>
        </div>
    </div>


</template>
