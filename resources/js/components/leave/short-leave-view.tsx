import {
    CalendarClock,
    CircleAlert,
    Clock3,
    FileClock,
    Search,
    SlidersHorizontal,
} from 'lucide-react';
import type { ReactNode } from 'react';
import { useMemo, useState } from 'react';
import { useTranslation } from 'react-i18next';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
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
import { Skeleton } from '@/components/ui/skeleton';
import type {
    LeaveRequestStatus,
    ShortLeaveItem,
    ShortLeavePageState,
} from '@/types';

import {
    formatLeaveDate,
    formatLeaveNumber,
    formatLeaveTime,
} from './leave-formatters';
import { StatusBadge } from './status-badge';

type ShortLeaveViewProps = {
    state: ShortLeavePageState;
    onRequestShortLeave?: () => void;
};

const statusValues: LeaveRequestStatus[] = [
    'pending',
    'approved',
    'rejected',
    'cancelled',
];

function isLeaveRequestStatus(value: string): value is LeaveRequestStatus {
    return statusValues.some((status) => status === value);
}

function ShortLeaveLoading() {
    const { t } = useTranslation();

    return (
        <div
            role="status"
            aria-label={t('Loading Short Leave information')}
            className="space-y-6"
        >
            <div className="space-y-2">
                <Skeleton className="h-8 w-36" />
                <Skeleton className="h-4 w-72" />
            </div>
            <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                {Array.from({ length: 3 }, (_, index) => (
                    <Skeleton key={index} className="h-40" />
                ))}
            </div>
            <Skeleton className="h-80" />
        </div>
    );
}

function matchesDateRange(
    request: ShortLeaveItem,
    fromDate: string,
    toDate: string,
) {
    if (fromDate && request.date < fromDate) {
        return false;
    }

    if (toDate && request.date > toDate) {
        return false;
    }

    return true;
}

function ShortLeaveContent({
    state,
    onRequestShortLeave,
}: {
    state: Extract<ShortLeavePageState, { status: 'ready' }>;
    onRequestShortLeave?: () => void;
}) {
    const { t, i18n } = useTranslation();
    const [status, setStatus] = useState<'all' | LeaveRequestStatus>('all');
    const [fromDate, setFromDate] = useState('');
    const [toDate, setToDate] = useState('');

    const requests = useMemo(
        () =>
            [...state.data.requests]
                .filter(
                    (request) =>
                        (status === 'all' || request.status === status) &&
                        matchesDateRange(request, fromDate, toDate),
                )
                .sort((first, second) => second.date.localeCompare(first.date)),
        [fromDate, state.data.requests, status, toDate],
    );

    const clearFilters = () => {
        setStatus('all');
        setFromDate('');
        setToDate('');
    };

    const statusOptions = statusValues.map((value) => ({
        value,
        label: t(`Leave status ${value}`),
    }));

    return (
        <div dir={i18n.dir()} className="space-y-6">
            <section
                aria-labelledby="short-leave-heading"
                className="space-y-3"
            >
                <div className="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div className="space-y-1 text-start">
                        <h1
                            id="short-leave-heading"
                            className="text-2xl font-semibold tracking-tight"
                        >
                            {t('Short Leave')}
                        </h1>
                        <p className="text-muted-foreground text-sm">
                            {t(
                                'Review Short Leave requests separately from Regular Leave.',
                            )}
                        </p>
                    </div>
                    <Button
                        type="button"
                        onClick={onRequestShortLeave}
                        disabled={!onRequestShortLeave}
                    >
                        <CalendarClock className="size-4" aria-hidden="true" />
                        {t('Request Short Leave')}
                    </Button>
                </div>
                {!onRequestShortLeave ? (
                    <p className="text-muted-foreground text-sm">
                        {t(
                            'The Short Leave application layout is awaiting policy and workflow confirmation.',
                        )}
                    </p>
                ) : null}
            </section>

            <section
                aria-label={t('Short Leave summary')}
                className="grid gap-4 md:grid-cols-2 xl:grid-cols-3"
            >
                <SummaryCard
                    title={t('Usage summary')}
                    description={t('Policy-supplied Short Leave information.')}
                    icon={Clock3}
                >
                    <p className="font-medium">
                        {state.data.summary.monthlyUsageLabel ??
                            t('Usage information is not available.')}
                    </p>
                </SummaryCard>
                <SummaryCard
                    title={t('Pending requests')}
                    description={t('Short Leave requests awaiting a decision.')}
                    icon={FileClock}
                >
                    <p className="text-2xl font-semibold">
                        {formatLeaveNumber(
                            state.data.summary.pendingCount,
                            i18n.language,
                        )}
                    </p>
                </SummaryCard>
                <Card className="border-border/60 gap-4 py-5 shadow-xs">
                    <CardHeader className="px-5">
                        <CardTitle className="text-base">
                            {t('Policy information')}
                        </CardTitle>
                        <CardDescription>
                            {t(
                                'Supplied by the authorized Short Leave policy.',
                            )}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="px-5">
                        <p className="text-muted-foreground text-sm">
                            {state.data.summary.policyMessage ??
                                t(
                                    'Short Leave policy information is not available.',
                                )}
                        </p>
                    </CardContent>
                </Card>
            </section>

            <section
                aria-labelledby="short-leave-history-heading"
                className="space-y-4"
            >
                <div className="space-y-1 text-start">
                    <h2
                        id="short-leave-history-heading"
                        className="text-xl font-semibold"
                    >
                        {t('Short Leave history')}
                    </h2>
                    <p className="text-muted-foreground text-sm">
                        {t(
                            'Filter your Short Leave requests by date and status.',
                        )}
                    </p>
                </div>

                <div className="bg-card border-border/60 space-y-4 rounded-xl border p-4 shadow-xs">
                    <div className="flex items-center gap-2">
                        <SlidersHorizontal
                            className="text-muted-foreground size-4"
                            aria-hidden="true"
                        />
                        <h3 className="font-medium">{t('Filter requests')}</h3>
                    </div>
                    <div className="grid gap-3 sm:grid-cols-3">
                        <div className="space-y-2">
                            <Label htmlFor="short-leave-status">
                                {t('Status')}
                            </Label>
                            <Select
                                value={status}
                                onValueChange={(value) => {
                                    if (
                                        value === 'all' ||
                                        isLeaveRequestStatus(value)
                                    ) {
                                        setStatus(value);
                                    }
                                }}
                            >
                                <SelectTrigger
                                    id="short-leave-status"
                                    className="w-full"
                                >
                                    <SelectValue
                                        placeholder={t('All statuses')}
                                    />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">
                                        {t('All statuses')}
                                    </SelectItem>
                                    {statusOptions.map((option) => (
                                        <SelectItem
                                            key={option.value}
                                            value={option.value}
                                        >
                                            {option.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="short-leave-from">
                                {t('From date')}
                            </Label>
                            <Input
                                id="short-leave-from"
                                type="date"
                                value={fromDate}
                                onChange={(event) =>
                                    setFromDate(event.target.value)
                                }
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="short-leave-to">
                                {t('To date')}
                            </Label>
                            <Input
                                id="short-leave-to"
                                type="date"
                                value={toDate}
                                onChange={(event) =>
                                    setToDate(event.target.value)
                                }
                            />
                        </div>
                    </div>
                    <div className="flex items-center justify-between gap-3 border-t pt-4">
                        <p
                            className="text-muted-foreground text-sm"
                            aria-live="polite"
                        >
                            {t('Requests found', {
                                count: formatLeaveNumber(
                                    requests.length,
                                    i18n.language,
                                ),
                            })}
                        </p>
                        <Button
                            type="button"
                            variant="ghost"
                            size="sm"
                            onClick={clearFilters}
                        >
                            {t('Clear filters')}
                        </Button>
                    </div>
                </div>

                {requests.length > 0 ? (
                    <ul className="grid gap-3" role="list">
                        {requests.map((request) => (
                            <li
                                key={request.id}
                                className="bg-card border-border/60 flex flex-col gap-4 rounded-xl border p-4 shadow-xs sm:flex-row sm:items-start sm:justify-between"
                            >
                                <div className="min-w-0 space-y-2 text-start">
                                    <div className="flex flex-wrap items-center gap-2">
                                        <p className="font-medium">
                                            {formatLeaveDate(
                                                request.date,
                                                i18n.language,
                                            )}
                                        </p>
                                        <StatusBadge tone={request.statusTone}>
                                            {request.statusLabel}
                                        </StatusBadge>
                                    </div>
                                    <p className="text-muted-foreground text-sm">
                                        {formatLeaveTime(
                                            request.startTime,
                                            i18n.language,
                                        )}{' '}
                                        –{' '}
                                        {formatLeaveTime(
                                            request.endTime,
                                            i18n.language,
                                        )}{' '}
                                        · {request.durationLabel}
                                    </p>
                                    {request.reason ? (
                                        <p className="text-muted-foreground text-sm">
                                            {request.reason}
                                        </p>
                                    ) : null}
                                </div>
                                <div className="text-muted-foreground text-sm sm:text-end">
                                    <p>
                                        {request.currentStage ??
                                            t('Stage not available')}
                                    </p>
                                </div>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <div className="bg-card border-border/60 text-muted-foreground flex min-h-52 flex-col items-center justify-center gap-2 rounded-xl border p-6 text-center text-sm shadow-xs">
                        <Search className="size-5" aria-hidden="true" />
                        <p>
                            {t('No Short Leave requests match these filters.')}
                        </p>
                        <Button
                            type="button"
                            variant="outline"
                            size="sm"
                            onClick={clearFilters}
                        >
                            {t('Reset filters')}
                        </Button>
                    </div>
                )}
            </section>
        </div>
    );
}

export function ShortLeaveView({
    state,
    onRequestShortLeave,
}: ShortLeaveViewProps) {
    const { t } = useTranslation();

    if (state.status === 'loading') {
        return <ShortLeaveLoading />;
    }

    if (state.status === 'error') {
        return (
            <Alert variant="destructive">
                <CircleAlert aria-hidden="true" />
                <AlertTitle>
                    {t('Short Leave information is unavailable')}
                </AlertTitle>
                <AlertDescription>{state.message}</AlertDescription>
            </Alert>
        );
    }

    return (
        <ShortLeaveContent
            state={state}
            onRequestShortLeave={onRequestShortLeave}
        />
    );
}

function SummaryCard({
    title,
    description,
    icon: Icon,
    children,
}: {
    title: string;
    description: string;
    icon: typeof Clock3;
    children: ReactNode;
}) {
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
