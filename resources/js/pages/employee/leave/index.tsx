import { Head } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { EmployeeLeavePage } from '@/components/leave/employee-leave-page';
import { index as leave } from '@/routes/leave';
import type { EmployeeLeavePageProps, LeavePageState } from '@/types';

const Leave = ({ leavePage }: EmployeeLeavePageProps) => {
    const { t } = useTranslation();

    const state: LeavePageState = leavePage
        ? { status: 'ready', data: leavePage }
        : {
              status: 'error',
              message: t(
                  'Leave information is unavailable because no employee profile is linked to this account.',
              ),
          };

    return (
        <>
            <Head title={t('Leave')} />
            <EmployeeLeavePage state={state} />
        </>
    );
};

Leave.layout = {
    breadcrumbs: [
        {
            title: 'Leave',
            href: leave(),
        },
    ],
};

export default Leave;
