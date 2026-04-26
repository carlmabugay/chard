<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import StrategyForm from '@/pages/strategy/components/form/index.vue'
import DataTable from '@/pages/strategy/components/data-table/index.vue'
import { useStrategyForm } from '@/pages/strategy/composables/useStrategyForm'
import type { PageProps } from '@/pages/strategy/props.type'

defineOptions({
    layout: [AppLayout, {
        title: 'Strategy',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Strategy' }]
    }],
})

defineProps<PageProps>()

const strategyForm = useStrategyForm()
</script>

<template>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold">Strategies</h1>
            <p class="text-muted-foreground text-sm">Manage all listed strategies here.</p>
        </div>

        <div>
            <StrategyForm v-bind="strategyForm"/>
        </div>

    </div>
    <DataTable :headers :items :pagination @edit="strategyForm.openEdit"/>
</template>
