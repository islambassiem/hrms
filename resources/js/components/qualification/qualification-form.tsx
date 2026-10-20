import { Link, useForm } from '@inertiajs/react';
import { CircleAlert, Save } from 'lucide-react';
import type { FormEvent } from 'react';
import { useTranslation } from 'react-i18next';

import InputError from '@/components/input-error';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { index, store, update } from '@/routes/qualifications';
import type {
    EmployeeQualification,
    QualificationFormData,
    QualificationFormOptions,
    QualificationLookup,
} from '@/types';

const emptySelectionValue = '__none__';

type QualificationFormProps = {
    mode: 'create' | 'edit';
    options: QualificationFormOptions;
    qualification?: EmployeeQualification;
};

type LookupField =
    | 'major_id'
    | 'minor_id'
    | 'educational_sublevel_id'
    | 'included_specialty_id'
    | 'scientific_degree_id'
    | 'graduation_country_id'
    | 'rating_id'
    | 'gpa_type_id'
    | 'study_type_id';

export function QualificationForm({
    mode,
    options,
    qualification,
}: QualificationFormProps) {
    const { t, i18n } = useTranslation();
    const form = useForm<QualificationFormData>(
        qualification
            ? formDataFromQualification(qualification)
            : emptyFormData,
    );
    const isEditing = mode === 'edit';

    const setLookupValue = (field: LookupField, value: string) => {
        form.setData(
            field,
            value === emptySelectionValue ? null : Number(value),
        );
        form.clearErrors(field);
    };

    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (isEditing && qualification) {
            form.put(update(qualification).url, {
                preserveScroll: true,
            });

            return;
        }

        form.post(store().url, {
            preserveScroll: true,
        });
    };

    return (
        <div
            dir={i18n.dir()}
            className="mx-auto w-full max-w-7xl space-y-8 p-4 sm:p-6 lg:p-8"
        >
            <header className="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div className="space-y-1">
                    <h1 className="text-foreground text-xl font-semibold tracking-tight">
                        {isEditing
                            ? t('Edit qualification')
                            : t('Create qualification')}
                    </h1>
                    <p className="text-muted-foreground text-sm">
                        {isEditing
                            ? t(
                                  'Update your education or professional credential details.',
                              )
                            : t(
                                  'Add your education or professional credentials to your employee profile.',
                              )}
                    </p>
                </div>

                <Button asChild variant="outline" className="w-full sm:w-auto">
                    <Link href={index()}>{t('Back to qualifications')}</Link>
                </Button>
            </header>

            <form onSubmit={handleSubmit} className="space-y-6">
                {form.hasErrors ? (
                    <Alert variant="destructive">
                        <CircleAlert aria-hidden="true" />
                        <AlertTitle>{t('Check the form')}</AlertTitle>
                        <AlertDescription>
                            {Object.values(form.errors)[0]}
                        </AlertDescription>
                    </Alert>
                ) : null}

                <Card className="border-border/80 bg-card shadow-xs">
                    <CardHeader>
                        <CardTitle>{t('Academic details')}</CardTitle>
                        <CardDescription>
                            {t(
                                'Tell us about the qualification you completed.',
                            )}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="grid gap-5 md:grid-cols-2">
                        <LookupSelect
                            id="qualification-major"
                            label={t('Major / specialty')}
                            placeholder={t('Select an option')}
                            options={options.specialities}
                            value={form.data.major_id}
                            error={form.errors.major_id}
                            required
                            direction={i18n.dir()}
                            onValueChange={(value) =>
                                setLookupValue('major_id', value)
                            }
                        />
                        <LookupSelect
                            id="qualification-minor"
                            label={t('Minor / specialty')}
                            placeholder={t('Not selected')}
                            options={options.specialities}
                            value={form.data.minor_id}
                            error={form.errors.minor_id}
                            direction={i18n.dir()}
                            emptyLabel={t('Not selected')}
                            onValueChange={(value) =>
                                setLookupValue('minor_id', value)
                            }
                        />
                        <LookupSelect
                            id="qualification-degree"
                            label={t('Scientific degree')}
                            placeholder={t('Not selected')}
                            options={options.scientific_degrees}
                            value={form.data.scientific_degree_id}
                            error={form.errors.scientific_degree_id}
                            direction={i18n.dir()}
                            emptyLabel={t('Not selected')}
                            onValueChange={(value) =>
                                setLookupValue('scientific_degree_id', value)
                            }
                        />
                        <LookupSelect
                            id="qualification-level"
                            label={t('Educational level')}
                            placeholder={t('Not selected')}
                            options={options.educational_sublevels}
                            value={form.data.educational_sublevel_id}
                            error={form.errors.educational_sublevel_id}
                            direction={i18n.dir()}
                            emptyLabel={t('Not selected')}
                            onValueChange={(value) =>
                                setLookupValue('educational_sublevel_id', value)
                            }
                        />
                        <LookupSelect
                            id="qualification-included-specialty"
                            label={t('Included specialty')}
                            placeholder={t('Not selected')}
                            options={options.included_specializations}
                            value={form.data.included_specialty_id}
                            error={form.errors.included_specialty_id}
                            direction={i18n.dir()}
                            emptyLabel={t('Not selected')}
                            onValueChange={(value) =>
                                setLookupValue('included_specialty_id', value)
                            }
                        />
                    </CardContent>
                </Card>

                <Card className="border-border/80 bg-card shadow-xs">
                    <CardHeader>
                        <CardTitle>{t('Institution details')}</CardTitle>
                        <CardDescription>
                            {t(
                                'Record where and when you completed this qualification.',
                            )}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="grid gap-5 md:grid-cols-2">
                        <TextField
                            id="qualification-institution-name"
                            label={t('Institution name')}
                            value={form.data.institution_name}
                            error={form.errors.institution_name}
                            onChange={(value) =>
                                form.setData('institution_name', value)
                            }
                        />
                        <TextField
                            id="qualification-college-name"
                            label={t('College name')}
                            value={form.data.college_name}
                            error={form.errors.college_name}
                            onChange={(value) =>
                                form.setData('college_name', value)
                            }
                        />
                        <div className="space-y-2">
                            <Label htmlFor="qualification-graduation-date">
                                {t('Graduation date')}
                            </Label>
                            <Input
                                id="qualification-graduation-date"
                                type="date"
                                dir={i18n.dir()}
                                lang={i18n.language}
                                value={form.data.graduation_date}
                                aria-invalid={Boolean(
                                    form.errors.graduation_date,
                                )}
                                onChange={(event) => {
                                    form.setData(
                                        'graduation_date',
                                        event.target.value,
                                    );
                                    form.clearErrors('graduation_date');
                                }}
                            />
                            <InputError message={form.errors.graduation_date} />
                        </div>
                        <LookupSelect
                            id="qualification-graduation-country"
                            label={t('Graduation country')}
                            placeholder={t('Not selected')}
                            options={options.countries}
                            value={form.data.graduation_country_id}
                            error={form.errors.graduation_country_id}
                            direction={i18n.dir()}
                            emptyLabel={t('Not selected')}
                            onValueChange={(value) =>
                                setLookupValue('graduation_country_id', value)
                            }
                        />
                        <TextField
                            id="qualification-city"
                            label={t('City')}
                            value={form.data.city}
                            error={form.errors.city}
                            onChange={(value) => form.setData('city', value)}
                        />
                        <LookupSelect
                            id="qualification-study-type"
                            label={t('Study type')}
                            placeholder={t('Not selected')}
                            options={options.study_types}
                            value={form.data.study_type_id}
                            error={form.errors.study_type_id}
                            direction={i18n.dir()}
                            emptyLabel={t('Not selected')}
                            onValueChange={(value) =>
                                setLookupValue('study_type_id', value)
                            }
                        />
                    </CardContent>
                </Card>

                <Card className="border-border/80 bg-card shadow-xs">
                    <CardHeader>
                        <CardTitle>{t('Assessment')}</CardTitle>
                        <CardDescription>
                            {t(
                                'Add the assessment information supplied by your institution.',
                            )}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="grid gap-5 md:grid-cols-2">
                        <LookupSelect
                            id="qualification-rating"
                            label={t('Rating')}
                            placeholder={t('Not selected')}
                            options={options.ratings}
                            value={form.data.rating_id}
                            error={form.errors.rating_id}
                            direction={i18n.dir()}
                            emptyLabel={t('Not selected')}
                            onValueChange={(value) =>
                                setLookupValue('rating_id', value)
                            }
                        />
                        <TextField
                            id="qualification-gpa"
                            label={t('GPA')}
                            value={form.data.gpa}
                            error={form.errors.gpa}
                            onChange={(value) => form.setData('gpa', value)}
                        />
                        <LookupSelect
                            id="qualification-gpa-type"
                            label={t('GPA type')}
                            placeholder={t('Not selected')}
                            options={options.gpa_types}
                            value={form.data.gpa_type_id}
                            error={form.errors.gpa_type_id}
                            direction={i18n.dir()}
                            emptyLabel={t('Not selected')}
                            onValueChange={(value) =>
                                setLookupValue('gpa_type_id', value)
                            }
                        />
                    </CardContent>
                </Card>

                <Card className="border-border/80 bg-card shadow-xs">
                    <CardHeader>
                        <CardTitle>{t('Record status')}</CardTitle>
                        <CardDescription>
                            {t(
                                'Choose whether this is your most recent qualification.',
                            )}
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="flex items-start gap-3">
                            <Checkbox
                                id="qualification-is-last"
                                checked={form.data.is_last_qualification}
                                onCheckedChange={(checked) => {
                                    form.setData(
                                        'is_last_qualification',
                                        checked === true,
                                    );
                                    form.clearErrors('is_last_qualification');
                                }}
                            />
                            <div className="space-y-1">
                                <Label htmlFor="qualification-is-last">
                                    {t('Last qualification')}
                                </Label>
                                <p className="text-muted-foreground text-sm">
                                    {t(
                                        'Mark this as your most recent qualification.',
                                    )}
                                </p>
                                <InputError
                                    message={form.errors.is_last_qualification}
                                />
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter className="justify-end gap-3 border-t pt-6">
                        <Button asChild type="button" variant="outline">
                            <Link href={index()}>{t('Cancel')}</Link>
                        </Button>
                        <Button type="submit" disabled={form.processing}>
                            <Save className="size-4" />
                            {form.processing
                                ? isEditing
                                    ? t('Saving changes')
                                    : t('Saving qualification')
                                : isEditing
                                  ? t('Save changes')
                                  : t('Save qualification')}
                        </Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    );
}

function LookupSelect({
    id,
    label,
    placeholder,
    options,
    value,
    error,
    direction,
    emptyLabel,
    required = false,
    onValueChange,
}: {
    id: string;
    label: string;
    placeholder: string;
    options: QualificationLookup[];
    value: number | null;
    error?: string;
    direction: 'ltr' | 'rtl';
    emptyLabel?: string;
    required?: boolean;
    onValueChange: (value: string) => void;
}) {
    return (
        <div className="space-y-2">
            <Label htmlFor={id}>
                {label}
                {required ? <span aria-hidden="true"> *</span> : null}
            </Label>
            <Select
                value={value === null ? undefined : String(value)}
                onValueChange={onValueChange}
            >
                <SelectTrigger
                    id={id}
                    className="w-full"
                    aria-invalid={Boolean(error)}
                    aria-required={required || undefined}
                >
                    <SelectValue placeholder={placeholder} />
                </SelectTrigger>
                <SelectContent dir={direction}>
                    {emptyLabel ? (
                        <SelectItem value={emptySelectionValue}>
                            {emptyLabel}
                        </SelectItem>
                    ) : null}
                    {options.map((option) => (
                        <SelectItem key={option.id} value={String(option.id)}>
                            {option.name}
                        </SelectItem>
                    ))}
                </SelectContent>
            </Select>
            <InputError message={error} />
        </div>
    );
}

function TextField({
    id,
    label,
    value,
    error,
    onChange,
}: {
    id: string;
    label: string;
    value: string;
    error?: string;
    onChange: (value: string) => void;
}) {
    return (
        <div className="space-y-2">
            <Label htmlFor={id}>{label}</Label>
            <Input
                id={id}
                value={value}
                aria-invalid={Boolean(error)}
                onChange={(event) => onChange(event.target.value)}
            />
            <InputError message={error} />
        </div>
    );
}

const emptyFormData: QualificationFormData = {
    major_id: null,
    minor_id: null,
    educational_sublevel_id: null,
    included_specialty_id: null,
    institution_name: '',
    college_name: '',
    scientific_degree_id: null,
    graduation_date: '',
    graduation_country_id: null,
    is_last_qualification: false,
    rating_id: null,
    gpa: '',
    gpa_type_id: null,
    study_type_id: null,
    city: '',
};

function formDataFromQualification(
    qualification: EmployeeQualification,
): QualificationFormData {
    return {
        major_id: qualification.major?.id ?? null,
        minor_id: qualification.minor?.id ?? null,
        educational_sublevel_id: qualification.educational_sublevel?.id ?? null,
        included_specialty_id: qualification.included_specialty?.id ?? null,
        institution_name: qualification.institution_name ?? '',
        college_name: qualification.college_name ?? '',
        scientific_degree_id: qualification.scientific_degree?.id ?? null,
        graduation_date: qualification.graduation_date ?? '',
        graduation_country_id: qualification.graduation_country?.id ?? null,
        is_last_qualification: qualification.is_last_qualification,
        rating_id: qualification.rating?.id ?? null,
        gpa: qualification.gpa ?? '',
        gpa_type_id: qualification.gpa_type?.id ?? null,
        study_type_id: qualification.study_type?.id ?? null,
        city: qualification.city ?? '',
    };
}
