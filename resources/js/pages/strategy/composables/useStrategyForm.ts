import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

export function useStrategyForm () {
    const isOpen = ref(false)

    const strategyForm = useForm({
        id: null as number | null,
        name: '',
    })

    const isUpdate = computed(() => !!strategyForm.id)

    const openCreate = () => {
        strategyForm.reset()
        strategyForm.clearErrors()
        strategyForm.id = null
        isOpen.value = true
    }

    const openEdit = (item: { id: number; name: string }) => {
        strategyForm.id = item.id
        strategyForm.name = item.name
        strategyForm.clearErrors()
        isOpen.value = true
    }

    const close = () => {
        strategyForm.clearErrors()
        isOpen.value = false
    }

    const submit = () => {
        if (isUpdate.value) {
            strategyForm.put(`/strategy/${strategyForm.id}`, {
                onSuccess: closeAndReset
            })
        } else {
            strategyForm.post('/strategy', {
                onSuccess: closeAndReset
            })
        }
    }

    const closeAndReset = () => {
        strategyForm.reset()
        isOpen.value = false
    }

    return {
        form: strategyForm,
        isOpen,
        isUpdate,
        openCreate,
        openEdit,
        close,
        submit,
    }
}
