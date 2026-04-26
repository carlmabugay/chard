<script setup lang="ts">
import { Input } from '@/components/ui/input'
import { useDataTable } from '@/composables/useDataTable'
import { ref } from 'vue'
import { SearchIcon, XCircleIcon } from 'lucide-vue-next'

const { query, search, clear } = useDataTable()

const term = ref<string | number | undefined>(query.search)

const clearSearch = () => {
    clear()
    term.value = ''
}
</script>

<template>
    <div>
        <form @submit.prevent="search(term)" class="relative w-1/3">
            <Input v-model="term" type="text" placeholder="Search..." class="pl-10"/>
            <span class="absolute inset-y-0 inset-s-0 flex items-center justify-center pl-4 pr-2">
                <SearchIcon class="size-4"/>
            </span>
            <span class="absolute inset-y-0 inset-e-0 flex items-center justify-center px-4">
                 <XCircleIcon v-if="term" @click="clearSearch" class="size-4 hover:cursor-pointer"/>
            </span>

        </form>

    </div>
</template>
