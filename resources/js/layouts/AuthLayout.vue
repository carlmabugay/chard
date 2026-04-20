<script setup lang="ts">
import { Head } from '@inertiajs/vue3'

defineProps({ title: String })
</script>

<template>
    <Head :title="title"/>
    <div class="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
        <div class="w-full max-w-sm">
            <slot/>
        </div>
    </div>

</template>
