<script setup lang="ts">

import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Label } from '@/components/ui/label'
</script>

<template>
    <div class="flex items-center space-x-2">
        <Label class="flex-none text-xs font-normal text-muted-foreground">Show up to:</Label>
        <Select>
            <SelectTrigger size="sm">
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
</template>
