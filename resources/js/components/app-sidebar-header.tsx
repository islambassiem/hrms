import { Breadcrumbs } from '@/components/breadcrumbs';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types';
import { SpaceSwitcher } from './space-switcher';
import AppearanceSwitcher from './appearance-switcher';
import LanguageSwitcher from './locale-switcher';

export function AppSidebarHeader({
    breadcrumbs = [],
}: {
    breadcrumbs?: BreadcrumbItemType[];
}) {
    return (
        <header className="border-sidebar-border/50 flex h-16 shrink-0 items-center justify-between gap-1 border-b px-4 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 sm:gap-2">
            <div className="flex min-w-0 items-center justify-between gap-2">
                <SidebarTrigger className="-ml-1" />

                <Breadcrumbs breadcrumbs={breadcrumbs} />
            </div>
            <div className="flex shrink-0 items-center gap-1 sm:gap-2">
                <LanguageSwitcher />
                <AppearanceSwitcher />
                <SpaceSwitcher />
            </div>
        </header>
    );
}
