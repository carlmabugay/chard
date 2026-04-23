<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'

defineOptions({
    layout: [AppLayout, {
        title: 'Trade Log',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Trade Log' }]
    }],
})

</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold">Trade Log</h1>
        <p class="text-muted-foreground text-sm">Manage all trade logs here.</p>
    </div>
</template>
