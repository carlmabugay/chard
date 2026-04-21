<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import StrategyForm from '@/components/strategy/StrategyForm.vue'
import StrategyTable from '@/components/strategy/StrategyTable.vue'

defineOptions({
    layout: [AppLayout, {
        title: 'Strategy',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Strategy' }]
    }],
})

defineProps({
    strategies: Object
})
</script>

<template>
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold">Strategies</h1>
            <p class="text-muted-foreground text-sm">Manage all listed strategies here.</p>
        </div>
        <StrategyForm/>
    </div>

    <StrategyTable :strategies/>
</template>
