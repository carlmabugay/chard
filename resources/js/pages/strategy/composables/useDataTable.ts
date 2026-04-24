import { router, usePage } from '@inertiajs/vue3'
import { computed, reactive, watch } from 'vue'

const query = reactive({
    search: '' as string | null,
    page: '' as string | null,
})

export function useDataTable () {
    const page = usePage()

    const syncFromUrl = () => {
        const url = new URL(page.url, window.location.origin)
        const params = url.searchParams

        query.search = params.get('search')
        query.page = params.get('page')

    }

    const filteredQuery = computed(() => {
        const result: Record<string, any> = {}

        for (const [key, value] of Object.entries(query)) {
            if (Array.isArray(value)) {
                if (value.length > 0) result[key] = value.join(',')
            } else if (value !== '' && value != null) {
                result[key] = value
            }
        }

        return result
    })

    const updateQuery = (newValues: unknown) => {
        Object.assign(query, newValues)

        router.get(window.location.pathname, filteredQuery.value, {
            preserveState: true,
            replace: true,
        })
    }

    const search = (term: unknown) => {
        updateQuery({ search: term })
    }

    const clear = () => {
        updateQuery({ search: '' })
    }

    const reset = () => {
        updateQuery({ search: '', types: [], benefits: [] })
    }

    watch(
        () => page.url,
        () => {
            syncFromUrl()
        },
        { immediate: true },
    )

    return {
        query,
        search,
        clear,
        reset,
        updateQuery,
    }
}
