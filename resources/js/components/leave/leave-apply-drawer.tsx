import { CalendarDays, CircleAlert, Info, Paperclip } from 'lucide-react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import { useTranslation } from 'react-i18next';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
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
import {
    Sheet,
    SheetContent,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { Skeleton } from '@/components/ui/skeleton';
import type { LeaveTypeEligibility, LeaveTypeOption } from '@/types';

import { formatLeaveNumber } from './leave-formatters';

type LeaveApplyDrawerProps = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    leaveTypes: LeaveTypeOption[];
    isLoading?: boolean;
    errorMessage?: string;
};

type FormFeedback =
    | { kind: 'validation'; message: string }
    | { kind: 'unavailable'; message: string }
    | null;

function EligibilitySummary({
    eligibility,
}: {
    eligibility: LeaveTypeEligibility;
}) {
    const { t, i18n } = useTranslation();

    if (eligibility.kind === 'annual-balance') {
        return (
            <dl className="grid grid-cols-2 gap-3 text-sm sm:grid-cols-4">
                <Metric
                    label={t('Available')}
                    value={t('Leave days', {
                        days: formatLeaveNumber(
                            eligibility.availableDays,
                            i18n.language,
                        ),
                    })}
                />
                <Metric
                    label={t('Total')}
                    value={t('Leave days', {
                        days: formatLeaveNumber(
                            eligibility.entitlementDays,
                            i18n.language,
                        ),
                    })}
                />
                <Metric
                    label={t('Used')}
                    value={t('Leave days', {
                        days: formatLeaveNumber(
                            eligibility.usedDays,
                            i18n.language,
                        ),
                    })}
                />
                <Metric
                    label={t('Pending')}
                    value={t('Leave days', {
                        days: formatLeaveNumber(
                            eligibility.pendingDays,
                            i18n.language,
                        ),
                    })}
                />
            </dl>
        );
    }

    if (eligibility.kind === 'sick-tier') {
        return (
            <div className="space-y-1 text-sm">
                <p className="font-medium">{eligibility.currentTierLabel}</p>
                <p className="text-muted-foreground">
                    {t('Sick Leave days used', {
                        days: formatLeaveNumber(
                            eligibility.usedDays,
                            i18n.language,
                        ),
                    })}
                </p>
                {eligibility.nextTierNote ? (
                    <p className="text-muted-foreground">
                        {eligibility.nextTierNote}
                    </p>
                ) : null}
            </div>
        );
    }

    return (
        <p className="text-muted-foreground text-sm">
            {eligibility.message ??
                t(
                    'Eligibility information will be available when the leave policy is supplied.',
                )}
        </p>
    );
}

function ApplyDrawerLoading() {
    const { t } = useTranslation();

    return (
        <div
            role="status"
            aria-label={t('Loading Leave form')}
            className="space-y-5 p-6"
        >
            <Skeleton className="h-5 w-32" />
            <Skeleton className="h-9 w-full" />
            <div className="grid gap-4 sm:grid-cols-2">
                <Skeleton className="h-9 w-full" />
                <Skeleton className="h-9 w-full" />
            </div>
            <Skeleton className="h-24 w-full" />
        </div>
    );
}

export function LeaveApplyDrawer({
    open,
    onOpenChange,
    leaveTypes,
    isLoading = false,
    errorMessage,
}: LeaveApplyDrawerProps) {
    const { t, i18n } = useTranslation();
    const [leaveTypeId, setLeaveTypeId] = useState('');
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [reason, setReason] = useState('');
    const [feedback, setFeedback] = useState<FormFeedback>(null);

    const selectedLeaveType = leaveTypes.find(
        (leaveType) => leaveType.id === Number(leaveTypeId),
    );

    const resetFeedback = () => setFeedback(null);

    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (!selectedLeaveType || !startDate || !endDate) {
            setFeedback({
                kind: 'validation',
                message: t(
                    'Select a leave type, start date, and end date before continuing.',
                ),
            });
            return;
        }

        if (endDate < startDate) {
            setFeedback({
                kind: 'validation',
                message: t('The end date must be on or after the start date.'),
            });
            return;
        }

        setFeedback({
            kind: 'unavailable',
            message: t(
                'Leave submission is not connected yet. No request or Leave data has been changed.',
            ),
        });
    };

    return (
        <Sheet open={open} onOpenChange={onOpenChange}>
            <SheetContent
                dir={i18n.dir()}
                className="w-full gap-0 overflow-y-auto p-0 sm:max-w-xl"
            >
                <SheetHeader className="border-b p-6 pe-12">
                    <SheetTitle>{t('Apply for Leave')}</SheetTitle>
                    <p className="text-muted-foreground text-sm">
                        {t(
                            'Leave policies, validation, attachments, and submission will be enforced by the connected server workflow.',
                        )}
                    </p>
                </SheetHeader>

                {isLoading ? (
                    <ApplyDrawerLoading />
                ) : errorMessage ? (
                    <div className="p-6">
                        <Alert variant="destructive">
                            <CircleAlert aria-hidden="true" />
                            <AlertTitle>
                                {t('Leave form is unavailable')}
                            </AlertTitle>
                            <AlertDescription>{errorMessage}</AlertDescription>
                        </Alert>
                    </div>
                ) : leaveTypes.length === 0 ? (
                    <div className="p-6">
                        <Alert>
                            <Info aria-hidden="true" />
                            <AlertTitle>
                                {t('No leave types are available')}
                            </AlertTitle>
                            <AlertDescription>
                                {t(
                                    'Eligible leave types will appear when they are supplied by the authorized Leave service.',
                                )}
                            </AlertDescription>
                        </Alert>
                    </div>
                ) : (
                    <form
                        onSubmit={handleSubmit}
                        className="flex min-h-full flex-col"
                    >
                        <div className="space-y-6 p-6">
                            {feedback ? (
                                <Alert
                                    variant={
                                        feedback.kind === 'validation'
                                            ? 'destructive'
                                            : 'default'
                                    }
                                >
                                    <CircleAlert aria-hidden="true" />
                                    <AlertTitle>
                                        {feedback.kind === 'validation'
                                            ? t('Check the form')
                                            : t('Submission unavailable')}
                                    </AlertTitle>
                                    <AlertDescription>
                                        {feedback.message}
                                    </AlertDescription>
                                </Alert>
                            ) : null}

                            <div className="space-y-2">
                                <Label htmlFor="leave-apply-type">
                                    {t('Leave type')}
                                </Label>
                                <Select
                                    value={leaveTypeId}
                                    onValueChange={(value) => {
                                        setLeaveTypeId(value);
                                        resetFeedback();
                                    }}
                                >
                                    <SelectTrigger
                                        id="leave-apply-type"
                                        aria-invalid={
                                            feedback?.kind === 'validation' &&
                                            !selectedLeaveType
                                        }
                                        className="w-full"
                                    >
                                        <SelectValue
                                            placeholder={t(
                                                'Select a leave type',
                                            )}
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
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
                                {selectedLeaveType?.description ? (
                                    <p className="text-muted-foreground text-sm">
                                        {selectedLeaveType.description}
                                    </p>
                                ) : null}
                            </div>

                            {selectedLeaveType ? (
                                <section
                                    aria-labelledby="leave-eligibility-heading"
                                    className="bg-muted/50 rounded-lg p-4"
                                >
                                    <div className="mb-3 flex items-center gap-2">
                                        <CalendarDays
                                            className="text-muted-foreground size-4"
                                            aria-hidden="true"
                                        />
                                        <h2
                                            id="leave-eligibility-heading"
                                            className="font-medium"
                                        >
                                            {t('Leave information')}
                                        </h2>
                                    </div>
                                    <EligibilitySummary
                                        eligibility={
                                            selectedLeaveType.eligibility
                                        }
                                    />
                                </section>
                            ) : null}

                            <div className="grid gap-4 sm:grid-cols-2">
                                <div className="space-y-2">
                                    <Label htmlFor="leave-apply-start-date">
                                        {t('Start date')}
                                    </Label>
                                    <Input
                                        id="leave-apply-start-date"
                                        type="date"
                                        value={startDate}
                                        aria-invalid={
                                            feedback?.kind === 'validation' &&
                                            !startDate
                                        }
                                        onChange={(event) => {
                                            setStartDate(event.target.value);
                                            resetFeedback();
                                        }}
                                    />
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="leave-apply-end-date">
                                        {t('End date')}
                                    </Label>
                                    <Input
                                        id="leave-apply-end-date"
                                        type="date"
                                        value={endDate}
                                        aria-invalid={
                                            feedback?.kind === 'validation' &&
                                            (!endDate || endDate < startDate)
                                        }
                                        onChange={(event) => {
                                            setEndDate(event.target.value);
                                            resetFeedback();
                                        }}
                                    />
                                </div>
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="leave-apply-reason">
                                    {t('Reason or notes')}
                                </Label>
                                <textarea
                                    id="leave-apply-reason"
                                    value={reason}
                                    onChange={(event) =>
                                        setReason(event.target.value)
                                    }
                                    className="border-input placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring min-h-28 w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:ring-2"
                                    placeholder={t(
                                        'Add any information relevant to your request',
                                    )}
                                />
                            </div>

                            <section
                                aria-labelledby="leave-attachment-heading"
                                className="border-border/60 rounded-lg border p-4"
                            >
                                <div className="flex items-start gap-3">
                                    <Paperclip
                                        className="text-muted-foreground mt-0.5 size-4"
                                        aria-hidden="true"
                                    />
                                    <div className="space-y-1">
                                        <h2
                                            id="leave-attachment-heading"
                                            className="font-medium"
                                        >
                                            {t('Attachment')}
                                        </h2>
                                        {selectedLeaveType?.attachmentLabel ? (
                                            <p className="text-muted-foreground text-sm">
                                                {
                                                    selectedLeaveType.attachmentLabel
                                                }
                                            </p>
                                        ) : (
                                            <p className="text-muted-foreground text-sm">
                                                {t(
                                                    'Attachment requirements are not available for this leave type.',
                                                )}
                                            </p>
                                        )}
                                        <p className="text-muted-foreground text-sm">
                                            {t(
                                                'Upload will be available when the secure server attachment flow is connected.',
                                            )}
                                        </p>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <SheetFooter className="border-t p-6">
                            <Button type="submit">
                                {t('Continue to submission')}
                            </Button>
                        </SheetFooter>
                    </form>
                )}
            </SheetContent>
        </Sheet>
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
