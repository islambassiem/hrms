import { Link } from '@inertiajs/react';
import { Award, CalendarClock, CalendarDays, LayoutGrid } from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { EmployeeRequestsNavigation } from '@/components/request/employee-requests-navigation';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { index as leave } from '@/routes/leave';
import { index as qualifications } from '@/routes/qualifications';
import { index as shortLeaves } from '@/routes/short-leaves';
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
            title: t('Leave'),
            href: leave(),
            icon: CalendarDays,
        },
        {
            title: t('Short Leave'),
            href: shortLeaves(),
            icon: CalendarClock,
        },
        {
            title: t('Qualifications'),
            href: qualifications(),
            icon: Award,
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
                <EmployeeRequestsNavigation />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
