<script setup lang="ts">
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar'

const data = {
    navMain: [
        {
            title: 'Dashboard',
            url: '/dashboard',
        },
        {
            title: 'Portfolio',
            url: '/portfolio',
        },
        {
            title: 'Strategy',
            url: '/strategy',
        },
        {
            title: 'Cash Flow',
            url: '/cash-flow',
        },
        {
            title: 'Trade Log',
            url: '#',
        },
        {
            title: 'Dividend',
            url: '/dividend',
        },

    ],
}
</script>

<template>
    <Sidebar collapsible="offcanvas">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton
                        as-child
                        class="data-[slot=sidebar-menu-button]:!p-1.5"
                    >
                        <a href="#">
                            <span class="text-base font-semibold">Chard</span>
                        </a>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>
        <SidebarContent>
            <NavMain :items="data.navMain"/>
        </SidebarContent>
        <SidebarFooter>
            <NavUser/>
        </SidebarFooter>
    </Sidebar>
</template>
