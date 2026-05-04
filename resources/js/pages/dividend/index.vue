<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import DataTable from '@/pages/dividend/components/data-table/index.vue'
import type { PageProps } from '@/pages/dividend/props.type'

defineOptions({
    layout: [AppLayout, {
        title: 'Dividend',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Dividend' }]
    }],
})

defineProps<PageProps>()
</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold">Dividend</h1>
        <p class="text-muted-foreground text-sm">Manage all dividends here.</p>
    </div>
    <DataTable :headers :items :pagination/>
</template>
