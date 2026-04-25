<script setup lang="ts">
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { PlusIcon } from 'lucide-vue-next'

const props = defineProps<{
    form: any
    isOpen: boolean
    isUpdate: boolean
    openCreate: () => void
    close: () => void
    submit: () => void
}>()

</script>

<template>
    <Dialog v-model:open="props.isOpen">
        <DialogTrigger as-child>
            <Button size="lg" @click="props.openCreate">
                <PlusIcon/>
                Add new
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-106">
            <DialogHeader>
                <DialogTitle>{{ props.isUpdate === true ? 'Edit strategy' : 'Create new strategy' }}</DialogTitle>
            </DialogHeader>
            <form @submit.prevent="props.submit" class="grid gap-4">
                <div class="grid gap-3">
                    <Label for="name">Name</Label>
                    <Input id="name" name="name" v-model="props.form.name"/>
                    <span v-if="props.form.errors.name" class="text-red-500 text-sm">{{ props.form.errors.name }}</span>
                </div>
                <DialogFooter>
                    <DialogClose>
                        <Button variant="outline" @click="close">
                            Cancel
                        </Button>
                    </DialogClose>
                    <Button as="button" :disabled="props.form.processing">
                        {{ props.isUpdate === true ? 'Update' : 'Create' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>


</template>
