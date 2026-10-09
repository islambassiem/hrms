import { CalendarCheck2 } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type { EmployeeDashboardLeaveRequest } from '@/types';

import { formatDashboardDate, formatDashboardNumber } from './formatters';

type UpcomingApprovedRegularLeaveCardProps = {
    leave: EmployeeDashboardLeaveRequest | null;
};

export function UpcomingApprovedRegularLeaveCard({
    leave,
}: UpcomingApprovedRegularLeaveCardProps) {
    const { t, i18n } = useTranslation();

    return (
        <Card
            dir={i18n.dir()}
            className="border-border/80 bg-sidebar shadow-xs"
        >
            <CardHeader>
                <div className="flex items-start justify-between gap-4">
                    <div className="space-y-1.5">
                        <CardTitle>{t('Approved Leave')}</CardTitle>
                        <CardDescription>
                            {t('Current or next approved Regular Leave')}
                        </CardDescription>
                    </div>
                    {leave ? (
                        <Badge
                            variant="outline"
                            className="border-success/30 bg-success/10 text-success"
                        >
                            <CalendarCheck2 className="size-3" />
                            {t('Approved')}
                        </Badge>
                    ) : null}
                </div>
            </CardHeader>
            <CardContent>
                {leave === null ? (
                    <Alert className="border-border/80 bg-muted/20">
                        <CalendarCheck2 className="text-muted-foreground size-4" />
                        <AlertTitle>
                            {t('No approved Leave scheduled')}
                        </AlertTitle>
                        <AlertDescription>
                            {t(
                                'There is no approved Regular Leave currently in progress or scheduled.',
                            )}
                        </AlertDescription>
                    </Alert>
                ) : (
                    <div className="space-y-5">
                        <p className="text-foreground text-base font-semibold">
                            {leave.leaveType?.name ??
                                t('Leave type unavailable')}
                        </p>
                        <dl className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <Detail
                                label={t('From')}
                                value={formatDashboardDate(
                                    leave.startDate,
                                    i18n.language,
                                )}
                            />
                            <Detail
                                label={t('To')}
                                value={formatDashboardDate(
                                    leave.endDate,
                                    i18n.language,
                                )}
                            />
                            <Detail
                                label={t('Duration')}
                                value={`${formatDashboardNumber(leave.durationDays, i18n.language)} ${t('days')}`}
                            />
                        </dl>
                    </div>
                )}
            </CardContent>
        </Card>
    );
}

function Detail({ label, value }: { label: string; value: string | null }) {
    const { t } = useTranslation();

    return (
        <div>
            <dt className="text-muted-foreground text-xs font-medium tracking-wider uppercase">
                {label}
            </dt>
            <dd className="text-foreground mt-1 text-sm font-semibold">
                {value ?? t('Not available')}
            </dd>
        </div>
    );
}
