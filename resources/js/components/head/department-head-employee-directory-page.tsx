import { Link, router } from '@inertiajs/react';
import { Filter, Mail, Search, UsersRound } from 'lucide-react';
import { useEffect, useState, type FormEvent, type ReactNode } from 'react';
import { useTranslation } from 'react-i18next';

import { HeadRequestPagination } from '@/components/head/head-request-pagination';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { index as employeeDirectoryRoute } from '@/routes/head/employees';
import { show as employeeDetailsRoute } from '@/routes/head/employees';
import type {
    HeadDirectoryEmployee,
    HeadEmployeeDirectoryPageProps,
} from '@/types/head';

type FilterValues = {
    search: string;
    genderId: string;
};

const emptyFilters: FilterValues = {
    search: '',
    genderId: '',
};

export function DepartmentHeadEmployeeDirectoryPage({
    employees,
    filters,
    genders,
}: HeadEmployeeDirectoryPageProps) {
    const { i18n, t } = useTranslation();
    const [values, setValues] = useState<FilterValues>({
        search: filters.search ?? '',
        genderId: filters.genderId ? String(filters.genderId) : '',
    });
    const hasAppliedFilters = Boolean(filters.search || filters.genderId);

    useEffect(() => {
        setValues({
            search: filters.search ?? '',
            genderId: filters.genderId ? String(filters.genderId) : '',
        });
    }, [filters.genderId, filters.search]);

    const applyFilters = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const query: Record<string, string> = {};

        if (values.search.trim()) query.search = values.search.trim();
        if (values.genderId) query.gender_id = values.genderId;

        router.get(employeeDirectoryRoute.url(), query, {
            preserveScroll: true,
            replace: true,
        });
    };

    const clearFilters = () => {
        setValues(emptyFilters);
        router.get(
            employeeDirectoryRoute.url(),
            {},
            {
                preserveScroll: true,
                replace: true,
            },
        );
    };

    return (
        <main
            dir={i18n.dir()}
            className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6"
        >
            <header className="space-y-1">
                <h1 className="text-foreground text-xl font-semibold tracking-tight">
                    {t('Employees')}
                </h1>
                <p className="text-muted-foreground text-sm">
                    {t('Browse active employees who report to you.')}
                </p>
            </header>

            <Card className="border-border/80 bg-sidebar shadow-xs">
                <CardHeader>
                    <CardTitle className="flex items-center gap-2">
                        <Filter
                            className="text-muted-foreground size-4"
                            aria-hidden="true"
                        />
                        {t('Filter employees')}
                    </CardTitle>
                    <CardDescription>
                        {t('Search employees by name or official email.')}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form onSubmit={applyFilters} className="space-y-4">
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="space-y-2">
                                <Label htmlFor="head-employee-search">
                                    {t('Name or official email')}
                                </Label>
                                <div className="relative">
                                    <Search
                                        className="text-muted-foreground pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2"
                                        aria-hidden="true"
                                    />
                                    <Input
                                        id="head-employee-search"
                                        value={values.search}
                                        onChange={(event) =>
                                            setValues((current) => ({
                                                ...current,
                                                search: event.target.value,
                                            }))
                                        }
                                        maxLength={100}
                                        placeholder={t(
                                            'Search by name or email',
                                        )}
                                        autoComplete="off"
                                        className="ps-9"
                                    />
                                </div>
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="head-employee-gender">
                                    {t('Gender')}
                                </Label>
                                <Select
                                    value={values.genderId || 'all'}
                                    onValueChange={(genderId) =>
                                        setValues((current) => ({
                                            ...current,
                                            genderId:
                                                genderId === 'all'
                                                    ? ''
                                                    : genderId,
                                        }))
                                    }
                                >
                                    <SelectTrigger
                                        id="head-employee-gender"
                                        className="w-full"
                                    >
                                        <SelectValue
                                            placeholder={t('All genders')}
                                        />
                                    </SelectTrigger>
                                    <SelectContent dir={i18n.dir()}>
                                        <SelectItem value="all">
                                            {t('All genders')}
                                        </SelectItem>
                                        {genders.map((gender) => (
                                            <SelectItem
                                                key={gender.id}
                                                value={String(gender.id)}
                                            >
                                                {gender.name}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                        <div className="flex flex-wrap items-center gap-2">
                            <Button type="submit">{t('Apply filters')}</Button>
                            {hasAppliedFilters ? (
                                <Button
                                    type="button"
                                    variant="outline"
                                    onClick={clearFilters}
                                >
                                    {t('Clear')}
                                </Button>
                            ) : null}
                        </div>
                    </form>
                </CardContent>
            </Card>

            <Card className="border-border/80 bg-sidebar shadow-xs">
                <CardHeader>
                    <CardTitle>{t('Direct reports')}</CardTitle>
                    <CardDescription>
                        {t('Employees found', { count: employees.meta.total })}
                    </CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    {employees.data.length > 0 ? (
                        <>
                            <div className="hidden overflow-hidden rounded-lg border lg:block">
                                <table className="w-full table-fixed text-start text-sm">
                                    <caption className="sr-only">
                                        {t('Employee directory list')}
                                    </caption>
                                    <thead className="bg-muted/40 text-muted-foreground border-b">
                                        <tr>
                                            <th
                                                scope="col"
                                                className="w-[22%] px-4 py-3 font-medium"
                                            >
                                                {t('Employee')}
                                            </th>
                                            <th
                                                scope="col"
                                                className="w-[13%] px-4 py-3 font-medium"
                                            >
                                                {t('Employee code')}
                                            </th>
                                            <th
                                                scope="col"
                                                className="w-[12%] px-4 py-3 font-medium"
                                            >
                                                {t('Gender')}
                                            </th>
                                            <th
                                                scope="col"
                                                className="w-[25%] px-4 py-3 font-medium"
                                            >
                                                {t('Latest qualification')}
                                            </th>
                                            <th
                                                scope="col"
                                                className="w-[28%] px-4 py-3 font-medium"
                                            >
                                                {t('Official email')}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-border divide-y">
                                        {employees.data.map((employee) => (
                                            <EmployeeTableRow
                                                key={employee.id}
                                                employee={employee}
                                            />
                                        ))}
                                    </tbody>
                                </table>
                            </div>

                            <ul className="grid gap-3 lg:hidden">
                                {employees.data.map((employee) => (
                                    <EmployeeCard
                                        key={employee.id}
                                        employee={employee}
                                    />
                                ))}
                            </ul>
                        </>
                    ) : (
                        <div className="flex flex-col items-center gap-3 rounded-lg border py-10 text-center">
                            <span className="bg-muted text-muted-foreground flex size-11 items-center justify-center rounded-lg">
                                <UsersRound
                                    className="size-5"
                                    aria-hidden="true"
                                />
                            </span>
                            <div className="space-y-1">
                                <p className="text-foreground font-medium">
                                    {hasAppliedFilters
                                        ? t('No employees match these filters.')
                                        : t('No active direct reports found.')}
                                </p>
                                <p className="text-muted-foreground text-sm">
                                    {hasAppliedFilters
                                        ? t(
                                              'Try changing or clearing your search filters.',
                                          )
                                        : t(
                                              'Active employees assigned to you will appear here.',
                                          )}
                                </p>
                            </div>
                        </div>
                    )}
                    <HeadRequestPagination
                        links={employees.links}
                        meta={employees.meta}
                    />
                </CardContent>
            </Card>
        </main>
    );
}

function EmployeeTableRow({ employee }: { employee: HeadDirectoryEmployee }) {
    const { t } = useTranslation();

    return (
        <tr className="align-top">
            <td className="px-4 py-4">
                <EmployeeIdentity employee={employee} />
            </td>
            <td
                className="text-foreground px-4 py-4 font-mono text-xs"
                dir="ltr"
            >
                {employee.employeeCode}
            </td>
            <td className="text-foreground px-4 py-4">
                {employee.gender?.name ?? t('Not available')}
            </td>
            <td className="text-foreground px-4 py-4">
                <QualificationSummary employee={employee} />
            </td>
            <td className="px-4 py-4">
                <EmployeeEmail employee={employee} />
            </td>
        </tr>
    );
}

function EmployeeCard({ employee }: { employee: HeadDirectoryEmployee }) {
    const { t } = useTranslation();

    return (
        <li className="min-w-0 rounded-lg border p-4">
            <div className="flex min-w-0 items-start gap-3">
                <EmployeeIdentity employee={employee} />
            </div>
            <dl className="mt-4 grid gap-3 border-t pt-4 sm:grid-cols-2">
                <Detail label={t('Employee code')}>
                    <span dir="ltr" className="font-mono text-xs">
                        {employee.employeeCode}
                    </span>
                </Detail>
                <Detail label={t('Gender')}>
                    {employee.gender?.name ?? t('Not available')}
                </Detail>
                <Detail label={t('Latest qualification')}>
                    <QualificationSummary employee={employee} />
                </Detail>
                <Detail label={t('Official email')}>
                    <EmployeeEmail employee={employee} />
                </Detail>
            </dl>
        </li>
    );
}

function EmployeeIdentity({ employee }: { employee: HeadDirectoryEmployee }) {
    return (
        <Link
            href={employeeDetailsRoute(employee.id)}
            preserveScroll
            className="focus-visible:ring-ring flex min-w-0 items-center gap-3 rounded-md outline-none focus-visible:ring-[3px]"
        >
            <Avatar className="size-10 rounded-lg">
                <AvatarImage src={employee.image ?? undefined} alt="" />
                <AvatarFallback className="bg-primary/10 text-primary rounded-lg text-xs font-semibold">
                    {initials(employee.name)}
                </AvatarFallback>
            </Avatar>
            <span className="text-foreground min-w-0 font-medium break-words hover:underline">
                {employee.name}
            </span>
        </Link>
    );
}

function QualificationSummary({
    employee,
}: {
    employee: HeadDirectoryEmployee;
}) {
    const { i18n, t } = useTranslation();
    const qualification = employee.latestQualification;

    if (!qualification) {
        return (
            <span className="text-muted-foreground">{t('Not available')}</span>
        );
    }

    const summary = [
        qualification.scientificDegree,
        qualification.educationalSublevel,
        qualification.major,
    ].filter((value): value is string => Boolean(value));

    return (
        <span className="block space-y-1">
            <span className="block">
                {summary.join(' · ') || t('Not available')}
            </span>
            {qualification.graduationDate ? (
                <time
                    className="text-muted-foreground block text-xs"
                    dateTime={qualification.graduationDate}
                >
                    {new Intl.DateTimeFormat(i18n.language, {
                        dateStyle: 'medium',
                        timeZone: 'UTC',
                    }).format(
                        new Date(`${qualification.graduationDate}T00:00:00Z`),
                    )}
                </time>
            ) : null}
        </span>
    );
}

function EmployeeEmail({ employee }: { employee: HeadDirectoryEmployee }) {
    const { t } = useTranslation();

    return employee.officialEmail ? (
        <a
            href={`mailto:${employee.officialEmail}`}
            dir="ltr"
            className="text-foreground hover:text-primary inline-flex max-w-full items-start gap-2 break-all underline-offset-4 hover:underline focus-visible:rounded-sm focus-visible:outline-2 focus-visible:outline-offset-2"
        >
            <Mail
                className="text-muted-foreground mt-0.5 size-4 shrink-0"
                aria-hidden="true"
            />
            <span>{employee.officialEmail}</span>
        </a>
    ) : (
        <span className="text-muted-foreground">{t('Not available')}</span>
    );
}

function Detail({ children, label }: { children: ReactNode; label: string }) {
    return (
        <div className="min-w-0 space-y-1">
            <dt className="text-muted-foreground text-xs">{label}</dt>
            <dd className="text-foreground min-w-0 text-sm font-medium break-words">
                {children}
            </dd>
        </div>
    );
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
