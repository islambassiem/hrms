import {
    ChevronLeft,
    ChevronRight,
    Search,
    SlidersHorizontal,
} from 'lucide-react';
import type { ReactNode } from 'react';
import { useMemo, useRef, useState } from 'react';
import { useTranslation } from 'react-i18next';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import type {
    LeaveRequestStatus,
    LeaveTypeOption,
    RegularLeaveRequest,
} from '@/types';

import { LeaveDetailDrawer } from './leave-detail-drawer';
import { formatLeaveDate, formatLeaveNumber } from './leave-formatters';
import { StatusBadge } from './status-badge';

type LeaveHistoryTableProps = {
    requests: RegularLeaveRequest[];
    leaveTypes: LeaveTypeOption[];
    pageSize?: number;
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

function matchesDateRange(
    request: RegularLeaveRequest,
    fromDate: string,
    toDate: string,
) {
    if (fromDate && request.startDate < fromDate) {
        return false;
    }

    if (toDate && request.endDate > toDate) {
        return false;
    }

    return true;
}

export function LeaveHistoryTable({
    requests,
    leaveTypes,
    pageSize = 10,
}: LeaveHistoryTableProps) {
    const { t, i18n } = useTranslation();
    const [query, setQuery] = useState('');
    const [leaveTypeId, setLeaveTypeId] = useState('all');
    const [status, setStatus] = useState<'all' | LeaveRequestStatus>('all');
    const [fromDate, setFromDate] = useState('');
    const [toDate, setToDate] = useState('');
    const [page, setPage] = useState(1);
    const [selectedRequest, setSelectedRequest] =
        useState<RegularLeaveRequest | null>(null);
    const [isDetailOpen, setIsDetailOpen] = useState(false);
    const detailTriggerRef = useRef<HTMLButtonElement | null>(null);

    const filteredRequests = useMemo(() => {
        const normalizedQuery = query.trim().toLocaleLowerCase(i18n.language);

        return [...requests]
            .filter((request) => {
                const matchesQuery =
                    !normalizedQuery ||
                    request.leaveTypeName
                        .toLocaleLowerCase(i18n.language)
                        .includes(normalizedQuery) ||
                    request.reason
                        ?.toLocaleLowerCase(i18n.language)
                        .includes(normalizedQuery);
                const matchesLeaveType =
                    leaveTypeId === 'all' ||
                    request.leaveTypeId === Number(leaveTypeId);
                const matchesStatus =
                    status === 'all' || request.status === status;

                return (
                    matchesQuery &&
                    matchesLeaveType &&
                    matchesStatus &&
                    matchesDateRange(request, fromDate, toDate)
                );
            })
            .sort((first, second) =>
                second.appliedAt.localeCompare(first.appliedAt),
            );
    }, [fromDate, i18n.language, leaveTypeId, query, requests, status, toDate]);

    const pageCount = Math.max(
        1,
        Math.ceil(filteredRequests.length / pageSize),
    );
    const currentPage = Math.min(page, pageCount);
    const firstRequestIndex = (currentPage - 1) * pageSize;
    const visibleRequests = filteredRequests.slice(
        firstRequestIndex,
        firstRequestIndex + pageSize,
    );

    const resetPage = () => setPage(1);

    const openRequestDetails = (
        request: RegularLeaveRequest,
        trigger: HTMLButtonElement,
    ) => {
        detailTriggerRef.current = trigger;
        setSelectedRequest(request);
        setIsDetailOpen(true);
    };

    const clearFilters = () => {
        setQuery('');
        setLeaveTypeId('all');
        setStatus('all');
        setFromDate('');
        setToDate('');
        resetPage();
    };

    const statusOptions = statusValues.map((value) => ({
        value,
        label: t(`Leave status ${value}`),
    }));

    return (
        <section
            id="leave-history-section"
            aria-labelledby="leave-history-heading"
            dir={i18n.dir()}
        >
            <div className="mb-4 space-y-1 text-start">
                <h2
                    id="leave-history-heading"
                    className="text-xl font-semibold"
                >
                    {t('Leave history')}
                </h2>
                <p className="text-muted-foreground text-sm">
                    {t(
                        'Regular Leave requests only. Short Leave has its own history.',
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
                <div className="grid gap-3 md:grid-cols-2 xl:grid-cols-[minmax(0,1.5fr)_repeat(4,minmax(0,1fr))]">
                    <div className="space-y-2 md:col-span-2 xl:col-span-1">
                        <Label htmlFor="leave-history-query">
                            {t('Search')}
                        </Label>
                        <div className="relative">
                            <Search
                                className="text-muted-foreground pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2"
                                aria-hidden="true"
                            />
                            <Input
                                id="leave-history-query"
                                value={query}
                                onChange={(event) => {
                                    setQuery(event.target.value);
                                    resetPage();
                                }}
                                className="ps-9"
                                placeholder={t('Search leave type or reason')}
                            />
                        </div>
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="leave-history-type">
                            {t('Leave type')}
                        </Label>
                        <Select
                            value={leaveTypeId}
                            onValueChange={(value) => {
                                setLeaveTypeId(value);
                                resetPage();
                            }}
                        >
                            <SelectTrigger
                                id="leave-history-type"
                                className="w-full"
                            >
                                <SelectValue
                                    placeholder={t('All leave types')}
                                />
                            </SelectTrigger>
                            <SelectContent>
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
                        <Label htmlFor="leave-history-status">
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
                                    resetPage();
                                }
                            }}
                        >
                            <SelectTrigger
                                id="leave-history-status"
                                className="w-full"
                            >
                                <SelectValue placeholder={t('All statuses')} />
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
                        <Label htmlFor="leave-history-from">
                            {t('From date')}
                        </Label>
                        <Input
                            id="leave-history-from"
                            type="date"
                            value={fromDate}
                            onChange={(event) => {
                                setFromDate(event.target.value);
                                resetPage();
                            }}
                        />
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="leave-history-to">{t('To date')}</Label>
                        <Input
                            id="leave-history-to"
                            type="date"
                            value={toDate}
                            onChange={(event) => {
                                setToDate(event.target.value);
                                resetPage();
                            }}
                        />
                    </div>
                </div>
                <div className="flex flex-col gap-3 border-t pt-4 sm:flex-row sm:items-center sm:justify-between">
                    <p
                        className="text-muted-foreground text-sm"
                        aria-live="polite"
                    >
                        {t('Requests found', {
                            count: formatLeaveNumber(
                                filteredRequests.length,
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

            {visibleRequests.length > 0 ? (
                <>
                    <div className="bg-card border-border/60 mt-4 hidden overflow-x-auto rounded-xl border shadow-xs lg:block">
                        <table className="w-full min-w-max text-start text-sm">
                            <thead className="bg-muted/50 text-muted-foreground">
                                <tr>
                                    <TableHeading>
                                        {t('Leave type')}
                                    </TableHeading>
                                    <TableHeading>{t('From')}</TableHeading>
                                    <TableHeading>{t('To')}</TableHeading>
                                    <TableHeading>{t('Duration')}</TableHeading>
                                    <TableHeading>{t('Status')}</TableHeading>
                                    <TableHeading>
                                        {t('Applied on')}
                                    </TableHeading>
                                    <TableHeading>
                                        {t('Approval stage')}
                                    </TableHeading>
                                    <TableHeading>
                                        <span className="sr-only">
                                            {t('Details')}
                                        </span>
                                    </TableHeading>
                                </tr>
                            </thead>
                            <tbody className="divide-border divide-y">
                                {visibleRequests.map((request) => (
                                    <tr key={request.id}>
                                        <td className="px-4 py-3 font-medium">
                                            {request.leaveTypeName}
                                        </td>
                                        <td className="px-4 py-3">
                                            {formatLeaveDate(
                                                request.startDate,
                                                i18n.language,
                                            )}
                                        </td>
                                        <td className="px-4 py-3">
                                            {formatLeaveDate(
                                                request.endDate,
                                                i18n.language,
                                            )}
                                        </td>
                                        <td className="px-4 py-3">
                                            {request.durationLabel}
                                        </td>
                                        <td className="px-4 py-3">
                                            <StatusBadge
                                                tone={request.statusTone}
                                            >
                                                {request.statusLabel}
                                            </StatusBadge>
                                        </td>
                                        <td className="px-4 py-3">
                                            {formatLeaveDate(
                                                request.appliedAt,
                                                i18n.language,
                                            )}
                                        </td>
                                        <td className="px-4 py-3">
                                            {request.currentStage ??
                                                t('Not available')}
                                        </td>
                                        <td className="px-4 py-3 text-end">
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="sm"
                                                onClick={(event) =>
                                                    openRequestDetails(
                                                        request,
                                                        event.currentTarget,
                                                    )
                                                }
                                            >
                                                {t('View details')}
                                            </Button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <ul className="mt-4 grid gap-3 lg:hidden" role="list">
                        {visibleRequests.map((request) => (
                            <li
                                key={request.id}
                                className="bg-card border-border/60 space-y-4 rounded-xl border p-4 shadow-xs"
                            >
                                <div className="flex flex-wrap items-start justify-between gap-2">
                                    <div>
                                        <p className="font-medium">
                                            {request.leaveTypeName}
                                        </p>
                                        <p className="text-muted-foreground text-sm">
                                            {formatLeaveDate(
                                                request.startDate,
                                                i18n.language,
                                            )}{' '}
                                            –{' '}
                                            {formatLeaveDate(
                                                request.endDate,
                                                i18n.language,
                                            )}
                                        </p>
                                    </div>
                                    <StatusBadge tone={request.statusTone}>
                                        {request.statusLabel}
                                    </StatusBadge>
                                </div>
                                <dl className="grid grid-cols-2 gap-3 text-sm">
                                    <Detail
                                        label={t('Duration')}
                                        value={request.durationLabel}
                                    />
                                    <Detail
                                        label={t('Applied on')}
                                        value={formatLeaveDate(
                                            request.appliedAt,
                                            i18n.language,
                                        )}
                                    />
                                    <div className="col-span-2">
                                        <dt className="text-muted-foreground">
                                            {t('Approval stage')}
                                        </dt>
                                        <dd className="font-medium">
                                            {request.currentStage ??
                                                t('Not available')}
                                        </dd>
                                    </div>
                                </dl>
                                <Button
                                    type="button"
                                    variant="outline"
                                    className="w-full"
                                    onClick={(event) =>
                                        openRequestDetails(
                                            request,
                                            event.currentTarget,
                                        )
                                    }
                                >
                                    {t('View details')}
                                </Button>
                            </li>
                        ))}
                    </ul>
                </>
            ) : (
                <div className="bg-card border-border/60 text-muted-foreground mt-4 flex min-h-52 flex-col items-center justify-center gap-2 rounded-xl border p-6 text-center text-sm shadow-xs">
                    <Search className="size-5" aria-hidden="true" />
                    <p>{t('No Regular Leave requests match these filters.')}</p>
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

            {filteredRequests.length > 0 ? (
                <nav
                    aria-label={t('Leave history pages')}
                    className="mt-4 flex items-center justify-between gap-3"
                >
                    <Button
                        type="button"
                        variant="outline"
                        size="sm"
                        disabled={currentPage === 1}
                        onClick={() => setPage((current) => current - 1)}
                    >
                        <ChevronLeft className="size-4" aria-hidden="true" />
                        {t('Previous')}
                    </Button>
                    <p
                        className="text-muted-foreground text-sm"
                        aria-live="polite"
                    >
                        {t('Leave history page', {
                            current: formatLeaveNumber(
                                currentPage,
                                i18n.language,
                            ),
                            total: formatLeaveNumber(pageCount, i18n.language),
                        })}
                    </p>
                    <Button
                        type="button"
                        variant="outline"
                        size="sm"
                        disabled={currentPage === pageCount}
                        onClick={() => setPage((current) => current + 1)}
                    >
                        {t('Next')}
                        <ChevronRight className="size-4" aria-hidden="true" />
                    </Button>
                </nav>
            ) : null}

            <LeaveDetailDrawer
                request={selectedRequest}
                open={isDetailOpen}
                onOpenChange={setIsDetailOpen}
                returnFocusTarget={detailTriggerRef}
            />
        </section>
    );
}

function TableHeading({ children }: { children: ReactNode }) {
    return <th className="px-4 py-3 font-medium">{children}</th>;
}

function Detail({ label, value }: { label: string; value: string | null }) {
    return (
        <div>
            <dt className="text-muted-foreground">{label}</dt>
            <dd className="font-medium">{value}</dd>
        </div>
    );
}
