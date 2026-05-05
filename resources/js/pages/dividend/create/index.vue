<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { PageProps } from '@/pages/cash-flow/props.type'
import { Field, FieldGroup, FieldLabel } from '@/components/ui/field'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { useForm } from '@inertiajs/vue3'

defineOptions({
    layout: [AppLayout, {
        title: 'Cash Flow',
        breadcrumbs: [{ label: 'Dashboard', url: '/dashboard' }, {
            label: 'Dividend',
            url: '/dividend',
        }, { label: 'Create' }],
    }],
})

defineProps<PageProps>()

const form = useForm<{
    portfolio_id: number,
    symbol: string | null,
    amount: number | null,
}>({
    portfolio_id: 1, // to be replaced
    symbol: null,
    amount: null,
})

</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold mb-4">Create new dividend</h1>
        <div class="w-1/3">
            <form @submit.prevent="form.post('/dividend')">
                <FieldGroup>
                    <Field>
                        <FieldLabel for="symbol">
                            Symbol
                        </FieldLabel>
                        <Input
                            id="symbol"
                            type="text"
                            v-model="form.symbol"
                        />
                        <span v-if="form.errors.symbol" class="text-red-500 text-sm">{{ form.errors.symbol }}</span>
                    </Field>
                    <Field>
                        <FieldLabel for="amount">
                            Amount
                        </FieldLabel>
                        <Input
                            id="amount"
                            type="text"
                            v-model="form.amount"
                        />
                        <span v-if="form.errors.amount" class="text-red-500 text-sm">{{ form.errors.amount }}</span>
                    </Field>
                    <Field>
                        <Button as="button" size="lg" :disabled="form.processing">
                            Save
                        </Button>
                    </Field>
                </FieldGroup>
            </form>
        </div>

    </div>
</template>
