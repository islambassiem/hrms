import { CalendarDays, FileText, Paperclip, ShieldCheck } from 'lucide-react';
import type { RefObject } from 'react';
import { Button } from '@/components/ui/button';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import type {
    ApprovalTimelineStep,
    RegularLeaveRequest,
    StatusTone,
} from '@/types/leave';
import { StatusBadge } from './status-badge';

type LeaveDetailDrawerProps = {
    request: RegularLeaveRequest | null;
    open: boolean;
    onOpenChange: (open: boolean) => void;
    returnFocusTarget?: RefObject<HTMLElement | null>;
};

const timelineTone: Record<ApprovalTimelineStep['status'], StatusTone> = {
    completed: 'success',
    in_progress: 'warning',
    pending: 'muted',
    rejected: 'destructive',
};

const timelineLabel: Record<ApprovalTimelineStep['status'], string> = {
    completed: 'Completed',
    in_progress: 'In progress',
    pending: 'Pending',
    rejected: 'Rejected',
};

export function LeaveDetailDrawer({
    request,
    open,
    onOpenChange,
    returnFocusTarget,
}: LeaveDetailDrawerProps) {
    if (!request) {
        return null;
    }

    return (
        <Sheet open={open} onOpenChange={onOpenChange}>
            <SheetContent
                className="w-full gap-0 overflow-y-auto p-0 sm:max-w-xl"
                onCloseAutoFocus={(event) => {
                    if (returnFocusTarget?.current) {
                        event.preventDefault();
                        returnFocusTarget.current.focus();
                    }
                }}
            >
                <SheetHeader className="border-b p-6 pr-12">
                    <div className="flex flex-wrap items-center gap-2">
                        <SheetTitle>{request.leaveTypeName}</SheetTitle>
                        <StatusBadge tone={request.statusTone}>
                            {request.statusLabel}
                        </StatusBadge>
                    </div>
                    <SheetDescription>
                        Request submitted on {request.appliedAt}.
                    </SheetDescription>
                </SheetHeader>

                <div className="space-y-6 p-6">
                    <section aria-labelledby="leave-request-details-heading">
                        <div className="mb-3 flex items-center gap-2">
                            <CalendarDays
                                className="text-muted-foreground size-4"
                                aria-hidden="true"
                            />
                            <h2
                                id="leave-request-details-heading"
                                className="font-medium"
                            >
                                Request details
                            </h2>
                        </div>
                        <dl className="grid gap-4 text-sm sm:grid-cols-2">
                            <div>
                                <dt className="text-muted-foreground">From</dt>
                                <dd className="font-medium">
                                    {request.startDate}
                                </dd>
                            </div>
                            <div>
                                <dt className="text-muted-foreground">To</dt>
                                <dd className="font-medium">
                                    {request.endDate}
                                </dd>
                            </div>
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
                                    Current stage
                                </dt>
                                <dd className="font-medium">
                                    {request.currentStage ?? 'Not available'}
                                </dd>
                            </div>
                        </dl>
                        {request.reason && (
                            <div className="bg-muted/50 mt-4 rounded-md p-3 text-sm">
                                <p className="text-muted-foreground mb-1">
                                    Reason or notes
                                </p>
                                <p>{request.reason}</p>
                            </div>
                        )}
                    </section>

                    <section aria-labelledby="leave-attachments-heading">
                        <div className="mb-3 flex items-center gap-2">
                            <Paperclip
                                className="text-muted-foreground size-4"
                                aria-hidden="true"
                            />
                            <h2
                                id="leave-attachments-heading"
                                className="font-medium"
                            >
                                Attachments
                            </h2>
                        </div>
                        {request.attachments.length > 0 ? (
                            <ul className="space-y-2" role="list">
                                {request.attachments.map((attachment) => (
                                    <li
                                        key={attachment.id}
                                        className="border-border/60 flex flex-wrap items-center justify-between gap-2 rounded-md border p-3"
                                    >
                                        <div className="min-w-0">
                                            <p className="truncate text-sm font-medium">
                                                {attachment.name}
                                            </p>
                                            {attachment.sizeLabel && (
                                                <p className="text-muted-foreground text-sm">
                                                    {attachment.sizeLabel}
                                                </p>
                                            )}
                                        </div>
                                        <Button
                                            type="button"
                                            size="sm"
                                            variant="outline"
                                            disabled={
                                                !attachment.downloadAvailable
                                            }
                                        >
                                            View attachment
                                        </Button>
                                    </li>
                                ))}
                            </ul>
                        ) : (
                            <p className="text-muted-foreground text-sm">
                                No attachments are available for this request.
                            </p>
                        )}
                    </section>

                    <section aria-labelledby="leave-approval-timeline-heading">
                        <div className="mb-3 flex items-center gap-2">
                            <ShieldCheck
                                className="text-muted-foreground size-4"
                                aria-hidden="true"
                            />
                            <h2
                                id="leave-approval-timeline-heading"
                                className="font-medium"
                            >
                                Approval timeline
                            </h2>
                        </div>
                        {request.approvalTimeline.length > 0 ? (
                            <ol className="border-border space-y-4 border-l pl-4">
                                {request.approvalTimeline.map((step) => (
                                    <li
                                        key={step.id}
                                        className="relative space-y-1"
                                    >
                                        <span className="bg-border absolute top-1 -left-5 size-2 rounded-full" />
                                        <div className="flex flex-wrap items-center gap-2">
                                            <p className="font-medium">
                                                {step.stageName}
                                            </p>
                                            <StatusBadge
                                                tone={timelineTone[step.status]}
                                            >
                                                {timelineLabel[step.status]}
                                            </StatusBadge>
                                        </div>
                                        {(step.approverName ||
                                            step.approverRole) && (
                                            <p className="text-muted-foreground text-sm">
                                                {[
                                                    step.approverName,
                                                    step.approverRole,
                                                ]
                                                    .filter(Boolean)
                                                    .join(' · ')}
                                            </p>
                                        )}
                                        {step.occurredAt && (
                                            <p className="text-muted-foreground text-sm">
                                                {step.occurredAt}
                                            </p>
                                        )}
                                        {step.comment && (
                                            <p className="text-muted-foreground text-sm">
                                                {step.comment}
                                            </p>
                                        )}
                                    </li>
                                ))}
                            </ol>
                        ) : (
                            <p className="text-muted-foreground text-sm">
                                An approval timeline is not available for this
                                request.
                            </p>
                        )}
                    </section>
                </div>

                {request.canCancel && (
                    <SheetFooter className="border-t p-6">
                        <Button type="button" variant="outline" disabled>
                            <FileText className="size-4" aria-hidden="true" />
                            Cancel or withdraw unavailable
                        </Button>
                        <p className="text-muted-foreground text-sm">
                            Cancellation will be enabled when the authorized
                            server action is connected.
                        </p>
                    </SheetFooter>
                )}
            </SheetContent>
        </Sheet>
    );
}
