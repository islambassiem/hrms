import {
    CalendarDays,
    CalendarRange,
    ClipboardList,
    UsersRound,
    Venus,
    Mars,
} from 'lucide-react';
import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { index as leaveRequests } from '@/routes/head/leaves';
import { index as shortLeaveRequests } from '@/routes/head/short-leaves';
import type { HeadDashboardData } from '@/types/head';

export function DepartmentHeadDashboard({ data }: { data: HeadDashboardData }) {
    const { i18n, t } = useTranslation();
    const metrics = [
        {
            label: 'Active staff',
            value: data.activeStaffCount,
            icon: UsersRound,
            detail: t('Active direct reports'),
        },
        {
            label: 'Male staff',
            value: data.maleStaffCount,
            icon: Mars,
            detail: t('Active employees'),
        },
        {
            label: 'Female staff',
            value: data.femaleStaffCount,
            icon: Venus,
            detail: t('Active employees'),
        },
        {
            label: 'Pending Regular Leave',
            value: data.pendingRegularLeaveCount,
            icon: CalendarRange,
            detail: t('Requests with pending status'),
        },
        {
            label: 'Pending Short Leave',
            value: data.pendingShortLeaveCount,
            icon: ClipboardList,
            detail: t('Requests with pending status'),
        },
        {
            label: 'Employees on leave today',
            value: data.employeesOnLeaveTodayCount,
            icon: CalendarDays,
            detail: t('Approved Regular Leave in progress today'),
        },
    ] as const;

    return (
        <main
            dir={i18n.dir()}
            className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6"
        >
            <header className="space-y-1">
                <h1 className="text-foreground text-xl font-semibold tracking-tight">
                    {t('Dashboard')}
                </h1>
                <p className="text-muted-foreground text-sm">
                    {t('A current summary of your active direct reports.')}
                </p>
            </header>

            <section
                aria-label={t('Department overview metrics')}
                className="grid gap-4 sm:grid-cols-2 xl:grid-cols-3"
            >
                {metrics.map(({ detail, icon: Icon, label, value }) => (
                    <Card
                        key={label}
                        className="border-border/80 bg-sidebar shadow-xs"
                    >
                        <CardHeader className="flex-row items-start justify-between gap-4">
                            <div className="min-w-0 space-y-1">
                                <CardTitle className="text-muted-foreground text-sm font-medium">
                                    {t(label)}
                                </CardTitle>
                                <CardDescription>{detail}</CardDescription>
                            </div>
                            <span className="bg-muted text-muted-foreground flex size-10 shrink-0 items-center justify-center rounded-lg">
                                <Icon className="size-5" aria-hidden="true" />
                            </span>
                        </CardHeader>
                        <CardContent>
                            <p className="text-foreground text-3xl font-semibold tabular-nums">
                                {new Intl.NumberFormat(i18n.language).format(
                                    value,
                                )}
                            </p>
                        </CardContent>
                    </Card>
                ))}
            </section>

            <section className="grid gap-4 sm:grid-cols-2">
                <Link
                    href={leaveRequests()}
                    className="border-border/80 bg-sidebar hover:bg-accent focus-visible:ring-ring flex min-h-24 items-center gap-4 rounded-xl border p-5 shadow-xs transition-colors focus-visible:ring-[3px] focus-visible:outline-none"
                >
                    <span className="bg-muted text-muted-foreground flex size-10 shrink-0 items-center justify-center rounded-lg">
                        <CalendarRange className="size-5" aria-hidden="true" />
                    </span>
                    <span className="min-w-0">
                        <span className="text-foreground block font-medium">
                            {t('Leave Requests')}
                        </span>
                        <span className="text-muted-foreground block text-sm">
                            {t('View Regular Leave requests from your staff.')}
                        </span>
                    </span>
                </Link>
                <Link
                    href={shortLeaveRequests()}
                    className="border-border/80 bg-sidebar hover:bg-accent focus-visible:ring-ring flex min-h-24 items-center gap-4 rounded-xl border p-5 shadow-xs transition-colors focus-visible:ring-[3px] focus-visible:outline-none"
                >
                    <span className="bg-muted text-muted-foreground flex size-10 shrink-0 items-center justify-center rounded-lg">
                        <ClipboardList className="size-5" aria-hidden="true" />
                    </span>
                    <span className="min-w-0">
                        <span className="text-foreground block font-medium">
                            {t('Short Leave Requests')}
                        </span>
                        <span className="text-muted-foreground block text-sm">
                            {t('View Short Leave requests from your staff.')}
                        </span>
                    </span>
                </Link>
            </section>
        </main>
    );
}
