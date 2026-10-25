import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { FamilyVisitRequestIndexPage } from '@/components/request/family-visit/family-visit-request-index-page';
import { index as familyVisits } from '@/routes/family-visits';
import type { EmployeeFamilyVisitIndexPageProps } from '@/types';

export default function FamilyVisitRequestIndex({
    visits: visitCollection,
}: EmployeeFamilyVisitIndexPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Family visit requests')} />
            <FamilyVisitRequestIndexPage visits={visitCollection} />
        </>
    );
}

FamilyVisitRequestIndex.layout = {
    breadcrumbs: [
        {
            title: 'Family visit requests',
            href: familyVisits(),
        },
    ],
};
