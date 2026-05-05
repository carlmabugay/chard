import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

export function usePortfolioForm () {
    const isOpen = ref(false)

    const portfolioForm = useForm({
        id: null as number | null,
        name: '',
    })

    const isUpdate = computed(() => !!portfolioForm.id)

    const openCreate = () => {
        portfolioForm.reset()
        portfolioForm.clearErrors()
        portfolioForm.id = null
        isOpen.value = true
    }

    const openEdit = (item: { id: number; name: string }) => {
        portfolioForm.id = item.id
        portfolioForm.name = item.name
        portfolioForm.clearErrors()
        isOpen.value = true
    }

    const close = () => {
        portfolioForm.clearErrors()
        isOpen.value = false
    }

    const submit = () => {
        if (isUpdate.value) {
            portfolioForm.put(`/portfolio/${portfolioForm.id}`, {
                onSuccess: closeAndReset
            })
        } else {
            portfolioForm.post('/portfolio', {
                onSuccess: closeAndReset
            })
        }
    }

    const closeAndReset = () => {
        portfolioForm.reset()
        isOpen.value = false
    }

    return {
        form: portfolioForm,
        isOpen,
        isUpdate,
        openCreate,
        openEdit,
        close,
        submit,
    }
}
