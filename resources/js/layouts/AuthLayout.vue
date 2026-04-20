<script setup lang="ts">
import { Head } from '@inertiajs/vue3'

defineProps({ title: String })
</script>

<template>
    <Head :title="title"/>
    <div class="flex h-screen items-center justify-center px-6">
        <slot/>
    </div>

</template>
