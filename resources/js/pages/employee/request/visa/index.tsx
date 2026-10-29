import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { VisaRequestIndexPage } from '@/components/request/visa/visa-request-index-page';
import { index as visas } from '@/routes/visas';
import type { EmployeeVisaIndexPageProps } from '@/types';

export default function VisaRequestIndex({
    initialForm,
    visas: visaCollection,
}: EmployeeVisaIndexPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Visa requests')} />
            <VisaRequestIndexPage
                initialForm={initialForm}
                visas={visaCollection}
            />
        </>
    );
}

VisaRequestIndex.layout = {
    breadcrumbs: [
        {
            title: 'Visa requests',
            href: visas(),
        },
    ],
};
