import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { DepartmentHeadDashboard } from '@/components/head/department-head-dashboard';
import { dashboard } from '@/routes/head';
import type { HeadDashboardPageProps } from '@/types/head';

export default function Dashboard({ headDashboard }: HeadDashboardPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Dashboard')} />
            <DepartmentHeadDashboard data={headDashboard} />
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
