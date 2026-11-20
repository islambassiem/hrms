import { useTranslation } from 'react-i18next';

import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type {
    HRCompanyComparisonItem,
    HRDashboardList,
    HRRecentQualification,
    HRRequestsBreakdownItem,
    HRUpcomingLeave,
} from '@/types/hr-dashboard';

function formatDate(value: string, locale: string): string {
    const dateOnly = /^(\d{4})-(\d{2})-(\d{2})$/.exec(value);
    const date =
        dateOnly === null
            ? new Date(value)
            : new Date(
                  Number(dateOnly[1]),
                  Number(dateOnly[2]) - 1,
                  Number(dateOnly[3]),
              );

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return new Intl.DateTimeFormat(locale, { dateStyle: 'medium' }).format(
        date,
    );
}

function RequestTypeName({
    type,
}: {
    type: HRRequestsBreakdownItem['requestType'];
}) {
    const { t } = useTranslation();
    const labels: Record<HRRequestsBreakdownItem['requestType'], string> = {
        leave: 'Leaves',
        shortLeave: 'Short Leaves',
        letter: 'Letters',
        familyVisit: 'Family Visits',
        visa: 'Visas',
    };

    return t(labels[type]);
}

export function HRUpcomingLeaveCard({
    data,
    locale,
}: {
    data: HRDashboardList<HRUpcomingLeave> | null;
    locale: string;
}) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <CardTitle>{t('Upcoming Leaves')}</CardTitle>
                <CardDescription>
                    {t('Approved Leaves starting in the next 7 days.')}
                </CardDescription>
            </CardHeader>
            <CardContent>
                {data?.status !== 'available' ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-5 text-sm">
                        {t('Upcoming Leave data is not available yet.')}
                    </p>
                ) : data.items.length === 0 ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-5 text-sm">
                        {t('No upcoming approved Leaves.')}
                    </p>
                ) : (
                    <ul className="divide-border divide-y">
                        {data.items.map((leave) => (
                            <li
                                key={leave.id}
                                className="flex flex-col gap-1 py-3 first:pt-0 last:pb-0 sm:flex-row sm:items-start sm:justify-between sm:gap-4"
                            >
                                <div className="min-w-0">
                                    <p className="text-foreground truncate font-medium">
                                        {leave.employeeName}
                                    </p>
                                    <p className="text-muted-foreground text-sm">
                                        {leave.companyName} · {leave.leaveType}
                                    </p>
                                </div>
                                <p className="text-muted-foreground shrink-0 text-sm">
                                    {formatDate(leave.startDate, locale)} –{' '}
                                    {formatDate(leave.endDate, locale)}
                                </p>
                            </li>
                        ))}
                    </ul>
                )}
            </CardContent>
        </Card>
    );
}

export function HRRecentQualificationsCard({
    data,
    locale,
}: {
    data: HRDashboardList<HRRecentQualification> | null;
    locale: string;
}) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <CardTitle>{t('Recent Qualification Updates')}</CardTitle>
                <CardDescription>
                    {t('Recently updated employee qualifications.')}
                </CardDescription>
            </CardHeader>
            <CardContent>
                {data?.status !== 'available' ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-5 text-sm">
                        {t('Qualification activity is not available yet.')}
                    </p>
                ) : data.items.length === 0 ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-5 text-sm">
                        {t('No recent qualification updates.')}
                    </p>
                ) : (
                    <ul className="divide-border divide-y">
                        {data.items.map((item) => (
                            <li
                                key={item.id}
                                className="py-3 first:pt-0 last:pb-0"
                            >
                                <p className="text-foreground font-medium">
                                    {item.employeeName}
                                </p>
                                <p className="text-muted-foreground text-sm">
                                    {item.qualification} · {item.companyName}
                                </p>
                                <time
                                    className="text-muted-foreground mt-1 block text-xs"
                                    dateTime={item.updatedAt}
                                >
                                    {formatDate(item.updatedAt, locale)}
                                </time>
                            </li>
                        ))}
                    </ul>
                )}
            </CardContent>
        </Card>
    );
}

function RequestsBreakdownCard({
    data,
}: {
    data: HRDashboardList<HRRequestsBreakdownItem> | null;
}) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <CardTitle>{t('Requests Breakdown')}</CardTitle>
                <CardDescription>
                    {t('Compare pending and completed requests by category.')}
                </CardDescription>
            </CardHeader>
            <CardContent>
                {data?.status !== 'available' ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-5 text-sm">
                        {t('Request breakdown data is not available yet.')}
                    </p>
                ) : data.items.length === 0 ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-5 text-sm">
                        {t('No request breakdown data for this scope.')}
                    </p>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="w-full min-w-80 text-start text-sm">
                            <caption className="sr-only">
                                {t('Requests by category')}
                            </caption>
                            <thead className="text-muted-foreground border-border border-b text-xs uppercase">
                                <tr>
                                    <th
                                        className="px-3 py-2 font-medium"
                                        scope="col"
                                    >
                                        {t('Request type')}
                                    </th>
                                    <th
                                        className="px-3 py-2 text-end font-medium"
                                        scope="col"
                                    >
                                        {t('Pending')}
                                    </th>
                                    <th
                                        className="px-3 py-2 text-end font-medium"
                                        scope="col"
                                    >
                                        {t('Completed')}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {data.items.map((item) => (
                                    <tr
                                        key={item.requestType}
                                        className="border-border border-b last:border-0"
                                    >
                                        <th
                                            className="text-foreground px-3 py-3 text-start font-medium"
                                            scope="row"
                                        >
                                            <RequestTypeName
                                                type={item.requestType}
                                            />
                                        </th>
                                        <td className="text-foreground px-3 py-3 text-end tabular-nums">
                                            {item.pendingCount}
                                        </td>
                                        <td className="text-foreground px-3 py-3 text-end tabular-nums">
                                            {item.completedCount}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </CardContent>
        </Card>
    );
}

function CompanyComparisonCard({
    data,
}: {
    data: HRDashboardList<HRCompanyComparisonItem> | null;
}) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <CardTitle>{t('Sub-Company Comparison')}</CardTitle>
                <CardDescription>
                    {t('Workforce and current request activity by company.')}
                </CardDescription>
            </CardHeader>
            <CardContent>
                {data?.status !== 'available' ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-5 text-sm">
                        {t('Company comparison data is not available yet.')}
                    </p>
                ) : data.items.length === 0 ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-5 text-sm">
                        {t('No company comparison data for this scope.')}
                    </p>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="w-full min-w-[34rem] text-start text-sm">
                            <caption className="sr-only">
                                {t(
                                    'Employee and request comparison by company',
                                )}
                            </caption>
                            <thead className="text-muted-foreground border-border border-b text-xs uppercase">
                                <tr>
                                    <th
                                        className="px-3 py-2 font-medium"
                                        scope="col"
                                    >
                                        {t('Sub-Company')}
                                    </th>
                                    <th
                                        className="px-3 py-2 text-end font-medium"
                                        scope="col"
                                    >
                                        {t('Active employees')}
                                    </th>
                                    <th
                                        className="px-3 py-2 text-end font-medium"
                                        scope="col"
                                    >
                                        {t('Pending requests')}
                                    </th>
                                    <th
                                        className="px-3 py-2 text-end font-medium"
                                        scope="col"
                                    >
                                        {t('Away today')}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {data.items.map((item) => (
                                    <tr
                                        key={item.companyId}
                                        className="border-border border-b last:border-0"
                                    >
                                        <th
                                            className="text-foreground max-w-56 truncate px-3 py-3 text-start font-medium"
                                            scope="row"
                                        >
                                            {item.companyName}
                                        </th>
                                        <td className="text-foreground px-3 py-3 text-end tabular-nums">
                                            {item.activeEmployees}
                                        </td>
                                        <td className="text-foreground px-3 py-3 text-end tabular-nums">
                                            {item.pendingRequests}
                                        </td>
                                        <td className="text-foreground px-3 py-3 text-end tabular-nums">
                                            {item.employeesAwayToday}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </CardContent>
        </Card>
    );
}

export function HRDashboardInsights({
    companyComparison,
    requestsBreakdown,
}: {
    companyComparison: HRDashboardList<HRCompanyComparisonItem> | null;
    requestsBreakdown: HRDashboardList<HRRequestsBreakdownItem> | null;
}) {
    return (
        <section className="grid gap-4 xl:grid-cols-2">
            <RequestsBreakdownCard data={requestsBreakdown} />
            <CompanyComparisonCard data={companyComparison} />
        </section>
    );
}
