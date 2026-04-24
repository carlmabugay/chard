<script setup lang="ts">

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { EllipsisIcon } from 'lucide-vue-next'
import { Checkbox } from '@/components/ui/checkbox'
import type { StrategiesProps } from '@/pages/strategy/props.type'

defineProps<StrategiesProps>()
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
                <TableRow v-for="item in items" :key="item.id">
                    <TableCell>
                        <Checkbox/>
                    </TableCell>
                    <TableCell>
                        {{ item.name }}
                    </TableCell>
                    <TableCell>
                        {{ item.created_at }}
                    </TableCell>
                    <TableCell>
                        <EllipsisIcon :size="14"/>
                    </TableCell>
                </TableRow>

            </TableBody>
        </Table>
    </div>
</template>
