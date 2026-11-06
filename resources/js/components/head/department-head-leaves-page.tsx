import { router } from '@inertiajs/react';
import { CalendarRange, Filter, TriangleAlert } from 'lucide-react';
import { useState, type FormEvent } from 'react';
import { useTranslation } from 'react-i18next';

import { HeadRequestPagination } from '@/components/head/head-request-pagination';
import { HeadRequestStatusBadge } from '@/components/head/head-request-status-badge';
import { formatHeadDate } from '@/components/head/head-page-formatters';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { index as leaveRequestsRoute } from '@/routes/head/leaves';
import type { HeadLeaveIndexPageProps } from '@/types/head';

type FilterValues = {
    employeeId: string;
    leaveTypeId: string;
    status: string;
    startDate: string;
    endDate: string;
};

const emptyFilters: FilterValues = {
    employeeId: '',
    leaveTypeId: '',
    status: '',
    startDate: '',
    endDate: '',
};

export function DepartmentHeadLeavesPage({
    employees,
    filters,
    leaveRequests,
    leaveTypes,
    statuses,
}: HeadLeaveIndexPageProps) {
    const { i18n, t } = useTranslation();
    const [values, setValues] = useState<FilterValues>({
        employeeId: filters.employeeId ? String(filters.employeeId) : '',
        leaveTypeId: filters.leaveTypeId ? String(filters.leaveTypeId) : '',
        status: filters.status ?? '',
        startDate: filters.startDate ?? '',
        endDate: filters.endDate ?? '',
    });
    const hasFilters = Object.values(values).some(Boolean);

    const applyFilters = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const query: Record<string, string> = {};

        if (values.employeeId) query.employee_id = values.employeeId;
        if (values.leaveTypeId) query.leave_type_id = values.leaveTypeId;
        if (values.status) query.status = values.status;
        if (values.startDate) query.start_date = values.startDate;
        if (values.endDate) query.end_date = values.endDate;

        router.get(leaveRequestsRoute.url(), query, {
            preserveScroll: true,
            replace: true,
        });
    };

    const clearFilters = () => {
        setValues(emptyFilters);
        router.get(
            leaveRequestsRoute.url(),
            {},
            {
                preserveScroll: true,
                replace: true,
            },
        );
    };

    return (
        <main
            dir={i18n.dir()}
            className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6"
        >
            <header className="space-y-1">
                <h1 className="text-foreground text-xl font-semibold tracking-tight">
                    {t('Leave Requests')}
                </h1>
                <p className="text-muted-foreground text-sm">
                    {t(
                        'Regular Leave requests from your active direct reports.',
                    )}
                </p>
            </header>

            <div
                role="note"
                className="border-warning/30 bg-warning/10 text-foreground flex items-start gap-3 rounded-lg border p-4"
            >
                <TriangleAlert
                    className="text-warning mt-0.5 size-4 shrink-0"
                    aria-hidden="true"
                />
                <p className="text-sm">
                    {t(
                        'Department Head review actions are unavailable until the approval workflow is connected.',
                    )}
                </p>
            </div>

            <Card className="border-border/80 bg-sidebar shadow-xs">
                <CardHeader>
                    <CardTitle className="flex items-center gap-2">
                        <Filter
                            className="text-muted-foreground size-4"
                            aria-hidden="true"
                        />
                        {t('Filter requests')}
                    </CardTitle>
                    <CardDescription>
                        {t(
                            'Filter Regular Leave by employee, status, and dates.',
                        )}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form onSubmit={applyFilters} className="space-y-4">
                        <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                            <div className="space-y-2">
                                <Label htmlFor="head-leave-employee">
                                    {t('Employee')}
                                </Label>
                                <Select
                                    value={values.employeeId || 'all'}
                                    onValueChange={(employeeId) =>
                                        setValues((current) => ({
                                            ...current,
                                            employeeId:
                                                employeeId === 'all'
                                                    ? ''
                                                    : employeeId,
                                        }))
                                    }
                                >
                                    <SelectTrigger
                                        id="head-leave-employee"
                                        className="w-full"
                                    >
                                        <SelectValue
                                            placeholder={t('All employees')}
                                        />
                                    </SelectTrigger>
                                    <SelectContent dir={i18n.dir()}>
                                        <SelectItem value="all">
                                            {t('All employees')}
                                        </SelectItem>
                                        {employees.map((employee) => (
                                            <SelectItem
                                                key={employee.id}
                                                value={String(employee.id)}
                                            >
                                                {employee.name} ·{' '}
                                                {employee.employeeCode}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="head-leave-type">
                                    {t('Leave type')}
                                </Label>
                                <Select
                                    value={values.leaveTypeId || 'all'}
                                    onValueChange={(leaveTypeId) =>
                                        setValues((current) => ({
                                            ...current,
                                            leaveTypeId:
                                                leaveTypeId === 'all'
                                                    ? ''
                                                    : leaveTypeId,
                                        }))
                                    }
                                >
                                    <SelectTrigger
                                        id="head-leave-type"
                                        className="w-full"
                                    >
                                        <SelectValue
                                            placeholder={t('All leave types')}
                                        />
                                    </SelectTrigger>
                                    <SelectContent dir={i18n.dir()}>
                                        <SelectItem value="all">
                                            {t('All leave types')}
                                        </SelectItem>
                                        {leaveTypes.map((leaveType) => (
                                            <SelectItem
                                                key={leaveType.id}
                                                value={String(leaveType.id)}
                                            >
                                                {leaveType.label}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="head-leave-status">
                                    {t('Status')}
                                </Label>
                                <Select
                                    value={values.status || 'all'}
                                    onValueChange={(status) =>
                                        setValues((current) => ({
                                            ...current,
                                            status:
                                                status === 'all' ? '' : status,
                                        }))
                                    }
                                >
                                    <SelectTrigger
                                        id="head-leave-status"
                                        className="w-full"
                                    >
                                        <SelectValue
                                            placeholder={t('All statuses')}
                                        />
                                    </SelectTrigger>
                                    <SelectContent dir={i18n.dir()}>
                                        <SelectItem value="all">
                                            {t('All statuses')}
                                        </SelectItem>
                                        {statuses.map((status) => (
                                            <SelectItem
                                                key={status}
                                                value={status}
                                            >
                                                {t(`Leave status ${status}`)}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="head-leave-start-date">
                                    {t('Start date on or after')}
                                </Label>
                                <Input
                                    id="head-leave-start-date"
                                    type="date"
                                    dir={i18n.dir()}
                                    value={values.startDate}
                                    max={values.endDate || undefined}
                                    onChange={(event) =>
                                        setValues((current) => ({
                                            ...current,
                                            startDate: event.target.value,
                                        }))
                                    }
                                />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="head-leave-end-date">
                                    {t('End date on or before')}
                                </Label>
                                <Input
                                    id="head-leave-end-date"
                                    type="date"
                                    dir={i18n.dir()}
                                    value={values.endDate}
                                    min={values.startDate || undefined}
                                    onChange={(event) =>
                                        setValues((current) => ({
                                            ...current,
                                            endDate: event.target.value,
                                        }))
                                    }
                                />
                            </div>
                        </div>
                        <div className="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                            {hasFilters ? (
                                <Button
                                    type="button"
                                    variant="outline"
                                    onClick={clearFilters}
                                >
                                    {t('Clear filters')}
                                </Button>
                            ) : null}
                            <Button type="submit">{t('Apply filters')}</Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <Card className="border-border/80 bg-sidebar shadow-xs">
                <CardHeader>
                    <CardTitle>{t('Regular Leave requests')}</CardTitle>
                    <CardDescription>
                        {t('Requests found', {
                            count: leaveRequests.meta.total,
                        })}
                    </CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    {leaveRequests.data.length > 0 ? (
                        <ul className="divide-border overflow-hidden rounded-lg border">
                            {leaveRequests.data.map((request) => (
                                <li
                                    key={request.id}
                                    className="space-y-4 p-4 sm:p-5"
                                >
                                    <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div className="min-w-0 space-y-1">
                                            <h2 className="text-foreground font-medium break-words">
                                                {request.employee?.name ??
                                                    t('Not available')}
                                            </h2>
                                            <p className="text-muted-foreground text-sm">
                                                {request.employee
                                                    ?.employeeCode ??
                                                    t('Not available')}
                                                {' · '}
                                                {request.leaveType?.label ??
                                                    t('Leave type unavailable')}
                                            </p>
                                        </div>
                                        <HeadRequestStatusBadge
                                            status={request.status}
                                        />
                                    </div>
                                    <dl className="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                        <DateDetail
                                            label={t('From')}
                                            date={request.startDate}
                                            locale={i18n.language}
                                        />
                                        <DateDetail
                                            label={t('To')}
                                            date={request.endDate}
                                            locale={i18n.language}
                                        />
                                        <Detail
                                            label={t('Duration')}
                                            value={`${new Intl.NumberFormat(i18n.language).format(request.durationDays)} ${t('days')}`}
                                        />
                                        <DateDetail
                                            label={t('Submitted')}
                                            date={request.submittedDate}
                                            locale={i18n.language}
                                        />
                                    </dl>
                                    {request.reason ? (
                                        <p className="text-muted-foreground text-sm break-words">
                                            <span className="text-foreground font-medium">
                                                {t('Reason or notes')}:{' '}
                                            </span>
                                            {request.reason}
                                        </p>
                                    ) : null}
                                </li>
                            ))}
                        </ul>
                    ) : (
                        <div className="flex flex-col items-center gap-3 rounded-lg border py-10 text-center">
                            <span className="bg-muted text-muted-foreground flex size-11 items-center justify-center rounded-lg">
                                <CalendarRange
                                    className="size-5"
                                    aria-hidden="true"
                                />
                            </span>
                            <p className="text-foreground font-medium">
                                {hasFilters
                                    ? t(
                                          'No Regular Leave requests match these filters.',
                                      )
                                    : t(
                                          'No Regular Leave requests are available.',
                                      )}
                            </p>
                        </div>
                    )}
                    <HeadRequestPagination
                        links={leaveRequests.links}
                        meta={leaveRequests.meta}
                    />
                </CardContent>
            </Card>
        </main>
    );
}

function Detail({ label, value }: { label: string; value: string }) {
    return (
        <div className="min-w-0 space-y-1">
            <dt className="text-muted-foreground text-xs">{label}</dt>
            <dd className="text-foreground text-sm font-medium break-words">
                {value}
            </dd>
        </div>
    );
}

function DateDetail({
    date,
    label,
    locale,
}: {
    date: string;
    label: string;
    locale: string;
}) {
    return (
        <div className="min-w-0 space-y-1">
            <dt className="text-muted-foreground text-xs">{label}</dt>
            <dd className="text-foreground text-sm font-medium">
                <time dateTime={date}>{formatHeadDate(date, locale)}</time>
            </dd>
        </div>
    );
}
