import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { DepartmentHeadEmployeeDirectoryPage } from '@/components/head/department-head-employee-directory-page';
import { dashboard } from '@/routes/head';
import { index as employees } from '@/routes/head/employees';
import type { HeadEmployeeDirectoryPageProps } from '@/types/head';

export default function Index(props: HeadEmployeeDirectoryPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Employees')} />
            <DepartmentHeadEmployeeDirectoryPage {...props} />
        </>
    );
}

Index.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard() },
        { title: 'Employees', href: employees() },
    ],
};
