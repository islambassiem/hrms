import { useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import { useTranslation } from 'react-i18next';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
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
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { store, update } from '@/routes/short-leaves';
import type { EmployeeShortLeaveRequest, ShortLeaveTypeOption } from '@/types';

type ShortLeaveRequestFormSheetProps = {
    onOpenChange: (open: boolean) => void;
    open: boolean;
    shortLeave: EmployeeShortLeaveRequest | null;
    shortLeaveTypes: ShortLeaveTypeOption[];
};

type ShortLeaveRequestFormData = {
    short_leave_date: string;
    short_leave_from: string;
    short_leave_to: string;
    short_leave_type_id: string;
};

export function ShortLeaveRequestFormSheet({
    onOpenChange,
    open,
    shortLeave,
    shortLeaveTypes,
}: ShortLeaveRequestFormSheetProps) {
    const { i18n, t } = useTranslation();
    const [isConfirmationOpen, setIsConfirmationOpen] = useState(false);
    const isEditing = shortLeave !== null;
    const form = useForm<ShortLeaveRequestFormData>({
        short_leave_date: shortLeave?.shortLeaveDate ?? '',
        short_leave_from: shortLeave?.shortLeaveFrom ?? '',
        short_leave_to: shortLeave?.shortLeaveTo ?? '',
        short_leave_type_id: shortLeave
            ? String(shortLeave.shortLeaveType.id)
            : '',
    });

    const requestConfirmation = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        setIsConfirmationOpen(true);
    };

    const submit = () => {
        const options = {
            preserveScroll: true,
            onError: () => setIsConfirmationOpen(false),
            onSuccess: () => {
                setIsConfirmationOpen(false);
                onOpenChange(false);
            },
        };

        if (shortLeave) {
            form.put(update(shortLeave).url, options);

            return;
        }

        form.post(store().url, options);
    };

    return (
        <>
            <Sheet open={open} onOpenChange={onOpenChange}>
                <SheetContent
                    dir={i18n.dir()}
                    side={i18n.dir() === 'rtl' ? 'left' : 'right'}
                    className="w-full overflow-y-auto sm:max-w-xl"
                >
                    <SheetHeader>
                        <SheetTitle>
                            {isEditing
                                ? t('Edit Short Leave request')
                                : t('New Short Leave request')}
                        </SheetTitle>
                        <SheetDescription>
                            {isEditing
                                ? t('Update your pending Short Leave request.')
                                : t(
                                      'Choose the Short Leave type, date, and time.',
                                  )}
                        </SheetDescription>
                    </SheetHeader>

                    <form
                        id="short-leave-request-form"
                        className="flex flex-1 flex-col gap-5 px-4 pb-4"
                        onSubmit={requestConfirmation}
                    >
                        <div className="space-y-2">
                            <Label htmlFor="short-leave-request-type">
                                {t('Short Leave type')}
                            </Label>
                            <Select
                                value={form.data.short_leave_type_id}
                                onValueChange={(value) =>
                                    form.setData('short_leave_type_id', value)
                                }
                            >
                                <SelectTrigger
                                    id="short-leave-request-type"
                                    aria-invalid={Boolean(
                                        form.errors.short_leave_type_id,
                                    )}
                                >
                                    <SelectValue
                                        placeholder={t(
                                            'Select a Short Leave type',
                                        )}
                                    />
                                </SelectTrigger>
                                <SelectContent dir={i18n.dir()}>
                                    {shortLeaveTypes.map((shortLeaveType) => (
                                        <SelectItem
                                            key={shortLeaveType.id}
                                            value={String(shortLeaveType.id)}
                                        >
                                            {shortLeaveType.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <InputError
                                message={form.errors.short_leave_type_id}
                            />
                        </div>

                        <div className="space-y-2">
                            <Label htmlFor="short-leave-request-date">
                                {t('Date')}
                            </Label>
                            <Input
                                id="short-leave-request-date"
                                type="date"
                                dir={i18n.dir()}
                                lang={i18n.language === 'ar' ? 'ar-SA' : 'en'}
                                value={form.data.short_leave_date}
                                aria-invalid={Boolean(
                                    form.errors.short_leave_date,
                                )}
                                onChange={(event) =>
                                    form.setData(
                                        'short_leave_date',
                                        event.target.value,
                                    )
                                }
                                autoFocus
                            />
                            <InputError
                                message={form.errors.short_leave_date}
                            />
                        </div>

                        <div className="grid gap-5 sm:grid-cols-2">
                            <div className="space-y-2">
                                <Label htmlFor="short-leave-request-from">
                                    {t('Start time')}
                                </Label>
                                <Input
                                    id="short-leave-request-from"
                                    type="time"
                                    dir={i18n.dir()}
                                    lang={
                                        i18n.language === 'ar' ? 'ar-SA' : 'en'
                                    }
                                    value={form.data.short_leave_from}
                                    aria-invalid={Boolean(
                                        form.errors.short_leave_from,
                                    )}
                                    onChange={(event) =>
                                        form.setData(
                                            'short_leave_from',
                                            event.target.value,
                                        )
                                    }
                                />
                                <InputError
                                    message={form.errors.short_leave_from}
                                />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="short-leave-request-to">
                                    {t('End time')}
                                </Label>
                                <Input
                                    id="short-leave-request-to"
                                    type="time"
                                    dir={i18n.dir()}
                                    lang={
                                        i18n.language === 'ar' ? 'ar-SA' : 'en'
                                    }
                                    value={form.data.short_leave_to}
                                    aria-invalid={Boolean(
                                        form.errors.short_leave_to,
                                    )}
                                    onChange={(event) =>
                                        form.setData(
                                            'short_leave_to',
                                            event.target.value,
                                        )
                                    }
                                />
                                <InputError
                                    message={form.errors.short_leave_to}
                                />
                            </div>
                        </div>
                    </form>

                    <SheetFooter>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => onOpenChange(false)}
                        >
                            {t('Cancel')}
                        </Button>
                        <Button
                            type="submit"
                            form="short-leave-request-form"
                            disabled={form.processing}
                        >
                            {isEditing
                                ? t('Save changes')
                                : t('Submit Short Leave request')}
                        </Button>
                    </SheetFooter>
                </SheetContent>
            </Sheet>

            <Dialog
                open={isConfirmationOpen}
                onOpenChange={setIsConfirmationOpen}
            >
                <DialogContent dir={i18n.dir()}>
                    <DialogHeader>
                        <DialogTitle>
                            {isEditing
                                ? t('Save Short Leave changes?')
                                : t('Submit Short Leave request?')}
                        </DialogTitle>
                        <DialogDescription>
                            {isEditing
                                ? t(
                                      'Your pending Short Leave request will be updated with these details.',
                                  )
                                : t(
                                      'Your Short Leave request will be submitted for review.',
                                  )}
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => setIsConfirmationOpen(false)}
                        >
                            {t('Cancel')}
                        </Button>
                        <Button
                            type="button"
                            onClick={submit}
                            disabled={form.processing}
                        >
                            {isEditing
                                ? t('Save changes')
                                : t('Submit request')}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </>
    );
}
