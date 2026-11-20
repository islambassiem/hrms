import { AlertTriangle, CalendarCheck2, Inbox, UsersRound } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { HRDashboardMetrics } from '@/types/hr-dashboard';

function formatCount(value: number | null, locale: string): string {
    return value === null ? '—' : new Intl.NumberFormat(locale).format(value);
}

export function HRDashboardMetricCards({
    metrics,
}: {
    metrics: HRDashboardMetrics | null;
}) {
    const { i18n, t } = useTranslation();
    const totalActiveEmployees = metrics?.totalActiveEmployees ?? null;
    const cards = [
        {
            label: 'Pending requests',
            value: formatCount(metrics?.pendingRequests ?? null, i18n.language),
            detail:
                metrics === null || metrics.pendingRequests === null
                    ? t('Pending request count is not available yet.')
                    : t('Requests with a pending status.'),
            icon: AlertTriangle,
        },
        {
            label: 'Employees Away Today',
            value: formatCount(
                metrics?.employeesAwayToday ?? null,
                i18n.language,
            ),
            detail:
                metrics === null || metrics.employeesAwayToday === null
                    ? t('Employee absence count is not available yet.')
                    : t('Employees on approved Leave today.'),
            icon: CalendarCheck2,
        },
        {
            label: 'New Requests',
            value: formatCount(metrics?.newRequests ?? null, i18n.language),
            detail:
                metrics === null || metrics.newRequests === null
                    ? t('New request count is not available yet.')
                    : t('Requests submitted in the selected period.'),
            icon: Inbox,
        },
        {
            label: 'Total Active Employees',
            value: formatCount(
                totalActiveEmployees?.total ?? null,
                i18n.language,
            ),
            detail:
                totalActiveEmployees === null
                    ? t('Employee count is not available yet.')
                    : t('Male: {{male}} · Female: {{female}}', {
                          male: formatCount(
                              totalActiveEmployees.male,
                              i18n.language,
                          ),
                          female: formatCount(
                              totalActiveEmployees.female,
                              i18n.language,
                          ),
                      }),
            icon: UsersRound,
        },
    ] as const;

    return (
        <section
            aria-label={t('HR workforce metrics')}
            className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4"
        >
            {cards.map(({ detail, icon: Icon, label, value }) => (
                <Card
                    key={label}
                    className="border-border/80 bg-sidebar shadow-xs"
                >
                    <CardHeader className="flex-row items-start justify-between gap-4">
                        <CardTitle className="text-muted-foreground text-sm font-medium">
                            {t(label)}
                        </CardTitle>
                        <span className="bg-muted text-muted-foreground flex size-10 shrink-0 items-center justify-center rounded-lg">
                            <Icon className="size-5" aria-hidden="true" />
                        </span>
                    </CardHeader>
                    <CardContent className="space-y-1">
                        <p className="text-foreground text-3xl font-semibold tabular-nums">
                            {value}
                        </p>
                        <p className="text-muted-foreground text-sm">
                            {detail}
                        </p>
                    </CardContent>
                </Card>
            ))}
        </section>
    );
}
