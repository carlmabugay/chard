<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import DataTable from '@/pages/cash-flow/components/data-table/index.vue'
import type { PageProps } from '@/pages/cash-flow/props.type'

defineOptions({
    layout: [AppLayout, {
        title: 'Cash Flow',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Cash Flow' }]
    }],
})

defineProps<PageProps>()

</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold">Cash Flows</h1>
        <p class="text-muted-foreground text-sm">Manage all cash flows here.</p>
    </div>
    <DataTable :headers :items :pagination/>
</template>
