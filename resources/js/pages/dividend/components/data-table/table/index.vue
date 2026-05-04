<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table'
import DataTableHeader from '@/components/shared/datatable/header/index.vue'
import { EllipsisIcon, SquarePenIcon, Trash2Icon, XCircleIcon } from 'lucide-vue-next'
import type { HeadersProps } from '@/components/shared/datatable/props.type'
import type { DividendProps } from '@/pages/dividend/props.type'

type Props = HeadersProps & DividendProps

defineProps<Props>()

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
                                    <DropdownMenuItem>
                                        <SquarePenIcon :size="4"/>
                                        Edit
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>
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
                            No dividend found.
                        </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>
</template>
