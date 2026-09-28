import {
    CalendarDays,
    CircleAlert,
    Clock3,
    FileClock,
    Stethoscope,
} from 'lucide-react';
import type { ReactNode } from 'react';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type { EmployeeLeavePageData } from '@/types/leave';
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
    const { annualLeave, pendingCounts, sickLeave, upcomingApprovedLeave } =
        data;

    return (
        <div className="space-y-6">
            <section
                aria-labelledby="leave-overview-heading"
                className="space-y-4"
            >
                <div className="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div className="space-y-1">
                        <h1
                            id="leave-overview-heading"
                            className="text-2xl font-semibold tracking-tight"
                        >
                            Leave
                        </h1>
                        <p className="text-muted-foreground text-sm">
                            Review your leave information and requests.
                        </p>
                    </div>
                    <div className="flex flex-wrap gap-2">
                        <Button type="button" onClick={onApplyForLeave}>
                            <CalendarDays
                                className="size-4"
                                aria-hidden="true"
                            />
                            Apply for Leave
                        </Button>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={onViewHistory}
                        >
                            View Leave History
                        </Button>
                        <Button
                            type="button"
                            variant="secondary"
                            onClick={onOpenShortLeave}
                            disabled={!onOpenShortLeave}
                        >
                            Go to Short Leave
                        </Button>
                    </div>
                </div>

                {!onOpenShortLeave && (
                    <p className="text-muted-foreground text-sm">
                        Short Leave navigation will be available when its
                        authorized page route is connected.
                    </p>
                )}
            </section>

            <section
                aria-label="Leave overview"
                className="grid gap-4 md:grid-cols-2 xl:grid-cols-4"
            >
                <SummaryCard
                    title="Annual Leave"
                    description="Balance supplied by the leave policy."
                    icon={CalendarDays}
                >
                    {annualLeave ? (
                        <div className="space-y-3">
                            <p className="text-2xl font-semibold">
                                {annualLeave.availableDays} days
                            </p>
                            <dl className="grid grid-cols-3 gap-2 text-sm">
                                <div>
                                    <dt className="text-muted-foreground">
                                        Total
                                    </dt>
                                    <dd className="font-medium">
                                        {annualLeave.entitlementDays}
                                    </dd>
                                </div>
                                <div>
                                    <dt className="text-muted-foreground">
                                        Used
                                    </dt>
                                    <dd className="font-medium">
                                        {annualLeave.usedDays}
                                    </dd>
                                </div>
                                <div>
                                    <dt className="text-muted-foreground">
                                        Pending
                                    </dt>
                                    <dd className="font-medium">
                                        {annualLeave.pendingDays}
                                    </dd>
                                </div>
                            </dl>
                            {annualLeave.expiringDays !== undefined &&
                                annualLeave.expiryDate && (
                                    <p className="text-warning text-sm">
                                        {annualLeave.expiringDays} days expire
                                        on {annualLeave.expiryDate}.
                                    </p>
                                )}
                        </div>
                    ) : (
                        <p className="text-muted-foreground text-sm">
                            Annual Leave information is not available.
                        </p>
                    )}
                </SummaryCard>

                <SummaryCard
                    title="Sick Leave"
                    description="Usage and pay-tier information."
                    icon={Stethoscope}
                >
                    {sickLeave ? (
                        <div className="space-y-3">
                            <p className="text-2xl font-semibold">
                                {sickLeave.usedDays} days used
                            </p>
                            <p className="text-sm font-medium">
                                {sickLeave.currentTierLabel}
                            </p>
                            {sickLeave.nextTierNote && (
                                <p className="text-muted-foreground text-sm">
                                    {sickLeave.nextTierNote}
                                </p>
                            )}
                        </div>
                    ) : (
                        <p className="text-muted-foreground text-sm">
                            Sick Leave information is not available.
                        </p>
                    )}
                </SummaryCard>

                <SummaryCard
                    title="Pending requests"
                    description="Requests awaiting a decision."
                    icon={Clock3}
                >
                    <div className="space-y-3">
                        <p className="text-2xl font-semibold">
                            {pendingCounts.totalCount}
                        </p>
                        <dl className="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <dt className="text-muted-foreground">
                                    Regular
                                </dt>
                                <dd className="font-medium">
                                    {pendingCounts.regularCount}
                                </dd>
                            </div>
                            <div>
                                <dt className="text-muted-foreground">
                                    Short Leave
                                </dt>
                                <dd className="font-medium">
                                    {pendingCounts.shortCount}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </SummaryCard>

                <SummaryCard
                    title="Upcoming approved leave"
                    description="Your next scheduled Regular Leave."
                    icon={FileClock}
                >
                    {upcomingApprovedLeave ? (
                        <div className="space-y-2 text-sm">
                            <p className="font-medium">
                                {upcomingApprovedLeave.leaveTypeName}
                            </p>
                            <p className="text-muted-foreground">
                                {upcomingApprovedLeave.startDate} –{' '}
                                {upcomingApprovedLeave.endDate}
                            </p>
                            <p>{upcomingApprovedLeave.durationLabel}</p>
                            {upcomingApprovedLeave.returnToWorkDate && (
                                <p className="text-muted-foreground">
                                    Return to work:{' '}
                                    {upcomingApprovedLeave.returnToWorkDate}
                                </p>
                            )}
                        </div>
                    ) : (
                        <p className="text-muted-foreground text-sm">
                            No upcoming approved leave is available.
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
                            Recent status updates
                        </CardTitle>
                        <CardDescription>
                            Updates supplied by the Leave service.
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
                                        <div className="min-w-0 space-y-1">
                                            <p className="font-medium">
                                                {update.title}
                                            </p>
                                            {update.description && (
                                                <p className="text-muted-foreground text-sm">
                                                    {update.description}
                                                </p>
                                            )}
                                            <p className="text-muted-foreground text-sm">
                                                {update.occurredAt}
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
                                    No recent Leave status updates are
                                    available.
                                </p>
                            </div>
                        )}
                    </CardContent>
                </Card>

                <Card className="border-border/60 gap-4 py-5 shadow-xs">
                    <CardHeader className="px-5">
                        <CardTitle>Employee information</CardTitle>
                        <CardDescription>
                            Information supplied with your Leave workspace.
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-3 px-5 text-sm">
                        <div>
                            <p className="text-muted-foreground">Employee</p>
                            <p className="font-medium">{data.employee.name}</p>
                        </div>
                        {data.employee.employeeCode && (
                            <div>
                                <p className="text-muted-foreground">
                                    Employee ID
                                </p>
                                <p className="font-medium">
                                    {data.employee.employeeCode}
                                </p>
                            </div>
                        )}
                        {data.employee.jobTitle && (
                            <div>
                                <p className="text-muted-foreground">
                                    Position
                                </p>
                                <p className="font-medium">
                                    {data.employee.jobTitle}
                                </p>
                            </div>
                        )}
                        {data.employee.department && (
                            <div>
                                <p className="text-muted-foreground">
                                    Department
                                </p>
                                <p className="font-medium">
                                    {data.employee.department}
                                </p>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </section>
        </div>
    );
}
