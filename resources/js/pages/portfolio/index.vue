<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'

defineOptions({
    layout: [AppLayout, {
        title: 'Portfolio',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Portfolio' }]
    }],
})

</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold">Portfolios</h1>
        <p class="text-muted-foreground text-sm">Manage all portfolios here.</p>
    </div>
</template>
