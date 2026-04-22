<script setup lang="ts">
import {
    SidebarInset,
    SidebarProvider,
} from '@/components/ui/sidebar'
import SiteHeader from '@/components/SiteHeader.vue'
import AppSidebar from '@/components/AppSidebar.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { toast } from 'vue-sonner'
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'
import { watch } from 'vue'

interface Props {
    title: string
    breadcrumbs: object,
}

const props = defineProps<Props>()

const page = usePage()

watch(() => page.props.flash, (flash) => {
    if (flash?.success) {
        toast.success(flash.success)
    }
}, { deep: true })
</script>

<template>
    <Head :title="title"/>
    <Toaster position="top-center"/>
    <SidebarProvider
        :style=" {
      '--sidebar-width': 'calc(var(--spacing) * 72)',
      '--header-height': 'calc(var(--spacing) * 12)',
    }"
    >
        <AppSidebar variant="inset"/>
        <SidebarInset>
            <SiteHeader :breadcrumbs/>
            <div class="flex flex-1 flex-col">
                <div class="@container/main flex flex-1 flex-col gap-2">
                    <div class="flex flex-col gap-4 p-4 md:gap-6 md:py-6">
                        <slot/>
                    </div>
                </div>
            </div>
        </SidebarInset>
    </SidebarProvider>
</template>
