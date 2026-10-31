import { useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
import { useTranslation } from 'react-i18next';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { store, update } from '@/routes/visas';
import type { EmployeeVisaRequest } from '@/types';

type VisaRequestFormSheetProps = {
    onOpenChange: (open: boolean) => void;
    open: boolean;
    visa: EmployeeVisaRequest | null;
};

type VisaRequestFormData = {
    end_date: string;
    for_year: string;
    start_date: string;
};

export function VisaRequestFormSheet({
    onOpenChange,
    open,
    visa,
}: VisaRequestFormSheetProps) {
    const { i18n, t } = useTranslation();
    const isEditing = visa !== null;
    const form = useForm<VisaRequestFormData>({
        end_date: visa?.end_date ?? '',
        for_year: visa ? String(visa.for_year) : '',
        start_date: visa?.start_date ?? '',
    });

    const submit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const options = {
            preserveScroll: true,
            onSuccess: () => onOpenChange(false),
        };

        if (visa) {
            form.put(update(visa).url, options);

            return;
        }

        form.post(store().url, options);
    };

    return (
        <Sheet open={open} onOpenChange={onOpenChange}>
            <SheetContent
                dir={i18n.dir()}
                side={i18n.dir() === 'rtl' ? 'left' : 'right'}
                className="w-full overflow-y-auto sm:max-w-xl"
            >
                <SheetHeader>
                    <SheetTitle>
                        {isEditing
                            ? t('Edit visa request')
                            : t('New visa request')}
                    </SheetTitle>
                    <SheetDescription>
                        {isEditing
                            ? t('Update your pending visa request.')
                            : t(
                                  'Add the dates and request year for your visa request.',
                              )}
                    </SheetDescription>
                </SheetHeader>

                <form
                    id="visa-request-form"
                    className="flex flex-1 flex-col gap-5 px-4 pb-4"
                    onSubmit={submit}
                >
                    <div className="space-y-2">
                        <Label htmlFor="visa-request-start-date">
                            {t('Start date')}
                        </Label>
                        <Input
                            id="visa-request-start-date"
                            type="date"
                            lang={i18n.language === 'ar' ? 'ar-SA' : 'en'}
                            value={form.data.start_date}
                            aria-invalid={Boolean(form.errors.start_date)}
                            onChange={(event) =>
                                form.setData('start_date', event.target.value)
                            }
                            autoFocus
                        />
                        <InputError message={form.errors.start_date} />
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="visa-request-end-date">
                            {t('End date')}
                        </Label>
                        <Input
                            id="visa-request-end-date"
                            type="date"
                            lang={i18n.language === 'ar' ? 'ar-SA' : 'en'}
                            value={form.data.end_date}
                            aria-invalid={Boolean(form.errors.end_date)}
                            onChange={(event) =>
                                form.setData('end_date', event.target.value)
                            }
                        />
                        <InputError message={form.errors.end_date} />
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="visa-request-year">
                            {t('Visa year')}
                        </Label>
                        <Input
                            id="visa-request-year"
                            type="number"
                            step="1"
                            value={form.data.for_year}
                            aria-invalid={Boolean(form.errors.for_year)}
                            onChange={(event) =>
                                form.setData('for_year', event.target.value)
                            }
                        />
                        <InputError message={form.errors.for_year} />
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
                        form="visa-request-form"
                        disabled={form.processing}
                    >
                        {form.processing
                            ? t('Saving visa request')
                            : isEditing
                              ? t('Save changes')
                              : t('Submit visa request')}
                    </Button>
                </SheetFooter>
            </SheetContent>
        </Sheet>
    );
}
