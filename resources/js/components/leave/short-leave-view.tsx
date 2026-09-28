import {
    CalendarClock,
    CircleAlert,
    Clock3,
    FileClock,
    Search,
    SlidersHorizontal,
} from 'lucide-react';
import { useMemo, useState } from 'react';
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
} from '@/types/leave';
import { StatusBadge } from './status-badge';

type ShortLeaveViewProps = {
    state: ShortLeavePageState;
    onRequestShortLeave?: () => void;
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

function ShortLeaveLoading() {
    return (
        <div aria-label="Loading Short Leave information" className="space-y-6">
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

    return (
        <div className="space-y-6">
            <section
                aria-labelledby="short-leave-heading"
                className="space-y-3"
            >
                <div className="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div className="space-y-1">
                        <h1
                            id="short-leave-heading"
                            className="text-2xl font-semibold tracking-tight"
                        >
                            Short Leave
                        </h1>
                        <p className="text-muted-foreground text-sm">
                            Review Short Leave requests separately from Regular
                            Leave.
                        </p>
                    </div>
                    <Button
                        type="button"
                        onClick={onRequestShortLeave}
                        disabled={!onRequestShortLeave}
                    >
                        <CalendarClock className="size-4" aria-hidden="true" />
                        Request Short Leave
                    </Button>
                </div>
                {!onRequestShortLeave && (
                    <p className="text-muted-foreground text-sm">
                        The Short Leave application layout is awaiting policy
                        and workflow confirmation.
                    </p>
                )}
            </section>

            <section
                aria-label="Short Leave summary"
                className="grid gap-4 md:grid-cols-2 xl:grid-cols-3"
            >
                <Card className="border-border/60 gap-4 py-5 shadow-xs">
                    <CardHeader className="flex-row items-start justify-between gap-3 px-5">
                        <div className="space-y-1">
                            <CardTitle className="text-base">
                                Usage summary
                            </CardTitle>
                            <CardDescription>
                                Policy-supplied Short Leave information.
                            </CardDescription>
                        </div>
                        <span className="bg-muted text-muted-foreground rounded-md p-2">
                            <Clock3 className="size-4" aria-hidden="true" />
                        </span>
                    </CardHeader>
                    <CardContent className="px-5">
                        <p className="font-medium">
                            {state.data.summary.monthlyUsageLabel ??
                                'Usage information is not available.'}
                        </p>
                    </CardContent>
                </Card>
                <Card className="border-border/60 gap-4 py-5 shadow-xs">
                    <CardHeader className="flex-row items-start justify-between gap-3 px-5">
                        <div className="space-y-1">
                            <CardTitle className="text-base">
                                Pending requests
                            </CardTitle>
                            <CardDescription>
                                Short Leave requests awaiting a decision.
                            </CardDescription>
                        </div>
                        <span className="bg-muted text-muted-foreground rounded-md p-2">
                            <FileClock className="size-4" aria-hidden="true" />
                        </span>
                    </CardHeader>
                    <CardContent className="px-5">
                        <p className="text-2xl font-semibold">
                            {state.data.summary.pendingCount}
                        </p>
                    </CardContent>
                </Card>
                <Card className="border-border/60 gap-4 py-5 shadow-xs">
                    <CardHeader className="px-5">
                        <CardTitle className="text-base">
                            Policy information
                        </CardTitle>
                        <CardDescription>
                            Supplied by the authorized Short Leave policy.
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="px-5">
                        <p className="text-muted-foreground text-sm">
                            {state.data.summary.policyMessage ??
                                'Short Leave policy information is not available.'}
                        </p>
                    </CardContent>
                </Card>
            </section>

            <section
                aria-labelledby="short-leave-history-heading"
                className="space-y-4"
            >
                <div className="space-y-1">
                    <h2
                        id="short-leave-history-heading"
                        className="text-xl font-semibold"
                    >
                        Short Leave history
                    </h2>
                    <p className="text-muted-foreground text-sm">
                        Filter your Short Leave requests by date and status.
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
                    <div className="grid gap-3 sm:grid-cols-3">
                        <div className="space-y-2">
                            <Label htmlFor="short-leave-status">Status</Label>
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
                            <Label htmlFor="short-leave-from">From date</Label>
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
                            <Label htmlFor="short-leave-to">To date</Label>
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
                            {requests.length} request
                            {requests.length === 1 ? '' : 's'} found
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

                {requests.length > 0 ? (
                    <ul className="grid gap-3" role="list">
                        {requests.map((request) => (
                            <li
                                key={request.id}
                                className="bg-card border-border/60 flex flex-col gap-4 rounded-xl border p-4 shadow-xs sm:flex-row sm:items-start sm:justify-between"
                            >
                                <div className="min-w-0 space-y-2">
                                    <div className="flex flex-wrap items-center gap-2">
                                        <p className="font-medium">
                                            {request.date}
                                        </p>
                                        <StatusBadge tone={request.statusTone}>
                                            {request.statusLabel}
                                        </StatusBadge>
                                    </div>
                                    <p className="text-muted-foreground text-sm">
                                        {request.startTime} – {request.endTime}{' '}
                                        · {request.durationLabel}
                                    </p>
                                    {request.reason && (
                                        <p className="text-muted-foreground text-sm">
                                            {request.reason}
                                        </p>
                                    )}
                                </div>
                                <div className="text-muted-foreground text-sm sm:text-right">
                                    <p>
                                        {request.currentStage ??
                                            'Stage not available'}
                                    </p>
                                </div>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <div className="bg-card border-border/60 text-muted-foreground flex min-h-52 flex-col items-center justify-center gap-2 rounded-xl border p-6 text-center text-sm shadow-xs">
                        <Search className="size-5" aria-hidden="true" />
                        <p>No Short Leave requests match these filters.</p>
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
            </section>
        </div>
    );
}

export function ShortLeaveView({
    state,
    onRequestShortLeave,
}: ShortLeaveViewProps) {
    if (state.status === 'loading') {
        return <ShortLeaveLoading />;
    }

    if (state.status === 'error') {
        return (
            <Alert variant="destructive">
                <CircleAlert aria-hidden="true" />
                <AlertTitle>Short Leave information is unavailable</AlertTitle>
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
