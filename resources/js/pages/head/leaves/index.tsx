import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { DepartmentHeadLeavesPage } from '@/components/head/department-head-leaves-page';
import { dashboard } from '@/routes/head';
import { index as leaveRequests } from '@/routes/head/leaves';
import type { HeadLeaveIndexPageProps } from '@/types/head';

export default function Index(props: HeadLeaveIndexPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Leave Requests')} />
            <DepartmentHeadLeavesPage {...props} />
        </>
    );
}

Index.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard() },
        { title: 'Leave Requests', href: leaveRequests() },
    ],
};
