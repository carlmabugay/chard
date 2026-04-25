<script setup lang="ts">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { EllipsisIcon, SquarePenIcon, Trash2Icon, XCircleIcon } from 'lucide-vue-next'
import { Checkbox } from '@/components/ui/checkbox'
import type { StrategiesProps } from '@/pages/strategy/props.type'
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem } from '@/components/ui/dropdown-menu'

defineProps<StrategiesProps>()

const emit = defineEmits<{
    (e: 'edit', item: any): void
}>()
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

                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <EllipsisIcon :size="18"/>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent class="w-20">
                                <DropdownMenuItem @click="emit('edit', item)">
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
