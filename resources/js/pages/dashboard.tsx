import { Head, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { AnnualLeaveCard } from '@/components/dashboard/annual-leave-card';
import { EmployeeSummaryCard } from '@/components/dashboard/employee-summary-card';
import { IdentificationDocumentsCard } from '@/components/dashboard/identification-documents-card';
import { PendingRegularLeaveRequestsCard } from '@/components/dashboard/pending-regular-leave-requests-card';
import { UpcomingApprovedRegularLeaveCard } from '@/components/dashboard/upcoming-approved-regular-leave-card';
import { dashboard } from '@/routes';
import type { EmployeeDashboardPageProps, SharedData } from '@/types';

export default function Dashboard({
    employeeDashboard,
}: EmployeeDashboardPageProps) {
    const { auth } = usePage<SharedData>().props;
    const { t } = useTranslation();

    return (
        <>
            <Head title={t('Employee dashboard')} />
            <div className="bg-background w-full">
                <div className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6">
                    <EmployeeSummaryCard
                        employee={employeeDashboard}
                        avatar={auth.user.avatar}
                        employeeCode={auth.user.employee_code}
                    />
                    {employeeDashboard ? (
                        <>
                            <section className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                <AnnualLeaveCard
                                    balance={
                                        employeeDashboard.annualLeaveBalance
                                    }
                                />
                                <IdentificationDocumentsCard
                                    identifications={
                                        employeeDashboard.identifications
                                    }
                                />
                            </section>
                            <section className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                <PendingRegularLeaveRequestsCard
                                    requests={
                                        employeeDashboard.pendingRegularLeaveRequests
                                    }
                                />
                                <UpcomingApprovedRegularLeaveCard
                                    leave={
                                        employeeDashboard.upcomingApprovedRegularLeave
                                    }
                                />
                            </section>
                        </>
                    ) : null}
                </div>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
