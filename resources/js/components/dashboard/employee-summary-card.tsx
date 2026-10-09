import { UserRound } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import type { EmployeeDashboard } from '@/types';

import { formatDashboardDate } from './formatters';

type EmployeeSummaryCardProps = {
    employee: EmployeeDashboard | null;
    avatar?: string | null;
    employeeCode?: string | null;
};

export function EmployeeSummaryCard({
    employee,
    avatar,
    employeeCode,
}: EmployeeSummaryCardProps) {
    const { t, i18n } = useTranslation();

    if (employee === null) {
        return <MissingProfileState />;
    }

    const jobTitle = employee.jobTitle?.name ?? t('Not assigned');
    const department = employee.department ?? t('Not assigned');

    return (
        <Card
            dir={i18n.dir()}
            className="border-border/80 bg-sidebar gap-0 overflow-hidden py-0 shadow-xs"
        >
            <CardContent className="flex flex-col gap-5 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between">
                <div className="flex flex-col gap-4 sm:flex-row sm:items-start">
                    <Avatar className="border-border/80 size-16 shrink-0 rounded-xl border shadow-xs">
                        <AvatarImage
                            src={avatar ?? undefined}
                            alt={employee.name}
                        />
                        <AvatarFallback className="bg-primary/10 text-primary text-xl font-bold">
                            {initials(employee.name)}
                        </AvatarFallback>
                    </Avatar>
                    <div className="min-w-0 space-y-1.5 text-start">
                        <h1 className="text-foreground text-xl font-bold tracking-tight">
                            {employee.name}
                        </h1>
                        <p className="text-muted-foreground text-sm font-medium">
                            {jobTitle}
                        </p>
                        <div className="flex flex-wrap items-center gap-2.5 pt-1">
                            {employeeCode ? (
                                <Badge
                                    variant="outline"
                                    className="font-mono"
                                    aria-label={`${t('Employee code')}: ${employeeCode}`}
                                >
                                    #{employeeCode}
                                </Badge>
                            ) : null}
                            <span className="text-muted-foreground text-xs font-medium">
                                {department}
                            </span>
                        </div>
                    </div>
                </div>
                <Button
                    variant="outline"
                    size="sm"
                    className="shadow-xs"
                    disabled
                >
                    <UserRound className="size-3.5" />
                    {t('Profile unavailable')}
                </Button>
            </CardContent>
            <Separator />
            <CardContent className="bg-muted/20 rounded-b-xl p-5">
                <dl className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <Detail
                        label={t('Direct supervisor')}
                        value={employee.head}
                    />
                    <Detail
                        label={t('Joining date')}
                        value={formatDashboardDate(
                            employee.joiningDate,
                            i18n.language,
                        )}
                    />
                    <Detail
                        label={t('Contract end date')}
                        value={formatDashboardDate(
                            employee.contractEndDate,
                            i18n.language,
                        )}
                    />
                </dl>
            </CardContent>
        </Card>
    );
}

function MissingProfileState() {
    const { t, i18n } = useTranslation();

    return (
        <Alert
            dir={i18n.dir()}
            className="border-border/80 bg-sidebar shadow-xs"
        >
            <UserRound className="text-muted-foreground size-4" />
            <AlertTitle>{t('Employee profile is not available')}</AlertTitle>
            <AlertDescription>
                {t(
                    'Your account is not linked to an employee record. Contact HR if you need assistance.',
                )}
            </AlertDescription>
        </Alert>
    );
}

function Detail({ label, value }: { label: string; value: string | null }) {
    const { t } = useTranslation();

    return (
        <div>
            <dt className="text-muted-foreground text-xs font-medium tracking-wider uppercase">
                {label}
            </dt>
            <dd className="text-foreground mt-0.5 text-sm font-semibold">
                {value ?? t('Not available')}
            </dd>
        </div>
    );
}

function initials(name: string): string {
    const value = name
        .trim()
        .split(/\s+/u)
        .filter(Boolean)
        .map((part) => part.slice(0, 1))
        .slice(0, 2)
        .join('')
        .toUpperCase();

    return value || '—';
}
