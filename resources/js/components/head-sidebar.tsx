import { Link } from '@inertiajs/react';
import {
    CalendarDays,
    ClipboardList,
    LayoutGrid,
    UsersRound,
} from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes/head';
import { index as employees } from '@/routes/head/employees';
import { index as leaveRequests } from '@/routes/head/leaves';
import { index as shortLeaveRequests } from '@/routes/head/short-leaves';
import type { NavItem } from '@/types';
import { useTranslation } from 'react-i18next';

export function AppSidebar() {
    const { t, i18n } = useTranslation();

    const mainNavItems: NavItem[] = [
        {
            title: t('Dashboard'),
            href: dashboard(),
            icon: LayoutGrid,
        },
        {
            title: t('Employees'),
            href: employees(),
            icon: UsersRound,
        },
        {
            title: t('Leave Requests'),
            href: leaveRequests(),
            icon: CalendarDays,
        },
        {
            title: t('Short Leave Requests'),
            href: shortLeaveRequests(),
            icon: ClipboardList,
        },
    ];

    return (
        <Sidebar
            side={i18n.dir() === 'rtl' ? 'right' : 'left'}
            collapsible="icon"
            variant="inset"
        >
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
