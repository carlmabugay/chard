<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox'
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem } from '@/components/ui/dropdown-menu'
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table'
import DataTableHeader from '@/components/shared/datatable/header/index.vue'
import { EllipsisIcon, SquarePenIcon, Trash2Icon, XCircleIcon } from 'lucide-vue-next'
import type { StrategiesProps, Strategy } from '@/pages/strategy/props.type'
import type { HeadersProps } from '@/components/shared/datatable/props.type'
import { useStrategyAction } from '@/pages/strategy/composables/useStrategyAction'

type Props = HeadersProps & StrategiesProps

defineProps<Props>()

const { trash } = useStrategyAction()

const emit = defineEmits<{
    (e: 'edit', item: Strategy): void
}>()
</script>

<template>
    <div class="overflow-hidden rounded-lg border">
        <Table>
            <DataTableHeader :headers/>
            <TableBody>
                <template v-if="items.length > 0">
                    <TableRow v-for="(row, rowIndex) in items" :key="rowIndex">
                        <TableCell>
                            <Checkbox/>
                        </TableCell>
                        <TableCell v-for="header in headers" :key="header.key">
                            <slot :name="`cell-${header.key}`" :row="row" :value="row[header.key]">
                                {{ row[header.key] }}
                            </slot>
                        </TableCell>
                        <TableCell>
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <EllipsisIcon :size="18"/>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent class="w-20">
                                    <DropdownMenuItem @click="emit('edit', row)">
                                        <SquarePenIcon :size="4"/>
                                        Edit
                                    </DropdownMenuItem>
                                    <DropdownMenuItem @click="trash(row['id'])">
                                        <Trash2Icon :size="4"/>
                                        Trash
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>
                                        <XCircleIcon :size="4"/>
                                        Delete
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                </template>
                <template v-else>
                    <TableRow>
                        <TableCell colspan="6" class="text-center p-3">
                            No strategy found.
                        </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>
</template>
