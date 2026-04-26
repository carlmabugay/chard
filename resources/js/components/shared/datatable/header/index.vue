<script setup lang="ts">
import { TableHead, TableHeader, TableRow } from '@/components/ui/table'
import type { HeadersProps } from '@/components/shared/datatable/props.type'

defineProps<HeadersProps>()
</script>

<template>
    <TableHeader class="bg-muted">
        <TableRow>
            <TableHead/>
            <TableHead v-for="header in headers" :key="header.key">
                {{ header.label }}
            </TableHead>
            <TableHead/>
        </TableRow>
    </TableHeader>
</template>

