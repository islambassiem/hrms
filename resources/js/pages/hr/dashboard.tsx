import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { HRPersonnelDashboard } from '@/components/hr/hr-personnel-dashboard';
import { dashboard } from '@/routes/hr';
import type { HRDashboardPageProps } from '@/types/hr-dashboard';

export default function Dashboard({
    hrDashboard = null,
}: HRDashboardPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('HR Personnel Dashboard')} />
            <HRPersonnelDashboard data={hrDashboard} />
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'HR Dashboard',
            href: dashboard(),
        },
    ],
};
