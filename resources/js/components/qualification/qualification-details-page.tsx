import { Link } from '@inertiajs/react';
import { Award, CircleCheck, Pencil } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { edit, index } from '@/routes/qualifications';
import type { EmployeeQualification, QualificationLookup } from '@/types';

import { formatQualificationDate } from './qualification-formatters';

type QualificationDetailsPageProps = {
    qualification: EmployeeQualification;
};

export function QualificationDetailsPage({
    qualification,
}: QualificationDetailsPageProps) {
    const { t, i18n } = useTranslation();
    const title =
        qualification.scientific_degree?.name ??
        qualification.major?.name ??
        t('Qualification');

    return (
        <div
            dir={i18n.dir()}
            className="mx-auto w-full max-w-7xl space-y-8 p-4 sm:p-6 lg:p-8"
        >
            <header className="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div className="flex min-w-0 items-start gap-3">
                    <div className="bg-muted text-muted-foreground flex size-11 shrink-0 items-center justify-center rounded-lg">
                        <Award className="size-5" aria-hidden="true" />
                    </div>
                    <div className="min-w-0 space-y-1">
                        <div className="flex flex-wrap items-center gap-2">
                            <h1 className="text-foreground text-xl font-semibold tracking-tight">
                                {title}
                            </h1>
                            <Badge
                                variant={
                                    qualification.is_authenticated
                                        ? 'secondary'
                                        : 'outline'
                                }
                            >
                                {qualification.is_authenticated ? (
                                    <CircleCheck className="size-3" />
                                ) : null}
                                {qualification.is_authenticated
                                    ? t('Authenticated')
                                    : t('Not authenticated')}
                            </Badge>
                        </div>
                        <p className="text-muted-foreground text-sm">
                            {t('Review the details of this qualification.')}
                        </p>
                    </div>
                </div>

                <div className="flex flex-col gap-3 sm:flex-row">
                    <Button
                        asChild
                        variant="outline"
                        className="w-full sm:w-auto"
                    >
                        <Link href={index()}>
                            {t('Back to qualifications')}
                        </Link>
                    </Button>
                    <Button asChild className="w-full sm:w-auto">
                        <Link href={edit(qualification)}>
                            <Pencil className="size-4" />
                            {t('Edit qualification')}
                        </Link>
                    </Button>
                </div>
            </header>

            <DetailsCard
                title={t('Academic details')}
                description={t('Qualification and specialization information.')}
                fields={[
                    [t('Major / specialty'), qualification.major],
                    [t('Minor / specialty'), qualification.minor],
                    [t('Scientific degree'), qualification.scientific_degree],
                    [
                        t('Educational level'),
                        qualification.educational_sublevel,
                    ],
                    [t('Included specialty'), qualification.included_specialty],
                ]}
            />

            <DetailsCard
                title={t('Institution details')}
                description={t(
                    'Where and when the qualification was completed.',
                )}
                fields={[
                    [t('Institution name'), qualification.institution_name],
                    [t('College name'), qualification.college_name],
                    [
                        t('Graduation date'),
                        qualification.graduation_date
                            ? formatQualificationDate(
                                  qualification.graduation_date,
                                  i18n.language,
                                  t('Not available'),
                              )
                            : null,
                    ],
                    [t('Graduation country'), qualification.graduation_country],
                    [t('City'), qualification.city],
                    [t('Study type'), qualification.study_type],
                ]}
            />

            <DetailsCard
                title={t('Assessment')}
                description={t(
                    'Assessment information recorded for this qualification.',
                )}
                fields={[
                    [t('Rating'), qualification.rating],
                    [t('GPA'), qualification.gpa],
                    [t('GPA type'), qualification.gpa_type],
                    [
                        t('Last qualification'),
                        qualification.is_last_qualification
                            ? t('Yes')
                            : t('No'),
                    ],
                ]}
            />
        </div>
    );
}

function DetailsCard({
    title,
    description,
    fields,
}: {
    title: string;
    description: string;
    fields: Array<[string, QualificationLookup | string | null]>;
}) {
    return (
        <Card className="border-border/80 bg-card shadow-xs">
            <CardHeader>
                <CardTitle>{title}</CardTitle>
                <CardDescription>{description}</CardDescription>
            </CardHeader>
            <CardContent>
                <dl className="grid gap-x-8 gap-y-5 sm:grid-cols-2 lg:grid-cols-3">
                    {fields.map(([label, value]) => (
                        <div key={label} className="min-w-0 space-y-1">
                            <dt className="text-muted-foreground text-sm">
                                {label}
                            </dt>
                            <dd className="text-foreground font-medium break-words">
                                {formatDetailValue(value)}
                            </dd>
                        </div>
                    ))}
                </dl>
            </CardContent>
        </Card>
    );
}

function formatDetailValue(value: QualificationLookup | string | null): string {
    if (value === null) {
        return '—';
    }

    return typeof value === 'string' ? value : value.name;
}
