<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import { Card, CardContent, CardHeader } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Field, FieldGroup, FieldLabel, FieldSeparator } from '@/components/ui/field'
import { Checkbox } from '@/components/ui/checkbox'
import { Button } from '@/components/ui/button'
import { useForm } from '@inertiajs/vue3'

defineOptions({
    layout: [AuthLayout, { title: 'Login' }],
})

const form = useForm({
    email: null,
    password: null,
    remember: false,
})
</script>

<template>
    <Card class="w-xl">
        <CardHeader>
            <h1 class="text-2xl font-semibold">Welcome to Chard</h1>
            <p>Login to your account</p>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="form.post('/login')">
                <FieldGroup>
                    <Field>
                        <FieldLabel for="email">Email</FieldLabel>
                        <Input type="text" id="email" placeholder="admin@carlmabugay.dev" v-model="form.email"/>
                        <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                    </Field>
                    <Field>
                        <FieldLabel for="password">Password</FieldLabel>
                        <Input type="password" id="password" v-model="form.password"/>
                        <span v-if="form.errors.password" class="text-red-500 text-sm">{{
                                form.errors.password
                            }}</span>
                    </Field>
                </FieldGroup>
                <FieldGroup class="mt-6">
                    <Field orientation="horizontal">
                        <Checkbox id="remember" v-model="form.remember"/>
                        <FieldLabel
                            for="remember"
                            class="font-normal"
                        >
                            Remember Me
                        </FieldLabel>
                    </Field>
                </FieldGroup>
                <FieldGroup class="mt-6">
                    <Field orientation="horizontal">
                        <Button as="button" size="lg">
                            Login
                        </Button>
                    </Field>
                </FieldGroup>
            </form>
        </CardContent>
    </Card>
</template>
