import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { QualificationDetailsPage } from '@/components/qualification/qualification-details-page';
import { index as qualifications } from '@/routes/qualifications';
import type { EmployeeQualificationShowPageProps } from '@/types';

export default function ShowQualification({
    qualification,
}: EmployeeQualificationShowPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Qualification details')} />
            <QualificationDetailsPage qualification={qualification} />
        </>
    );
}

ShowQualification.layout = {
    breadcrumbs: [
        {
            title: 'Qualifications',
            href: qualifications(),
        },
        {
            title: 'Qualification details',
            href: qualifications(),
        },
    ],
};
