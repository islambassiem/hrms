import { Link } from '@inertiajs/react';
import {
    ArrowLeft,
    BriefcaseBusiness,
    CalendarDays,
    FileText,
    GraduationCap,
    Mail,
    MapPin,
    UserRound,
} from 'lucide-react';
import type { ReactNode } from 'react';
import { useTranslation } from 'react-i18next';

import { formatHeadDate } from '@/components/head/head-page-formatters';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { index as employeeDirectoryRoute } from '@/routes/head/employees';
import type {
    HeadEmployeeDetailsPageProps,
    HeadEmployeeQualificationDetails,
} from '@/types/head';

export function DepartmentHeadEmployeeDetailsPage({
    employee,
    qualifications,
}: HeadEmployeeDetailsPageProps) {
    const { i18n, t } = useTranslation();

    return (
        <main
            dir={i18n.dir()}
            className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6"
        >
            <header className="space-y-4">
                <Button asChild variant="ghost" className="-ms-3 w-fit">
                    <Link href={employeeDirectoryRoute()}>
                        <ArrowLeft
                            className="size-4 rtl:rotate-180"
                            aria-hidden="true"
                        />
                        {t('Back to employees')}
                    </Link>
                </Button>
                <div className="space-y-1">
                    <h1 className="text-foreground text-xl font-semibold tracking-tight">
                        {t('Employee details')}
                    </h1>
                    <p className="text-muted-foreground text-sm">
                        {t('Review employee information and qualifications.')}
                    </p>
                </div>
            </header>

            <Card className="border-border/80 bg-sidebar shadow-xs">
                <CardHeader className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div className="flex min-w-0 items-center gap-4">
                        <Avatar className="border-border/80 size-16 shrink-0 rounded-xl border shadow-xs">
                            <AvatarImage
                                src={employee.image ?? undefined}
                                alt={employee.name}
                            />
                            <AvatarFallback className="bg-primary/10 text-primary rounded-xl text-lg font-semibold">
                                {initials(employee.name)}
                            </AvatarFallback>
                        </Avatar>
                        <div className="min-w-0 space-y-1">
                            <CardTitle className="break-words">
                                {employee.name}
                            </CardTitle>
                            <CardDescription>
                                {employee.employeeCode}
                            </CardDescription>
                        </div>
                    </div>
                    <Badge
                        variant={employee.isActive ? 'secondary' : 'outline'}
                    >
                        {employee.isActive ? t('Active') : t('Inactive')}
                    </Badge>
                </CardHeader>
                <CardContent>
                    <div className="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        <DetailField label={t('Gender')}>
                            <UserRound
                                className="text-muted-foreground size-4"
                                aria-hidden="true"
                            />
                            {employee.gender ?? t('Not available')}
                        </DetailField>
                        <DetailField label={t('Department')}>
                            <MapPin
                                className="text-muted-foreground size-4"
                                aria-hidden="true"
                            />
                            {employee.department ?? t('Not available')}
                        </DetailField>
                        <DetailField label={t('Official email')}>
                            <Mail
                                className="text-muted-foreground size-4"
                                aria-hidden="true"
                            />
                            {employee.officialEmail ? (
                                <a
                                    href={`mailto:${employee.officialEmail}`}
                                    dir="ltr"
                                    className="text-foreground min-w-0 break-all underline-offset-4 hover:underline"
                                >
                                    {employee.officialEmail}
                                </a>
                            ) : (
                                t('Not available')
                            )}
                        </DetailField>
                        <DetailField label={t('Joining date')}>
                            <CalendarDays
                                className="text-muted-foreground size-4"
                                aria-hidden="true"
                            />
                            <DateValue
                                date={employee.joiningDate}
                                locale={i18n.language}
                            />
                        </DetailField>
                        <DetailField label={t('Current position')}>
                            <BriefcaseBusiness
                                className="text-muted-foreground size-4"
                                aria-hidden="true"
                            />
                            {employee.currentPosition?.title ??
                                t('Not available')}
                        </DetailField>
                        {employee.currentPosition?.startDate ? (
                            <DetailField label={t('Position start date')}>
                                <CalendarDays
                                    className="text-muted-foreground size-4"
                                    aria-hidden="true"
                                />
                                <DateValue
                                    date={employee.currentPosition.startDate}
                                    locale={i18n.language}
                                />
                            </DetailField>
                        ) : null}
                    </div>
                </CardContent>
            </Card>

            <section aria-labelledby="head-employee-qualifications-title">
                <Card className="border-border/80 bg-sidebar shadow-xs">
                    <CardHeader>
                        <CardTitle
                            id="head-employee-qualifications-title"
                            className="flex items-center gap-2"
                        >
                            <GraduationCap
                                className="text-muted-foreground size-5"
                                aria-hidden="true"
                            />
                            {t('Qualifications')}
                        </CardTitle>
                        <CardDescription>
                            {t('Qualification records for this employee.')}
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        {qualifications.length > 0 ? (
                            <ul className="grid gap-4 xl:grid-cols-2">
                                {qualifications.map((qualification) => (
                                    <QualificationCard
                                        key={qualification.id}
                                        qualification={qualification}
                                    />
                                ))}
                            </ul>
                        ) : (
                            <div className="flex flex-col items-center gap-3 rounded-lg border py-10 text-center">
                                <span className="bg-muted text-muted-foreground flex size-11 items-center justify-center rounded-lg">
                                    <GraduationCap
                                        className="size-5"
                                        aria-hidden="true"
                                    />
                                </span>
                                <p className="text-foreground font-medium">
                                    {t('No qualifications recorded.')}
                                </p>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </section>
        </main>
    );
}

function QualificationCard({
    qualification,
}: {
    qualification: HeadEmployeeQualificationDetails;
}) {
    const { i18n, t } = useTranslation();
    const title =
        qualification.scientificDegree ??
        qualification.educationalSublevel ??
        t('Qualification');

    return (
        <li className="min-w-0 rounded-lg border p-4 sm:p-5">
            <div className="flex flex-wrap items-start justify-between gap-3">
                <div className="min-w-0 space-y-1">
                    <h2 className="text-foreground font-semibold break-words">
                        {title}
                    </h2>
                    {qualification.major ? (
                        <p className="text-muted-foreground text-sm break-words">
                            {qualification.major}
                        </p>
                    ) : null}
                </div>
                {qualification.isLastQualification ? (
                    <Badge variant="secondary">
                        {t('Latest qualification')}
                    </Badge>
                ) : null}
            </div>

            <dl className="mt-5 grid gap-x-5 gap-y-4 sm:grid-cols-2">
                <DetailValue
                    label={t('Educational sublevel')}
                    value={qualification.educationalSublevel}
                />
                <DetailValue
                    label={t('Included specialty')}
                    value={qualification.includedSpecialty}
                />
                <DetailValue label={t('Minor')} value={qualification.minor} />
                <DetailValue
                    label={t('Institution')}
                    value={qualification.institutionName}
                />
                <DetailValue
                    label={t('College')}
                    value={qualification.collegeName}
                />
                <DetailValue
                    label={t('Graduation country')}
                    value={qualification.graduationCountry}
                />
                <DetailValue
                    label={t('Graduation date')}
                    value={
                        qualification.graduationDate ? (
                            <DateValue
                                date={qualification.graduationDate}
                                locale={i18n.language}
                            />
                        ) : null
                    }
                />
                <DetailValue
                    label={t('Study type')}
                    value={qualification.studyType}
                />
                <DetailValue label={t('Rating')} value={qualification.rating} />
                <DetailValue
                    label={t('GPA')}
                    value={
                        qualification.gpa
                            ? [qualification.gpa, qualification.gpaType]
                                  .filter(Boolean)
                                  .join(' · ')
                            : null
                    }
                />
                <DetailValue label={t('City')} value={qualification.city} />
                <DetailValue
                    label={t('Authentication status')}
                    value={t(
                        qualification.isAuthenticated
                            ? 'Authenticated'
                            : 'Not authenticated',
                    )}
                />
            </dl>

            <div className="mt-5 border-t pt-4">
                <h3 className="text-foreground mb-3 flex items-center gap-2 text-sm font-medium">
                    <FileText className="size-4" aria-hidden="true" />
                    {t('Attachments')}
                </h3>
                {qualification.attachments.length > 0 ? (
                    <ul className="grid gap-2 sm:grid-cols-2">
                        {qualification.attachments.map((attachment) => (
                            <li
                                key={attachment.id}
                                className="bg-muted/30 flex min-w-0 items-start gap-2 rounded-md border p-3"
                            >
                                <FileText
                                    className="text-muted-foreground mt-0.5 size-4 shrink-0"
                                    aria-hidden="true"
                                />
                                <span className="min-w-0">
                                    <span className="text-foreground block text-sm font-medium break-all">
                                        {attachment.name}
                                    </span>
                                    <span className="text-muted-foreground block text-xs">
                                        {formatFileSize(
                                            attachment.size_bytes,
                                            i18n.language,
                                        )}
                                    </span>
                                </span>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <p className="text-muted-foreground text-sm">
                        {t('No attachments recorded.')}
                    </p>
                )}
            </div>
        </li>
    );
}

function DetailField({
    children,
    label,
}: {
    children: ReactNode;
    label: string;
}) {
    return (
        <div className="min-w-0 space-y-1">
            <dt className="text-muted-foreground text-xs">{label}</dt>
            <dd className="text-foreground flex min-w-0 items-start gap-2 text-sm font-medium break-words">
                {children}
            </dd>
        </div>
    );
}

function DetailValue({
    label,
    value,
}: {
    label: string;
    value: ReactNode | null;
}) {
    const { t } = useTranslation();

    return (
        <div className="min-w-0 space-y-1">
            <dt className="text-muted-foreground text-xs">{label}</dt>
            <dd className="text-foreground text-sm font-medium break-words">
                {value ?? t('Not available')}
            </dd>
        </div>
    );
}

function DateValue({ date, locale }: { date: string | null; locale: string }) {
    const { t } = useTranslation();

    if (!date) {
        return <>{t('Not available')}</>;
    }

    return <time dateTime={date}>{formatHeadDate(date, locale)}</time>;
}

function formatFileSize(sizeBytes: number, locale: string): string {
    const units = ['B', 'KB', 'MB', 'GB'];
    let size = sizeBytes;
    let unit = 0;

    while (size >= 1024 && unit < units.length - 1) {
        size /= 1024;
        unit += 1;
    }

    return `${new Intl.NumberFormat(locale, { maximumFractionDigits: 1 }).format(size)} ${units[unit]}`;
}

function initials(name: string): string {
    return (
        name
            .trim()
            .split(/\s+/u)
            .filter(Boolean)
            .map((part) => part.slice(0, 1))
            .slice(0, 2)
            .join('')
            .toUpperCase() || '—'
    );
}
