<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'

defineOptions({
    layout: [AppLayout, {
        title: 'Dashboard',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }]
    }],
})

</script>

<template>
    <div>Hello!</div>
</template>

