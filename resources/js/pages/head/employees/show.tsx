import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { DepartmentHeadEmployeeDetailsPage } from '@/components/head/department-head-employee-details-page';
import { dashboard } from '@/routes/head';
import { index as employees } from '@/routes/head/employees';
import type { HeadEmployeeDetailsPageProps } from '@/types/head';

export default function Show(props: HeadEmployeeDetailsPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Employee details')} />
            <DepartmentHeadEmployeeDetailsPage {...props} />
        </>
    );
}

Show.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard() },
        { title: 'Employees', href: employees() },
        { title: 'Employee details', href: employees() },
    ],
};
