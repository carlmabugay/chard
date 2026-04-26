<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import LoginForm from '@/pages/login/components/form/index.vue'

defineOptions({
    layout: [AuthLayout, { title: 'Login' }],
})
</script>

<template>
    <LoginForm/>
</template>
