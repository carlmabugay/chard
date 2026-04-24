<script setup lang="ts">
import type { PaginationLabelProps } from '@/pages/strategy/props.type'

defineProps<PaginationLabelProps>()
</script>

<template>
    <div class="text-xs text-muted-foreground">
        Showing {{ from }} to {{ to }} of {{ total }} results
    </div>
</template>

