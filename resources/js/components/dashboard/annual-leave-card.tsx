import { CalendarDays } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type { EmployeeDashboardAnnualLeaveBalance } from '@/types';

import { formatDashboardDate, formatDashboardNumber } from './formatters';

type AnnualLeaveCardProps = {
    balance: EmployeeDashboardAnnualLeaveBalance | null;
};

export function AnnualLeaveCard({ balance }: AnnualLeaveCardProps) {
    const { t, i18n } = useTranslation();

    return (
        <Card
            dir={i18n.dir()}
            className="border-border/80 bg-sidebar shadow-xs"
        >
            <CardHeader>
                <CardTitle>{t('Annual leave')}</CardTitle>
                <CardDescription>
                    {t('Current balance and usage details')}
                </CardDescription>
            </CardHeader>
            <CardContent>
                {balance === null ? (
                    <Alert className="border-border/80 bg-muted/20">
                        <CalendarDays className="text-muted-foreground size-4" />
                        <AlertTitle>
                            {t('Annual leave balance is not available')}
                        </AlertTitle>
                        <AlertDescription>
                            {t(
                                'Your annual leave balance record is not available.',
                            )}
                        </AlertDescription>
                    </Alert>
                ) : (
                    <div className="space-y-5">
                        <div>
                            <p className="text-muted-foreground text-xs font-medium tracking-wider uppercase">
                                {t('Available days')}
                            </p>
                            <p className="text-foreground mt-1 text-3xl font-bold tracking-tight">
                                {formatDashboardNumber(
                                    balance.availableDays,
                                    i18n.language,
                                )}{' '}
                                <span className="text-muted-foreground text-sm font-medium">
                                    {t('days')}
                                </span>
                            </p>
                        </div>
                        <dl className="grid grid-cols-2 gap-4 sm:grid-cols-4">
                            <Metric
                                label={t('Accrued')}
                                value={formatDashboardNumber(
                                    balance.accruedDays,
                                    i18n.language,
                                )}
                            />
                            <Metric
                                label={t('Used')}
                                value={formatDashboardNumber(
                                    balance.usedDays,
                                    i18n.language,
                                )}
                            />
                            <Metric
                                label={t('Pending')}
                                value={formatDashboardNumber(
                                    balance.pendingDays,
                                    i18n.language,
                                )}
                            />
                            <Metric
                                label={t('Expiring')}
                                value={formatDashboardNumber(
                                    balance.expiringDays,
                                    i18n.language,
                                )}
                            />
                        </dl>
                        <dl className="border-border/80 bg-muted/20 rounded-lg border p-3">
                            <Metric
                                label={t('Next expiry date')}
                                value={
                                    formatDashboardDate(
                                        balance.nextExpiryDate,
                                        i18n.language,
                                    ) ?? t('No upcoming expiry')
                                }
                            />
                        </dl>
                    </div>
                )}
            </CardContent>
        </Card>
    );
}

function Metric({ label, value }: { label: string; value: string }) {
    return (
        <div>
            <dt className="text-muted-foreground text-xs font-medium tracking-wider uppercase">
                {label}
            </dt>
            <dd className="text-foreground mt-1 text-sm font-semibold">
                {value}
            </dd>
        </div>
    );
}
