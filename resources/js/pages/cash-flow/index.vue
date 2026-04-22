<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'

defineOptions({
    layout: [AppLayout, {
        title: 'Cash Flow',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, { label: 'Cash Flow' }]
    }],
})

</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold">Cash Flows</h1>
        <p class="text-muted-foreground text-sm">Manage all cash flows here.</p>
    </div>
</template>
