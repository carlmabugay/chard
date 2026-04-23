<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'

defineOptions({
    layout: [AppLayout, {
        title: 'Dividend',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Dividend' }]
    }],
})

</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold">Dividend</h1>
        <p class="text-muted-foreground text-sm">Manage all dividends here.</p>
    </div>
</template>
