<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import DataTable from '@/pages/portfolio/components/data-table/index.vue'
import type { PageProps } from '@/pages/portfolio/props.type'

defineOptions({
    layout: [AppLayout, {
        title: 'Portfolio',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Portfolio' }]
    }],
})

defineProps<PageProps>()

</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold">Portfolios</h1>
        <p class="text-muted-foreground text-sm">Manage all portfolios here.</p>
    </div>
    <DataTable :headers :items :pagination/>
</template>
