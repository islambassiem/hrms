import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { DepartmentHeadShortLeavesPage } from '@/components/head/department-head-short-leaves-page';
import { dashboard } from '@/routes/head';
import { index as shortLeaveRequests } from '@/routes/head/short-leaves';
import type { HeadShortLeaveIndexPageProps } from '@/types/head';

export default function Index(props: HeadShortLeaveIndexPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Short Leave Requests')} />
            <DepartmentHeadShortLeavesPage {...props} />
        </>
    );
}

Index.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard() },
        { title: 'Short Leave Requests', href: shortLeaveRequests() },
    ],
};
