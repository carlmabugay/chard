<script setup lang="ts">

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { EllipsisIcon } from 'lucide-vue-next'
import { Checkbox } from '@/components/ui/checkbox'
import type { Props as PageProps } from '@/pages/strategy/props.type'

const props = defineProps<PageProps>()
</script>

<template>
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
</template>
