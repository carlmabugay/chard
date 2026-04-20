<script setup lang="ts">
import LoginForm from '@/components/LoginForm.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'

defineOptions({
    layout: [AuthLayout, { title: 'Login' }],
})
</script>

<template>
    <LoginForm/>
</template>
