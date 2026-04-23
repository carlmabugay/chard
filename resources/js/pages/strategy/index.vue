<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { Props as PageProps } from '@/pages/strategy/props.type'
import StrategyForm from '@/components/strategy/StrategyForm.vue'
import DataTable from '@/pages/strategy/components/data-table/index.vue'

defineOptions({
    layout: [AppLayout, {
        title: 'Strategy',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Strategy' }]
    }],
})

const props = defineProps<PageProps>()
</script>

<template>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold">Strategies</h1>
            <p class="text-muted-foreground text-sm">Manage all listed strategies here.</p>
        </div>
        <StrategyForm/>
    </div>
    <DataTable :strategies="props.strategies"/>
</template>
