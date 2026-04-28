import { useForm } from '@inertiajs/vue3'

export function usePortfolioAction () {

    const portfolio = useForm({})

    const trash = (id: number) => {
        console.log(id)
        portfolio.delete(`/portfolio/${id}/trash`)
    }

    return {
        trash
    }
}
