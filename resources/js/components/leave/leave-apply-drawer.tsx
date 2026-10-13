import { useForm } from '@inertiajs/react';
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
import { store } from '@/routes/leave';
import type { LeaveTypeEligibility, LeaveTypeOption } from '@/types';

import { formatLeaveNumber } from './leave-formatters';

type LeaveApplyDrawerProps = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    leaveTypes: LeaveTypeOption[];
    isLoading?: boolean;
    errorMessage?: string;
};

type FormFeedback = { kind: 'validation'; message: string } | null;

type LeaveRequestForm = {
    leave_type_id: string;
    start_date: string;
    end_date: string;
    reason: string;
    attachments: File | null;
};

function EligibilitySummary({
    eligibility,
}: {
    eligibility: LeaveTypeEligibility | undefined;
}) {
    const { t, i18n } = useTranslation();

    if (!eligibility) {
        return (
            <p className="text-muted-foreground text-sm">
                {t(
                    'Eligibility information will be available when the leave policy is supplied.',
                )}
            </p>
        );
    }

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
    const [feedback, setFeedback] = useState<FormFeedback>(null);
    const [submissionMessage, setSubmissionMessage] = useState<string | null>(
        null,
    );
    const form = useForm<LeaveRequestForm>({
        leave_type_id: '',
        start_date: '',
        end_date: '',
        reason: '',
        attachments: null,
    });

    const selectedLeaveType = leaveTypes.find(
        (leaveType) => leaveType.id === Number(form.data.leave_type_id),
    );

    const resetFeedback = () => {
        setFeedback(null);
        setSubmissionMessage(null);
        form.clearErrors();
    };

    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (
            !selectedLeaveType ||
            !form.data.start_date ||
            !form.data.end_date
        ) {
            setFeedback({
                kind: 'validation',
                message: t(
                    'Select a leave type, start date, and end date before continuing.',
                ),
            });
            return;
        }

        if (form.data.end_date < form.data.start_date) {
            setFeedback({
                kind: 'validation',
                message: t('The end date must be on or after the start date.'),
            });
            return;
        }

        resetFeedback();
        form.post(store().url, {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                setSubmissionMessage(t('Leave request submitted.'));
            },
        });
    };

    const handleOpenChange = (nextOpen: boolean) => {
        if (!nextOpen) {
            resetFeedback();
        }

        onOpenChange(nextOpen);
    };

    return (
        <Sheet open={open} onOpenChange={handleOpenChange}>
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
                            {feedback || form.hasErrors ? (
                                <Alert variant="destructive">
                                    <CircleAlert aria-hidden="true" />
                                    <AlertTitle>
                                        {t('Check the form')}
                                    </AlertTitle>
                                    <AlertDescription>
                                        {feedback?.message ??
                                            Object.values(form.errors)[0]}
                                    </AlertDescription>
                                </Alert>
                            ) : null}

                            {submissionMessage ? (
                                <Alert>
                                    <AlertTitle>
                                        {t('Leave request submitted')}
                                    </AlertTitle>
                                    <AlertDescription>
                                        {submissionMessage}
                                    </AlertDescription>
                                </Alert>
                            ) : null}

                            <div className="space-y-2">
                                <Label htmlFor="leave-apply-type">
                                    {t('Leave type')}
                                </Label>
                                <Select
                                    value={form.data.leave_type_id}
                                    onValueChange={(value) => {
                                        form.setData('leave_type_id', value);
                                        resetFeedback();
                                    }}
                                >
                                    <SelectTrigger
                                        id="leave-apply-type"
                                        aria-invalid={
                                            Boolean(
                                                form.errors.leave_type_id,
                                            ) ||
                                            (feedback?.kind === 'validation' &&
                                                !selectedLeaveType)
                                        }
                                        className="w-full"
                                    >
                                        <SelectValue
                                            placeholder={t(
                                                'Select a leave type',
                                            )}
                                        />
                                    </SelectTrigger>
                                    <SelectContent dir={i18n.dir()}>
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
                                        dir={i18n.dir()}
                                        lang={i18n.language}
                                        value={form.data.start_date}
                                        aria-invalid={
                                            Boolean(form.errors.start_date) ||
                                            (feedback?.kind === 'validation' &&
                                                !form.data.start_date)
                                        }
                                        onChange={(event) => {
                                            form.setData(
                                                'start_date',
                                                event.target.value,
                                            );
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
                                        dir={i18n.dir()}
                                        lang={i18n.language}
                                        value={form.data.end_date}
                                        aria-invalid={
                                            Boolean(form.errors.end_date) ||
                                            (feedback?.kind === 'validation' &&
                                                (!form.data.end_date ||
                                                    form.data.end_date <
                                                        form.data.start_date))
                                        }
                                        onChange={(event) => {
                                            form.setData(
                                                'end_date',
                                                event.target.value,
                                            );
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
                                    value={form.data.reason}
                                    aria-invalid={Boolean(form.errors.reason)}
                                    onChange={(event) => {
                                        form.setData(
                                            'reason',
                                            event.target.value,
                                        );
                                        resetFeedback();
                                    }}
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
                                        <p className="text-muted-foreground text-sm">
                                            {t(
                                                'Attachment requirements are enforced by the server.',
                                            )}
                                        </p>
                                        <p className="text-muted-foreground text-sm">
                                            {t(
                                                'Accepted files: PDF, PNG, JPEG, or JPG up to 3 MB.',
                                            )}
                                        </p>
                                    </div>
                                </div>
                                <div className="mt-4 space-y-2">
                                    <Label htmlFor="leave-apply-attachment">
                                        {t('Select attachment')}
                                    </Label>
                                    <Input
                                        id="leave-apply-attachment"
                                        type="file"
                                        accept=".pdf,.png,.jpeg,.jpg"
                                        aria-invalid={Boolean(
                                            form.errors.attachments,
                                        )}
                                        onChange={(event) => {
                                            form.setData(
                                                'attachments',
                                                event.target.files?.[0] ?? null,
                                            );
                                            resetFeedback();
                                        }}
                                    />
                                    {form.errors.attachments ? (
                                        <p className="text-destructive text-sm">
                                            {form.errors.attachments}
                                        </p>
                                    ) : null}
                                </div>
                            </section>
                        </div>

                        <SheetFooter className="border-t p-6">
                            <Button type="submit" disabled={form.processing}>
                                {form.processing
                                    ? t('Submitting Leave request')
                                    : t('Submit Leave request')}
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
