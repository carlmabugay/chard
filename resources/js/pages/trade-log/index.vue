<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import DataTable from '@/pages/trade-log/components/data-table/index.vue'
import type { PageProps } from '@/pages/trade-log/props.type'

defineOptions({
    layout: [AppLayout, {
        title: 'Trade Log',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Trade Log' }]
    }],
})

defineProps<PageProps>()
</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold">Trade Log</h1>
        <p class="text-muted-foreground text-sm">Manage all trade logs here.</p>
    </div>
    <DataTable :headers :items :pagination/>
</template>
