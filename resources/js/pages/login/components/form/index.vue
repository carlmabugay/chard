<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import {
    Field,
    FieldGroup,
    FieldLabel,
} from '@/components/ui/field'
import { Input } from '@/components/ui/input'
import { Checkbox } from '@/components/ui/checkbox'

const props = defineProps<{
    class?: HTMLAttributes['class']
}>()

interface LoginForm {
    email: string | number | undefined,
    password: string | number | undefined,
    remember: boolean
}

const form = useForm<LoginForm>({
    email: '',
    password: '',
    remember: false,
})
</script>

<template>
    <div :class="cn('flex flex-col gap-6', props.class)">
        <Card>
            <CardHeader>
                <CardTitle>Welcome to Chard</CardTitle>
                <CardDescription>
                    Enter your email below to login to your account
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="form.post('/login')">
                    <FieldGroup>
                        <Field>
                            <FieldLabel for="email">
                                Email
                            </FieldLabel>
                            <Input
                                id="email"
                                type="email"
                                placeholder="m@example.com"
                                required
                                v-model="form.email"
                            />
                            <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                        </Field>
                        <Field>
                            <div class="flex items-center">
                                <FieldLabel for="password">
                                    Password
                                </FieldLabel>
                            </div>
                            <Input id="password" type="password" required v-model="form.password"/>
                            <span v-if="form.errors.password" class="text-red-500 text-sm">{{
                                    form.errors.password
                                }}</span>
                        </Field>
                        <Field orientation="horizontal">
                            <Checkbox id="remember" v-model="form.remember"/>
                            <FieldLabel
                                for="remember"
                                class="font-normal"
                            >
                                Remember Me
                            </FieldLabel>
                        </Field>
                        <Field>
                            <Button as="button" size="lg" :disabled="form.processing">
                                Login
                            </Button>
                        </Field>
                    </FieldGroup>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
