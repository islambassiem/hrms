import { Clock3 } from 'lucide-react';
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

type PendingRegularLeaveRequestsCardProps = {
    requests: EmployeeDashboardLeaveRequest[];
};

export function PendingRegularLeaveRequestsCard({
    requests,
}: PendingRegularLeaveRequestsCardProps) {
    const { t, i18n } = useTranslation();

    return (
        <Card
            dir={i18n.dir()}
            className="border-border/80 bg-sidebar shadow-xs"
        >
            <CardHeader className="flex-row items-start justify-between gap-4">
                <div className="space-y-1.5">
                    <CardTitle>{t('Pending leave requests')}</CardTitle>
                    <CardDescription>
                        {t('Regular Leave requests awaiting final approval')}
                    </CardDescription>
                </div>
                <Badge
                    variant="outline"
                    className="border-warning/30 bg-warning/10 text-warning"
                    aria-label={`${t('Pending leave requests')}: ${formatDashboardNumber(requests.length, i18n.language)}`}
                >
                    {formatDashboardNumber(requests.length, i18n.language)}
                </Badge>
            </CardHeader>
            <CardContent>
                {requests.length === 0 ? (
                    <Alert className="border-border/80 bg-muted/20">
                        <Clock3 className="text-muted-foreground size-4" />
                        <AlertTitle>
                            {t('No pending Leave requests')}
                        </AlertTitle>
                        <AlertDescription>
                            {t(
                                'No Regular Leave requests are awaiting final approval.',
                            )}
                        </AlertDescription>
                    </Alert>
                ) : (
                    <ul className="divide-border divide-y">
                        {requests.map((request) => (
                            <li
                                key={request.id}
                                className="flex flex-col gap-3 py-3.5 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between"
                            >
                                <div className="min-w-0 text-start">
                                    <p className="text-foreground truncate text-sm font-semibold">
                                        {request.leaveType?.name ??
                                            t('Leave type unavailable')}
                                    </p>
                                    <p className="text-muted-foreground mt-1 text-xs">
                                        {formatDashboardDate(
                                            request.startDate,
                                            i18n.language,
                                        )}{' '}
                                        –{' '}
                                        {formatDashboardDate(
                                            request.endDate,
                                            i18n.language,
                                        )}
                                    </p>
                                </div>
                                <dl className="text-muted-foreground flex shrink-0 items-center gap-3 text-xs sm:text-end">
                                    <div>
                                        <dt className="sr-only">
                                            {t('Duration')}
                                        </dt>
                                        <dd>
                                            {formatDashboardNumber(
                                                request.durationDays,
                                                i18n.language,
                                            )}{' '}
                                            {t('days')}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt className="sr-only">
                                            {t('Submitted')}
                                        </dt>
                                        <dd>
                                            {t('Submitted')}{' '}
                                            {formatDashboardDate(
                                                request.submittedDate,
                                                i18n.language,
                                            )}
                                        </dd>
                                    </div>
                                </dl>
                            </li>
                        ))}
                    </ul>
                )}
            </CardContent>
        </Card>
    );
}
