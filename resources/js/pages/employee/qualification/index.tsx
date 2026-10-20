import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { QualificationIndexPage } from '@/components/qualification/qualification-index-page';
import { index as qualifications } from '@/routes/qualifications';
import type { EmployeeQualificationIndexPageProps } from '@/types';

export default function QualificationIndex({
    qualifications: qualificationCollection,
    canCreate,
}: EmployeeQualificationIndexPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Qualifications')} />
            <QualificationIndexPage
                qualifications={qualificationCollection.data}
                canCreate={canCreate}
            />
        </>
    );
}

QualificationIndex.layout = {
    breadcrumbs: [
        {
            title: 'Qualifications',
            href: qualifications(),
        },
    ],
};
