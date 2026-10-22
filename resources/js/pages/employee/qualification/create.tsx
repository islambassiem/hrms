import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { QualificationForm } from '@/components/qualification/qualification-form';
import {
    create as createQualification,
    index as qualifications,
} from '@/routes/qualifications';
import type { EmployeeQualificationCreatePageProps } from '@/types';

export default function CreateQualification({
    props,
}: EmployeeQualificationCreatePageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Create qualification')} />
            <QualificationForm mode="create" options={props} />
        </>
    );
}

CreateQualification.layout = {
    breadcrumbs: [
        {
            title: 'Qualifications',
            href: qualifications(),
        },
        {
            title: 'Create qualification',
            href: createQualification(),
        },
    ],
};
