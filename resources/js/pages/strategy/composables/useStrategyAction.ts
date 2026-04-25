import { useForm } from '@inertiajs/vue3'

export function useStrategyAction () {

    const strategy = useForm({})

    const trash = (id: number) => {
        strategy.delete(`/strategy/${id}/trash`)
    }

    return {
        trash
    }
}
