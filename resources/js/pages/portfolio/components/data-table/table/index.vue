<script setup lang="ts">

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { EllipsisIcon, SquarePenIcon, Trash2Icon, XCircleIcon } from 'lucide-vue-next'
import { Checkbox } from '@/components/ui/checkbox'
import type { HeadersProps } from '@/components/shared/datatable/props.type'
import type { PortfolioProps } from '@/pages/portfolio/props.type'
import DataTableHeader from '@/components/shared/datatable/header/index.vue'

type Props = HeadersProps & PortfolioProps

defineProps<Props>()
</script>

<template>
    <div class="overflow-hidden rounded-lg border">
        <Table>
            <DataTableHeader :headers/>
            <TableBody>
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

            </TableBody>
        </Table>
    </div>
</template>
