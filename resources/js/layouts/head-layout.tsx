import AppLayoutTemplate from '@/layouts/app/head-sidebar-layout';
import type { BreadcrumbItem } from '@/types';

export default function HeadLayout({
    breadcrumbs = [],
    children,
}: {
    breadcrumbs?: BreadcrumbItem[];
    children: React.ReactNode;
}) {
    return (
        <AppLayoutTemplate breadcrumbs={breadcrumbs}>
            {children}
        </AppLayoutTemplate>
    );
}
