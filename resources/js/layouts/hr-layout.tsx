import AppLayoutTemplate from '@/layouts/app/hr-sidebar-layout';
import type { BreadcrumbItem } from '@/types';

export default function HrLayout({
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
