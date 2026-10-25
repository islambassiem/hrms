import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { LetterRequestIndexPage } from '@/components/request/letter/letter-request-index-page';
import { index as letters } from '@/routes/letters';
import type { EmployeeLetterIndexPageProps } from '@/types';

export default function LetterRequestIndex({
    letters: letterCollection,
}: EmployeeLetterIndexPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Letter requests')} />
            <LetterRequestIndexPage letters={letterCollection} />
        </>
    );
}

LetterRequestIndex.layout = {
    breadcrumbs: [
        {
            title: 'Letter requests',
            href: letters(),
        },
    ],
};
