import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { ShortLeaveRequestIndexPage } from '@/components/short-leave/short-leave-request-index-page';
import { index as shortLeaves } from '@/routes/short-leaves';
import type { EmployeeShortLeaveIndexPageProps } from '@/types';

export default function ShortLeaveIndex({
    filters,
    initialForm,
    shortLeaveRequests,
    shortLeaveTypes,
}: EmployeeShortLeaveIndexPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Short Leave')} />
            <ShortLeaveRequestIndexPage
                filters={filters}
                initialForm={initialForm}
                shortLeaveRequests={shortLeaveRequests}
                shortLeaveTypes={shortLeaveTypes}
            />
        </>
    );
}

ShortLeaveIndex.layout = {
    breadcrumbs: [
        {
            title: 'Short Leave',
            href: shortLeaves(),
        },
    ],
};
