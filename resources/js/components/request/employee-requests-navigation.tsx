import { Link } from '@inertiajs/react';
import { ChevronRight, FileText, PlaneTakeoff, UsersRound } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarGroup,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/hooks/use-current-url';
import { index as familyVisits } from '@/routes/family-visits';
import { index as letters } from '@/routes/letters';
import { index as visas } from '@/routes/visas';
import type { NavItem } from '@/types';

export function EmployeeRequestsNavigation() {
    const { t } = useTranslation();
    const { isMobile, state } = useSidebar();
    const { isCurrentUrl } = useCurrentUrl();
    const requestItems: NavItem[] = [
        {
            title: t('Letter requests'),
            href: letters(),
            icon: FileText,
        },
        {
            title: t('Family visit requests'),
            href: familyVisits(),
            icon: UsersRound,
        },
        {
            title: t('Visa requests'),
            href: visas(),
            icon: PlaneTakeoff,
        },
    ];
    const isRequestActive = requestItems.some((item) =>
        isCurrentUrl(item.href),
    );

    if (state === 'collapsed' && !isMobile) {
        return (
            <CollapsedEmployeeRequestsNavigation
                isRequestActive={isRequestActive}
                items={requestItems}
            />
        );
    }

    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarMenu>
                <Collapsible
                    defaultOpen={isRequestActive}
                    className="group/requests"
                >
                    <SidebarMenuItem>
                        <CollapsibleTrigger asChild>
                            <SidebarMenuButton
                                isActive={isRequestActive}
                                tooltip={{ children: t('Requests') }}
                            >
                                <FileText />
                                <span>{t('Requests')}</span>
                                <ChevronRight className="ms-auto transition-transform group-data-[state=open]/requests:rotate-90 rtl:rotate-180 rtl:group-data-[state=open]/requests:-rotate-90" />
                            </SidebarMenuButton>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                            <SidebarMenuSub className="rtl:translate-x-0 rtl:border-r rtl:border-l-0">
                                {requestItems.map((item) => (
                                    <SidebarMenuSubItem key={item.title}>
                                        <SidebarMenuSubButton
                                            asChild
                                            isActive={isCurrentUrl(item.href)}
                                        >
                                            <Link href={item.href} prefetch>
                                                {item.icon ? (
                                                    <item.icon />
                                                ) : null}
                                                <span>{item.title}</span>
                                            </Link>
                                        </SidebarMenuSubButton>
                                    </SidebarMenuSubItem>
                                ))}
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>
            </SidebarMenu>
        </SidebarGroup>
    );
}

function CollapsedEmployeeRequestsNavigation({
    isRequestActive,
    items,
}: {
    isRequestActive: boolean;
    items: NavItem[];
}) {
    const { i18n, t } = useTranslation();

    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarMenu>
                <SidebarMenuItem>
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <SidebarMenuButton
                                isActive={isRequestActive}
                                tooltip={{ children: t('Requests') }}
                            >
                                <FileText />
                                <span>{t('Requests')}</span>
                            </SidebarMenuButton>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent
                            side={i18n.dir() === 'rtl' ? 'left' : 'right'}
                            align="start"
                        >
                            {items.map((item) => (
                                <DropdownMenuItem key={item.title} asChild>
                                    <Link href={item.href} prefetch>
                                        {item.icon ? <item.icon /> : null}
                                        <span>{item.title}</span>
                                    </Link>
                                </DropdownMenuItem>
                            ))}
                        </DropdownMenuContent>
                    </DropdownMenu>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroup>
    );
}
