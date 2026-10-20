import { Link } from '@inertiajs/react';
import {
    Award,
    BookOpenCheck,
    CalendarDays,
    ChevronRight,
    CircleCheck,
    MapPin,
    Plus,
} from 'lucide-react';
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
import { create, show } from '@/routes/qualifications';
import type { EmployeeQualification } from '@/types';

import { formatQualificationDate } from './qualification-formatters';

type QualificationIndexPageProps = {
    qualifications: EmployeeQualification[];
    canCreate: boolean;
};

export function QualificationIndexPage({
    qualifications,
    canCreate,
}: QualificationIndexPageProps) {
    const { t, i18n } = useTranslation();

    return (
        <div
            dir={i18n.dir()}
            className="mx-auto w-full max-w-7xl space-y-8 p-4 sm:p-6 lg:p-8"
        >
            <header className="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div className="space-y-1">
                    <h1 className="text-foreground text-xl font-semibold tracking-tight">
                        {t('Qualifications')}
                    </h1>
                    <p className="text-muted-foreground text-sm">
                        {t('Review and manage your education and credentials.')}
                    </p>
                </div>

                {canCreate ? (
                    <Button asChild className="w-full sm:w-auto">
                        <Link href={create()}>
                            <Plus className="size-4" />
                            {t('Add qualification')}
                        </Link>
                    </Button>
                ) : null}
            </header>

            {qualifications.length === 0 ? (
                <EmptyQualificationsState canCreate={canCreate} />
            ) : (
                <QualificationsList qualifications={qualifications} />
            )}
        </div>
    );
}

function QualificationsList({
    qualifications,
}: {
    qualifications: EmployeeQualification[];
}) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-card shadow-xs">
            <CardHeader>
                <CardTitle>{t('Your qualifications')}</CardTitle>
                <CardDescription>
                    {t('Select a qualification to view its full details.')}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <ul className="divide-border divide-y overflow-hidden rounded-lg border">
                    {qualifications.map((qualification) => (
                        <QualificationListItem
                            key={qualification.id}
                            qualification={qualification}
                        />
                    ))}
                </ul>
            </CardContent>
        </Card>
    );
}

function QualificationListItem({
    qualification,
}: {
    qualification: EmployeeQualification;
}) {
    const { t, i18n } = useTranslation();
    const title =
        qualification.scientific_degree?.name ??
        qualification.major?.name ??
        t('Qualification');
    const specialization = [
        qualification.major?.name,
        qualification.educational_sublevel?.name,
    ]
        .filter((value): value is string => Boolean(value))
        .join(' · ');
    const location = [
        qualification.city,
        qualification.graduation_country?.name,
    ]
        .filter((value): value is string => Boolean(value))
        .join(', ');

    return (
        <li className="last:border-b-0">
            <Link
                href={show(qualification)}
                className="hover:bg-accent focus-visible:ring-ring flex flex-col gap-4 p-4 transition-colors outline-none focus-visible:ring-2 focus-visible:ring-inset sm:flex-row sm:items-center sm:justify-between"
            >
                <div className="flex min-w-0 items-start gap-3">
                    <div className="bg-muted text-muted-foreground flex size-10 shrink-0 items-center justify-center rounded-lg">
                        <Award className="size-5" />
                    </div>
                    <div className="min-w-0 space-y-1">
                        <div className="flex flex-wrap items-center gap-2">
                            <p className="text-foreground font-medium">
                                {title}
                            </p>
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
                        {specialization ? (
                            <p className="text-muted-foreground text-sm">
                                {specialization}
                            </p>
                        ) : null}
                        {qualification.institution_name ? (
                            <p className="text-muted-foreground truncate text-sm">
                                {qualification.institution_name}
                            </p>
                        ) : null}
                    </div>
                </div>

                <div className="text-muted-foreground flex flex-wrap items-center gap-x-4 gap-y-2 text-sm sm:justify-end">
                    <Detail
                        icon={CalendarDays}
                        value={formatQualificationDate(
                            qualification.graduation_date,
                            i18n.language,
                            t('Graduation date unavailable'),
                        )}
                    />
                    {location ? (
                        <Detail icon={MapPin} value={location} />
                    ) : null}
                    <ChevronRight className="text-muted-foreground size-4 shrink-0 rtl:rotate-180" />
                </div>
            </Link>
        </li>
    );
}

function Detail({
    icon: Icon,
    value,
}: {
    icon: typeof BookOpenCheck;
    value: string;
}) {
    return (
        <span className="flex min-w-0 items-center gap-1.5">
            <Icon className="size-4 shrink-0" />
            <span className="truncate">{value}</span>
        </span>
    );
}

function EmptyQualificationsState({ canCreate }: { canCreate: boolean }) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-card shadow-xs">
            <CardContent className="flex flex-col items-center gap-3 py-12 text-center">
                <div className="bg-muted text-muted-foreground flex size-12 items-center justify-center rounded-lg">
                    <BookOpenCheck className="size-6" />
                </div>
                <div className="space-y-1">
                    <p className="text-foreground font-medium">
                        {canCreate
                            ? t('No qualifications yet')
                            : t('Qualifications unavailable')}
                    </p>
                    <p className="text-muted-foreground max-w-sm text-sm">
                        {canCreate
                            ? t(
                                  'Add your education or professional credentials to keep your employee profile complete.',
                              )
                            : t(
                                  'Qualifications are unavailable because no employee profile is linked to this account.',
                              )}
                    </p>
                </div>
                {canCreate ? (
                    <Button asChild>
                        <Link href={create()}>
                            <Plus className="size-4" />
                            {t('Add qualification')}
                        </Link>
                    </Button>
                ) : null}
            </CardContent>
        </Card>
    );
}
