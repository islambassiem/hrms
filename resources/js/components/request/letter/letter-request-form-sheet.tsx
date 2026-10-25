import { useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
import { useTranslation } from 'react-i18next';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
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
import { store, update } from '@/routes/letters';
import type { EmployeeLetterRequest } from '@/types';

type LetterRequestFormSheetProps = {
    letter: EmployeeLetterRequest | null;
    onOpenChange: (open: boolean) => void;
    open: boolean;
};

type LetterRequestFormData = {
    attested: boolean;
    description: string;
    include_salary: boolean;
    notes: string;
    title: string;
};

export function LetterRequestFormSheet({
    letter,
    onOpenChange,
    open,
}: LetterRequestFormSheetProps) {
    const { t, i18n } = useTranslation();
    const isEditing = letter !== null;
    const form = useForm<LetterRequestFormData>(
        letter ? formDataFromLetter(letter) : emptyFormData,
    );

    const submit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const options = {
            preserveScroll: true,
            onSuccess: () => onOpenChange(false),
        };

        if (letter) {
            form.put(update(letter).url, options);

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
                            ? t('Edit letter request')
                            : t('New letter request')}
                    </SheetTitle>
                    <SheetDescription>
                        {isEditing
                            ? t('Update a pending letter request.')
                            : t(
                                  'Add the information needed for your letter request.',
                              )}
                    </SheetDescription>
                </SheetHeader>

                <form
                    id="letter-request-form"
                    className="flex flex-1 flex-col gap-5 px-4 pb-4"
                    onSubmit={submit}
                >
                    <div className="space-y-2">
                        <Label htmlFor="letter-request-title">
                            {t('Letter title')}
                        </Label>
                        <Input
                            id="letter-request-title"
                            value={form.data.title}
                            aria-invalid={Boolean(form.errors.title)}
                            onChange={(event) =>
                                form.setData('title', event.target.value)
                            }
                            autoFocus
                        />
                        <InputError message={form.errors.title} />
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="letter-request-description">
                            {t('Description')}
                        </Label>
                        <textarea
                            id="letter-request-description"
                            value={form.data.description}
                            aria-invalid={Boolean(form.errors.description)}
                            onChange={(event) =>
                                form.setData('description', event.target.value)
                            }
                            className="border-input placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring min-h-28 w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:ring-2"
                        />
                        <InputError message={form.errors.description} />
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="letter-request-notes">
                            {t('Notes')}
                        </Label>
                        <textarea
                            id="letter-request-notes"
                            value={form.data.notes}
                            aria-invalid={Boolean(form.errors.notes)}
                            onChange={(event) =>
                                form.setData('notes', event.target.value)
                            }
                            className="border-input placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring min-h-28 w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:ring-2"
                        />
                        <InputError message={form.errors.notes} />
                    </div>

                    <div className="border-border/80 space-y-4 rounded-lg border p-4">
                        <div className="flex items-start gap-3">
                            <Checkbox
                                id="letter-request-include-salary"
                                checked={form.data.include_salary}
                                onCheckedChange={(checked) =>
                                    form.setData(
                                        'include_salary',
                                        checked === true,
                                    )
                                }
                            />
                            <div className="space-y-1">
                                <Label htmlFor="letter-request-include-salary">
                                    {t('Include salary information')}
                                </Label>
                                <p className="text-muted-foreground text-sm">
                                    {t(
                                        'Include salary details in the requested letter.',
                                    )}
                                </p>
                            </div>
                        </div>

                        <div className="flex items-start gap-3">
                            <Checkbox
                                id="letter-request-attested"
                                checked={form.data.attested}
                                onCheckedChange={(checked) =>
                                    form.setData('attested', checked === true)
                                }
                            />
                            <div className="space-y-1">
                                <Label htmlFor="letter-request-attested">
                                    {t('Attested letter')}
                                </Label>
                                <p className="text-muted-foreground text-sm">
                                    {t(
                                        'Request an attested copy of the letter.',
                                    )}
                                </p>
                            </div>
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
                        form="letter-request-form"
                        disabled={form.processing}
                    >
                        {form.processing
                            ? t('Saving letter request')
                            : isEditing
                              ? t('Save changes')
                              : t('Submit letter request')}
                    </Button>
                </SheetFooter>
            </SheetContent>
        </Sheet>
    );
}

const emptyFormData: LetterRequestFormData = {
    attested: false,
    description: '',
    include_salary: false,
    notes: '',
    title: '',
};

function formDataFromLetter(
    letter: EmployeeLetterRequest,
): LetterRequestFormData {
    return {
        attested: letter.attested,
        description: letter.description ?? '',
        include_salary: letter.include_salary,
        notes: letter.notes ?? '',
        title: letter.title,
    };
}
