import {
    ChevronLeft,
    ChevronRight,
    Search,
    SlidersHorizontal,
} from 'lucide-react';
import { useMemo, useRef, useState } from 'react';
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
} from '@/types/leave';
import { LeaveDetailDrawer } from './leave-detail-drawer';
import { StatusBadge } from './status-badge';

type LeaveHistoryTableProps = {
    requests: RegularLeaveRequest[];
    leaveTypes: LeaveTypeOption[];
    pageSize?: number;
};

const statusOptions: { value: LeaveRequestStatus; label: string }[] = [
    { value: 'pending', label: 'Pending' },
    { value: 'approved', label: 'Approved' },
    { value: 'rejected', label: 'Rejected' },
    { value: 'cancelled', label: 'Cancelled' },
];

function isLeaveRequestStatus(value: string): value is LeaveRequestStatus {
    return statusOptions.some((option) => option.value === value);
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
        const normalizedQuery = query.trim().toLocaleLowerCase();

        return [...requests]
            .filter((request) => {
                const matchesQuery =
                    !normalizedQuery ||
                    request.leaveTypeName
                        .toLocaleLowerCase()
                        .includes(normalizedQuery) ||
                    request.reason
                        ?.toLocaleLowerCase()
                        .includes(normalizedQuery);
                const matchesLeaveType =
                    leaveTypeId === 'all' ||
                    request.leaveTypeId === leaveTypeId;
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
    }, [fromDate, leaveTypeId, query, requests, status, toDate]);

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

    return (
        <section
            id="leave-history-section"
            aria-labelledby="leave-history-heading"
        >
            <div className="mb-4 space-y-1">
                <h2
                    id="leave-history-heading"
                    className="text-xl font-semibold"
                >
                    Leave history
                </h2>
                <p className="text-muted-foreground text-sm">
                    Regular Leave requests only. Short Leave has its own
                    history.
                </p>
            </div>

            <div className="bg-card border-border/60 space-y-4 rounded-xl border p-4 shadow-xs">
                <div className="flex items-center gap-2">
                    <SlidersHorizontal
                        className="text-muted-foreground size-4"
                        aria-hidden="true"
                    />
                    <h3 className="font-medium">Filter requests</h3>
                </div>
                <div className="grid gap-3 md:grid-cols-2 xl:grid-cols-[minmax(0,1.5fr)_repeat(4,minmax(0,1fr))]">
                    <div className="space-y-2 md:col-span-2 xl:col-span-1">
                        <Label htmlFor="leave-history-query">Search</Label>
                        <div className="relative">
                            <Search
                                className="text-muted-foreground pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2"
                                aria-hidden="true"
                            />
                            <Input
                                id="leave-history-query"
                                value={query}
                                onChange={(event) => {
                                    setQuery(event.target.value);
                                    resetPage();
                                }}
                                className="pl-9"
                                placeholder="Search leave type or reason"
                            />
                        </div>
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="leave-history-type">Leave type</Label>
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
                                <SelectValue placeholder="All leave types" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">
                                    All leave types
                                </SelectItem>
                                {leaveTypes.map((leaveType) => (
                                    <SelectItem
                                        key={leaveType.id}
                                        value={leaveType.id}
                                    >
                                        {leaveType.label}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="leave-history-status">Status</Label>
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
                                <SelectValue placeholder="All statuses" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">
                                    All statuses
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
                        <Label htmlFor="leave-history-from">From date</Label>
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
                        <Label htmlFor="leave-history-to">To date</Label>
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
                        {filteredRequests.length} request
                        {filteredRequests.length === 1 ? '' : 's'} found
                    </p>
                    <Button
                        type="button"
                        variant="ghost"
                        size="sm"
                        onClick={clearFilters}
                    >
                        Clear filters
                    </Button>
                </div>
            </div>

            {visibleRequests.length > 0 ? (
                <>
                    <div className="bg-card border-border/60 mt-4 hidden overflow-x-auto rounded-xl border shadow-xs lg:block">
                        <table className="w-full min-w-max text-left text-sm">
                            <thead className="bg-muted/50 text-muted-foreground">
                                <tr>
                                    <th className="px-4 py-3 font-medium">
                                        Leave type
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        From
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        To
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        Duration
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        Status
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        Applied on
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        Approval stage
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        <span className="sr-only">Details</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-border divide-y">
                                {visibleRequests.map((request) => (
                                    <tr key={request.id}>
                                        <td className="px-4 py-3 font-medium">
                                            {request.leaveTypeName}
                                        </td>
                                        <td className="px-4 py-3">
                                            {request.startDate}
                                        </td>
                                        <td className="px-4 py-3">
                                            {request.endDate}
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
                                            {request.appliedAt}
                                        </td>
                                        <td className="px-4 py-3">
                                            {request.currentStage ??
                                                'Not available'}
                                        </td>
                                        <td className="px-4 py-3 text-right">
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
                                                View details
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
                                            {request.startDate} –{' '}
                                            {request.endDate}
                                        </p>
                                    </div>
                                    <StatusBadge tone={request.statusTone}>
                                        {request.statusLabel}
                                    </StatusBadge>
                                </div>
                                <dl className="grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <dt className="text-muted-foreground">
                                            Duration
                                        </dt>
                                        <dd className="font-medium">
                                            {request.durationLabel}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt className="text-muted-foreground">
                                            Applied on
                                        </dt>
                                        <dd className="font-medium">
                                            {request.appliedAt}
                                        </dd>
                                    </div>
                                    <div className="col-span-2">
                                        <dt className="text-muted-foreground">
                                            Approval stage
                                        </dt>
                                        <dd className="font-medium">
                                            {request.currentStage ??
                                                'Not available'}
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
                                    View details
                                </Button>
                            </li>
                        ))}
                    </ul>
                </>
            ) : (
                <div className="bg-card border-border/60 text-muted-foreground mt-4 flex min-h-52 flex-col items-center justify-center gap-2 rounded-xl border p-6 text-center text-sm shadow-xs">
                    <Search className="size-5" aria-hidden="true" />
                    <p>No Regular Leave requests match these filters.</p>
                    <Button
                        type="button"
                        variant="outline"
                        size="sm"
                        onClick={clearFilters}
                    >
                        Reset filters
                    </Button>
                </div>
            )}

            {filteredRequests.length > 0 && (
                <nav
                    aria-label="Leave history pages"
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
                        Previous
                    </Button>
                    <p
                        className="text-muted-foreground text-sm"
                        aria-live="polite"
                    >
                        Page {currentPage} of {pageCount}
                    </p>
                    <Button
                        type="button"
                        variant="outline"
                        size="sm"
                        disabled={currentPage === pageCount}
                        onClick={() => setPage((current) => current + 1)}
                    >
                        Next
                        <ChevronRight className="size-4" aria-hidden="true" />
                    </Button>
                </nav>
            )}

            <LeaveDetailDrawer
                request={selectedRequest}
                open={isDetailOpen}
                onOpenChange={setIsDetailOpen}
                returnFocusTarget={detailTriggerRef}
            />
        </section>
    );
}
