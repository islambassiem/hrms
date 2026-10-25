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
import { store, update } from '@/routes/family-visits';
import type { EmployeeFamilyVisitRequest } from '@/types';

type FamilyVisitRequestFormSheetProps = {
    onOpenChange: (open: boolean) => void;
    open: boolean;
    visit: EmployeeFamilyVisitRequest | null;
};

type FamilyVisitRequestFormData = {
    number: string;
};

export function FamilyVisitRequestFormSheet({
    onOpenChange,
    open,
    visit,
}: FamilyVisitRequestFormSheetProps) {
    const { t, i18n } = useTranslation();
    const isEditing = visit !== null;
    const form = useForm<FamilyVisitRequestFormData>({
        number: visit?.number ?? '',
    });

    const submit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const options = {
            preserveScroll: true,
            onSuccess: () => onOpenChange(false),
        };

        if (visit) {
            form.put(update(visit).url, options);

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
                            ? t('Edit family visit request')
                            : t('New family visit request')}
                    </SheetTitle>
                    <SheetDescription>
                        {isEditing
                            ? t('Update your pending family visit request.')
                            : t(
                                  'Add the number for your family visit request.',
                              )}
                    </SheetDescription>
                </SheetHeader>

                <form
                    id="family-visit-request-form"
                    className="flex flex-1 flex-col gap-5 px-4 pb-4"
                    onSubmit={submit}
                >
                    <div className="space-y-2">
                        <Label htmlFor="family-visit-request-number">
                            {t('Request number')}
                        </Label>
                        <Input
                            id="family-visit-request-number"
                            value={form.data.number}
                            aria-invalid={Boolean(form.errors.number)}
                            onChange={(event) =>
                                form.setData('number', event.target.value)
                            }
                            autoFocus
                        />
                        <InputError message={form.errors.number} />
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
                        form="family-visit-request-form"
                        disabled={form.processing}
                    >
                        {form.processing
                            ? t('Saving family visit request')
                            : isEditing
                              ? t('Save changes')
                              : t('Submit family visit request')}
                    </Button>
                </SheetFooter>
            </SheetContent>
        </Sheet>
    );
}
