<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

defineProps({ title: String })

const user = usePage().props.auth.user
</script>

<template>
    <Head :title="title"/>

    <nav class="relative bg-black mb-6">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex items-center space-x-6">
                    <p class="text-primary">{{ user.name }}</p>
                    <Button @click="router.post('/logout')">Logout</Button>
                </div>
            </div>
        </div>
    </nav>

    <div class="mx-auto max-w-7xl">
        <slot/>
    </div>
</template>
