import {
    CalendarDays,
    CircleAlert,
    Clock3,
    FileClock,
    Stethoscope,
} from 'lucide-react';
import type { ReactNode } from 'react';
import { useTranslation } from 'react-i18next';

import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type { EmployeeLeavePageData } from '@/types';

import { formatLeaveDate, formatLeaveNumber } from './leave-formatters';
import { StatusBadge } from './status-badge';

type LeaveSummaryCardsProps = {
    data: EmployeeLeavePageData;
    onApplyForLeave?: () => void;
    onViewHistory?: () => void;
    onOpenShortLeave?: () => void;
};

type SummaryCardProps = {
    title: string;
    description: string;
    icon: typeof CalendarDays;
    children: ReactNode;
};

function SummaryCard({
    title,
    description,
    icon: Icon,
    children,
}: SummaryCardProps) {
    return (
        <Card className="border-border/60 gap-4 py-5 shadow-xs">
            <CardHeader className="flex-row items-start justify-between gap-3 px-5">
                <div className="space-y-1">
                    <CardTitle className="text-base">{title}</CardTitle>
                    <CardDescription>{description}</CardDescription>
                </div>
                <span className="bg-muted text-muted-foreground rounded-md p-2">
                    <Icon className="size-4" aria-hidden="true" />
                </span>
            </CardHeader>
            <CardContent className="px-5">{children}</CardContent>
        </Card>
    );
}

export function LeaveSummaryCards({
    data,
    onApplyForLeave,
    onViewHistory,
    onOpenShortLeave,
}: LeaveSummaryCardsProps) {
    const { t, i18n } = useTranslation();
    const { annualLeave, pendingCounts, sickLeave, upcomingApprovedLeave } =
        data;

    return (
        <div dir={i18n.dir()} className="space-y-6">
            <section
                aria-labelledby="leave-overview-heading"
                className="space-y-4"
            >
                <div className="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div className="space-y-1 text-start">
                        <h1
                            id="leave-overview-heading"
                            className="text-2xl font-semibold tracking-tight"
                        >
                            {t('Leave')}
                        </h1>
                        <p className="text-muted-foreground text-sm">
                            {t('Review your leave information and requests.')}
                        </p>
                    </div>
                    <div className="flex flex-wrap gap-2">
                        <Button
                            type="button"
                            onClick={onApplyForLeave}
                            disabled={!onApplyForLeave}
                        >
                            <CalendarDays
                                className="size-4"
                                aria-hidden="true"
                            />
                            {t('Apply for Leave')}
                        </Button>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={onViewHistory}
                            disabled={!onViewHistory}
                        >
                            {t('View Leave History')}
                        </Button>
                        <Button
                            type="button"
                            variant="secondary"
                            onClick={onOpenShortLeave}
                            disabled={!onOpenShortLeave}
                        >
                            {t('Go to Short Leave')}
                        </Button>
                    </div>
                </div>

                {!onOpenShortLeave ? (
                    <p className="text-muted-foreground text-sm">
                        {t(
                            'Short Leave navigation will be available when its authorized page route is connected.',
                        )}
                    </p>
                ) : null}
            </section>

            <section
                aria-label={t('Leave overview')}
                className="grid gap-4 md:grid-cols-2 xl:grid-cols-4"
            >
                <SummaryCard
                    title={t('Annual leave')}
                    description={t('Balance supplied by the leave policy.')}
                    icon={CalendarDays}
                >
                    {annualLeave ? (
                        <div className="space-y-3">
                            <p className="text-2xl font-semibold">
                                {formatLeaveNumber(
                                    annualLeave.availableDays,
                                    i18n.language,
                                )}{' '}
                                {t('days')}
                            </p>
                            <dl className="grid grid-cols-3 gap-2 text-sm">
                                <Metric
                                    label={t('Total')}
                                    value={formatLeaveNumber(
                                        annualLeave.entitlementDays,
                                        i18n.language,
                                    )}
                                />
                                <Metric
                                    label={t('Used')}
                                    value={formatLeaveNumber(
                                        annualLeave.usedDays,
                                        i18n.language,
                                    )}
                                />
                                <Metric
                                    label={t('Pending')}
                                    value={formatLeaveNumber(
                                        annualLeave.pendingDays,
                                        i18n.language,
                                    )}
                                />
                            </dl>
                            {annualLeave.expiringDays !== undefined &&
                            annualLeave.expiryDate ? (
                                <p className="text-warning text-sm">
                                    {t('Leave balance expiring', {
                                        days: formatLeaveNumber(
                                            annualLeave.expiringDays,
                                            i18n.language,
                                        ),
                                        date: formatLeaveDate(
                                            annualLeave.expiryDate,
                                            i18n.language,
                                        ),
                                    })}
                                </p>
                            ) : null}
                        </div>
                    ) : (
                        <p className="text-muted-foreground text-sm">
                            {t('Annual Leave information is not available.')}
                        </p>
                    )}
                </SummaryCard>

                <SummaryCard
                    title={t('Sick Leave')}
                    description={t('Usage and pay-tier information.')}
                    icon={Stethoscope}
                >
                    {sickLeave ? (
                        <div className="space-y-3">
                            <p className="text-2xl font-semibold">
                                {t('Days used', {
                                    days: formatLeaveNumber(
                                        sickLeave.usedDays,
                                        i18n.language,
                                    ),
                                })}
                            </p>
                            <p className="text-sm font-medium">
                                {sickLeave.currentTierLabel}
                            </p>
                            {sickLeave.nextTierNote ? (
                                <p className="text-muted-foreground text-sm">
                                    {sickLeave.nextTierNote}
                                </p>
                            ) : null}
                        </div>
                    ) : (
                        <p className="text-muted-foreground text-sm">
                            {t('Sick Leave information is not available.')}
                        </p>
                    )}
                </SummaryCard>

                <SummaryCard
                    title={t('Pending requests')}
                    description={t('Requests awaiting a decision.')}
                    icon={Clock3}
                >
                    <div className="space-y-3">
                        <p className="text-2xl font-semibold">
                            {formatLeaveNumber(
                                pendingCounts.totalCount,
                                i18n.language,
                            )}
                        </p>
                        <dl className="grid grid-cols-2 gap-2 text-sm">
                            <Metric
                                label={t('Regular')}
                                value={formatLeaveNumber(
                                    pendingCounts.regularCount,
                                    i18n.language,
                                )}
                            />
                            <Metric
                                label={t('Short Leave')}
                                value={formatLeaveNumber(
                                    pendingCounts.shortCount,
                                    i18n.language,
                                )}
                            />
                        </dl>
                    </div>
                </SummaryCard>

                <SummaryCard
                    title={t('Approved Leave')}
                    description={t(
                        'Your current or next scheduled Regular Leave.',
                    )}
                    icon={FileClock}
                >
                    {upcomingApprovedLeave ? (
                        <div className="space-y-2 text-sm">
                            <p className="font-medium">
                                {upcomingApprovedLeave.leaveTypeName}
                            </p>
                            <p className="text-muted-foreground">
                                {formatLeaveDate(
                                    upcomingApprovedLeave.startDate,
                                    i18n.language,
                                )}{' '}
                                –{' '}
                                {formatLeaveDate(
                                    upcomingApprovedLeave.endDate,
                                    i18n.language,
                                )}
                            </p>
                            <p>{upcomingApprovedLeave.durationLabel}</p>
                            {upcomingApprovedLeave.returnToWorkDate ? (
                                <p className="text-muted-foreground">
                                    {t('Return to work', {
                                        date: formatLeaveDate(
                                            upcomingApprovedLeave.returnToWorkDate,
                                            i18n.language,
                                        ),
                                    })}
                                </p>
                            ) : null}
                        </div>
                    ) : (
                        <p className="text-muted-foreground text-sm">
                            {t('No upcoming approved leave is available.')}
                        </p>
                    )}
                </SummaryCard>
            </section>

            <section
                aria-labelledby="leave-status-updates-heading"
                className="grid gap-4 lg:grid-cols-[minmax(0,1fr)_minmax(18rem,0.7fr)]"
            >
                <Card className="border-border/60 gap-4 py-5 shadow-xs">
                    <CardHeader className="px-5">
                        <CardTitle id="leave-status-updates-heading">
                            {t('Recent status updates')}
                        </CardTitle>
                        <CardDescription>
                            {t('Updates supplied by the Leave service.')}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="px-5">
                        {data.recentUpdates.length > 0 ? (
                            <ul className="divide-border divide-y" role="list">
                                {data.recentUpdates.map((update) => (
                                    <li
                                        key={update.id}
                                        className="flex flex-col gap-2 py-3 first:pt-0 sm:flex-row sm:items-start sm:justify-between"
                                    >
                                        <div className="min-w-0 space-y-1 text-start">
                                            <p className="font-medium">
                                                {update.title}
                                            </p>
                                            {update.description ? (
                                                <p className="text-muted-foreground text-sm">
                                                    {update.description}
                                                </p>
                                            ) : null}
                                            <p className="text-muted-foreground text-sm">
                                                {formatLeaveDate(
                                                    update.occurredAt,
                                                    i18n.language,
                                                )}
                                            </p>
                                        </div>
                                        <StatusBadge tone={update.statusTone}>
                                            {update.statusLabel}
                                        </StatusBadge>
                                    </li>
                                ))}
                            </ul>
                        ) : (
                            <div className="text-muted-foreground flex min-h-32 flex-col items-center justify-center gap-2 text-center text-sm">
                                <CircleAlert
                                    className="size-5"
                                    aria-hidden="true"
                                />
                                <p>
                                    {t(
                                        'No recent Leave status updates are available.',
                                    )}
                                </p>
                            </div>
                        )}
                    </CardContent>
                </Card>

                <Card className="border-border/60 gap-4 py-5 shadow-xs">
                    <CardHeader className="px-5">
                        <CardTitle>{t('Employee information')}</CardTitle>
                        <CardDescription>
                            {t(
                                'Information supplied with your Leave workspace.',
                            )}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-3 px-5 text-sm">
                        <Detail
                            label={t('Employee')}
                            value={data.employee.name}
                        />
                        {data.employee.employeeCode ? (
                            <Detail
                                label={t('Employee ID')}
                                value={data.employee.employeeCode}
                            />
                        ) : null}
                        {data.employee.jobTitle ? (
                            <Detail
                                label={t('Position')}
                                value={data.employee.jobTitle}
                            />
                        ) : null}
                        {data.employee.department ? (
                            <Detail
                                label={t('Department')}
                                value={data.employee.department}
                            />
                        ) : null}
                    </CardContent>
                </Card>
            </section>
        </div>
    );
}

function Metric({ label, value }: { label: string; value: string }) {
    return (
        <div>
            <dt className="text-muted-foreground">{label}</dt>
            <dd className="font-medium">{value}</dd>
        </div>
    );
}

function Detail({ label, value }: { label: string; value: string }) {
    return (
        <div>
            <p className="text-muted-foreground">{label}</p>
            <p className="font-medium">{value}</p>
        </div>
    );
}
