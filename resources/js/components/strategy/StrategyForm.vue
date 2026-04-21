<script setup lang="ts">

import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { PlusIcon } from 'lucide-vue-next'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const isOpen = ref(false)

const form = useForm({
    name: ''
})

const handleSubmit = () => {
    form.post('/strategy', {
        onSuccess: () => {
            form.reset('name')
            isOpen.value = false
        }
    })
}
</script>

<template>
    <div>
        <Dialog v-model:open="isOpen">
            <DialogTrigger as-child>
                <Button size="lg">
                    <PlusIcon/>
                    Add new
                </Button>
            </DialogTrigger>
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>Create new strategy</DialogTitle>
                </DialogHeader>
                <form @submit.prevent="handleSubmit()" class="grid gap-4">
                    <div class="grid gap-3">
                        <Label for="name">Name</Label>
                        <Input id="name" name="name" default-value="Trend Following" v-model="form.name"/>
                        <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
                    </div>
                    <DialogFooter>
                        <DialogClose as-child>
                            <Button variant="outline">
                                Cancel
                            </Button>
                        </DialogClose>
                        <Button as="button" :disabled="form.processing">
                            Save changes
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </div>

</template>
