<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import AppLayout from '@/layouts/AppLayout.vue'

defineOptions({
    layout: [AppLayout, { title: 'Dashboard' }],
})

</script>

<template>
    <div>Hello!</div>
</template>

