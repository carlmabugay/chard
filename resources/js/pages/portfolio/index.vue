<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import DataTable from '@/pages/portfolio/components/data-table/index.vue'
import type { PageProps } from '@/pages/portfolio/props.type'
import PortfolioForm from '@/pages/portfolio/components/form/index.vue'
import { usePortfolioForm } from '@/pages/portfolio/composables/usePortfolioForm'

defineOptions({
    layout: [AppLayout, {
        title: 'Portfolio',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Portfolio' }]
    }],
})

defineProps<PageProps>()

const portfolioForm = usePortfolioForm()
</script>

<template>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold">Portfolios</h1>
            <p class="text-muted-foreground text-sm">Manage all portfolios here.</p>
        </div>
        <div>
            <PortfolioForm v-bind="portfolioForm"/>
        </div>
    </div>

    <DataTable :headers :items :pagination @edit="portfolioForm.openEdit"/>
</template>
