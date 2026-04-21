<script setup lang="ts">
import { Separator } from '@/components/ui/separator'
import { SidebarTrigger } from '@/components/ui/sidebar'
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb'

defineProps<{
    breadcrumbs: object,
}>()
</script>

<template>
    <header
        class="flex h-(--header-height) shrink-0 items-center gap-2 border-b transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-(--header-height)">
        <div class="flex w-full items-center gap-1 px-4 lg:gap-2 lg:px-6">
            <SidebarTrigger class="-ml-1"/>
            <Separator
                orientation="vertical"
                class="mx-2 data-[orientation=vertical]:h-4"
            />
            <Breadcrumb v-if="breadcrumbs">
                <BreadcrumbList>
                    <template v-for="breadcrumb in breadcrumbs" :key="breadcrumb.label">
                        <BreadcrumbItem>
                            <BreadcrumbLink :href="breadcrumb.url">
                                {{ breadcrumb.label }}
                            </BreadcrumbLink>
                        </BreadcrumbItem>
                        <BreadcrumbSeparator/>
                    </template>

                </BreadcrumbList>
            </Breadcrumb>
        </div>
    </header>
</template>
