import { CalendarDays, FileText, Paperclip, ShieldCheck } from 'lucide-react';
import type { RefObject } from 'react';
import { useTranslation } from 'react-i18next';

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
    LeaveAttachment,
    RegularLeaveRequest,
    StatusTone,
} from '@/types';

import { formatLeaveDate } from './leave-formatters';
import { StatusBadge } from './status-badge';

type LeaveDetailDrawerProps = {
    request: RegularLeaveRequest | null;
    open: boolean;
    onOpenChange: (open: boolean) => void;
    returnFocusTarget?: RefObject<HTMLElement | null>;
    onCancelRequest?: (request: RegularLeaveRequest) => void;
    onViewAttachment?: (attachment: LeaveAttachment) => void;
};

const timelineTone: Record<ApprovalTimelineStep['status'], StatusTone> = {
    completed: 'success',
    in_progress: 'warning',
    pending: 'muted',
    rejected: 'destructive',
};

export function LeaveDetailDrawer({
    request,
    open,
    onOpenChange,
    returnFocusTarget,
    onCancelRequest,
    onViewAttachment,
}: LeaveDetailDrawerProps) {
    const { t, i18n } = useTranslation();

    if (!request) {
        return null;
    }

    const timelineStatusLabel = (status: ApprovalTimelineStep['status']) => {
        const labels: Record<ApprovalTimelineStep['status'], string> = {
            completed: t('Completed'),
            in_progress: t('In progress'),
            pending: t('Pending'),
            rejected: t('Rejected'),
        };

        return labels[status];
    };

    return (
        <Sheet open={open} onOpenChange={onOpenChange}>
            <SheetContent
                dir={i18n.dir()}
                className="w-full gap-0 overflow-y-auto p-0 sm:max-w-xl"
                onCloseAutoFocus={(event) => {
                    if (returnFocusTarget?.current) {
                        event.preventDefault();
                        returnFocusTarget.current.focus();
                    }
                }}
            >
                <SheetHeader className="border-b p-6 pe-12">
                    <div className="flex flex-wrap items-center gap-2">
                        <SheetTitle>{request.leaveTypeName}</SheetTitle>
                        <StatusBadge tone={request.statusTone}>
                            {request.statusLabel}
                        </StatusBadge>
                    </div>
                    <SheetDescription>
                        {t('Leave request submitted on', {
                            date: formatLeaveDate(
                                request.appliedAt,
                                i18n.language,
                            ),
                        })}
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
                                {t('Request details')}
                            </h2>
                        </div>
                        <dl className="grid gap-4 text-sm sm:grid-cols-2">
                            <Detail
                                label={t('From')}
                                value={formatLeaveDate(
                                    request.startDate,
                                    i18n.language,
                                )}
                            />
                            <Detail
                                label={t('To')}
                                value={formatLeaveDate(
                                    request.endDate,
                                    i18n.language,
                                )}
                            />
                            <Detail
                                label={t('Duration')}
                                value={request.durationLabel}
                            />
                            <Detail
                                label={t('Current stage')}
                                value={
                                    request.currentStage ?? t('Not available')
                                }
                            />
                        </dl>
                        {request.reason ? (
                            <div className="bg-muted/50 mt-4 rounded-md p-3 text-sm">
                                <p className="text-muted-foreground mb-1">
                                    {t('Reason or notes')}
                                </p>
                                <p>{request.reason}</p>
                            </div>
                        ) : null}
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
                                {t('Attachments')}
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
                                            {attachment.sizeLabel ? (
                                                <p className="text-muted-foreground text-sm">
                                                    {attachment.sizeLabel}
                                                </p>
                                            ) : null}
                                        </div>
                                        <Button
                                            type="button"
                                            size="sm"
                                            variant="outline"
                                            disabled={
                                                !attachment.downloadAvailable ||
                                                !onViewAttachment
                                            }
                                            onClick={() =>
                                                onViewAttachment?.(attachment)
                                            }
                                        >
                                            {t('View attachment')}
                                        </Button>
                                    </li>
                                ))}
                            </ul>
                        ) : (
                            <p className="text-muted-foreground text-sm">
                                {t(
                                    'No attachments are available for this request.',
                                )}
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
                                {t('Approval timeline')}
                            </h2>
                        </div>
                        {request.approvalTimeline.length > 0 ? (
                            <ol className="border-border space-y-4 border-s ps-4">
                                {request.approvalTimeline.map((step) => (
                                    <li
                                        key={step.id}
                                        className="relative space-y-1"
                                    >
                                        <span className="bg-border absolute -start-5 top-1 size-2 rounded-full" />
                                        <div className="flex flex-wrap items-center gap-2">
                                            <p className="font-medium">
                                                {step.stageName}
                                            </p>
                                            <StatusBadge
                                                tone={timelineTone[step.status]}
                                            >
                                                {timelineStatusLabel(
                                                    step.status,
                                                )}
                                            </StatusBadge>
                                        </div>
                                        {step.approverName ||
                                        step.approverRole ? (
                                            <p className="text-muted-foreground text-sm">
                                                {[
                                                    step.approverName,
                                                    step.approverRole,
                                                ]
                                                    .filter(Boolean)
                                                    .join(' · ')}
                                            </p>
                                        ) : null}
                                        {step.occurredAt ? (
                                            <p className="text-muted-foreground text-sm">
                                                {formatLeaveDate(
                                                    step.occurredAt,
                                                    i18n.language,
                                                )}
                                            </p>
                                        ) : null}
                                        {step.comment ? (
                                            <p className="text-muted-foreground text-sm">
                                                {step.comment}
                                            </p>
                                        ) : null}
                                    </li>
                                ))}
                            </ol>
                        ) : (
                            <p className="text-muted-foreground text-sm">
                                {t(
                                    'An approval timeline is not available for this request.',
                                )}
                            </p>
                        )}
                    </section>
                </div>

                {request.canCancel ? (
                    <SheetFooter className="border-t p-6">
                        <Button
                            type="button"
                            variant="outline"
                            disabled={!onCancelRequest}
                            onClick={() => onCancelRequest?.(request)}
                        >
                            <FileText className="size-4" aria-hidden="true" />
                            {t('Cancel or withdraw')}
                        </Button>
                        {!onCancelRequest ? (
                            <p className="text-muted-foreground text-sm">
                                {t(
                                    'Cancellation will be enabled when the authorized server action is connected.',
                                )}
                            </p>
                        ) : null}
                    </SheetFooter>
                ) : null}
            </SheetContent>
        </Sheet>
    );
}

function Detail({ label, value }: { label: string; value: string | null }) {
    return (
        <div>
            <dt className="text-muted-foreground">{label}</dt>
            <dd className="font-medium">{value}</dd>
        </div>
    );
}
