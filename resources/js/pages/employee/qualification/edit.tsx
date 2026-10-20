import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { QualificationForm } from '@/components/qualification/qualification-form';
import { index as qualifications } from '@/routes/qualifications';
import type { EmployeeQualificationEditPageProps } from '@/types';

export default function EditQualification({
    qualification,
    props,
}: EmployeeQualificationEditPageProps) {
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Edit qualification')} />
            <QualificationForm
                mode="edit"
                qualification={qualification}
                options={props}
            />
        </>
    );
}

EditQualification.layout = {
    breadcrumbs: [
        {
            title: 'Qualifications',
            href: qualifications(),
        },
        {
            title: 'Edit qualification',
            href: qualifications(),
        },
    ],
};
