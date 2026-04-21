<script setup lang="ts">

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { EllipsisVerticalIcon } from 'lucide-vue-next'

defineProps({
    strategies: Object
})
</script>

<template>
    <div class="overflow-hidden rounded-lg border">
        <Table>
            <TableHeader class="bg-muted">
                <TableRow>
                    <TableHead>
                        Name
                    </TableHead>
                    <TableHead>Date created</TableHead>
                    <TableHead></TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="strategy in strategies" :key="strategy.id">
                    <TableCell>
                        {{ strategy.name }}
                    </TableCell>
                    <TableCell>
                        {{ strategy.created_at }}
                    </TableCell>
                    <TableCell>
                        <EllipsisVerticalIcon/>
                    </TableCell>
                </TableRow>

            </TableBody>
        </Table>
    </div>
</template>
