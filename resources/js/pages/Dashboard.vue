<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

const user = usePage().props.auth.user
</script>

<template>
    {{ user.name }}
    <Button @click="router.post('/logout')">Logout</Button>
</template>

