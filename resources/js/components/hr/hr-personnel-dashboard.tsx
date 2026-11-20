import { useTranslation } from 'react-i18next';

import { HRActionCenterCard } from '@/components/hr/hr-action-center-card';
import { HRCompanyScopeFilter } from '@/components/hr/hr-company-scope-filter';
import {
    HRDashboardInsights,
    HRRecentQualificationsCard,
    HRUpcomingLeaveCard,
} from '@/components/hr/hr-dashboard-insights';
import { HRDashboardMetricCards } from '@/components/hr/hr-dashboard-metric-cards';
import type {
    HRCompanyScopeOption,
    HRDashboardData,
} from '@/types/hr-dashboard';

export function HRPersonnelDashboard({
    data,
    onCompanyScopeChange,
}: {
    data: HRDashboardData | null;
    onCompanyScopeChange?: (scope: HRCompanyScopeOption) => void;
}) {
    const { i18n, t } = useTranslation();

    return (
        <main
            dir={i18n.dir()}
            className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6"
        >
            <div className="grid items-end gap-4 lg:grid-cols-[minmax(0,1fr)_20rem]">
                <header className="space-y-1">
                    <h1 className="text-foreground text-xl font-semibold tracking-tight">
                        {t('HR Personnel Dashboard')}
                    </h1>
                    <p className="text-muted-foreground text-sm">
                        {t(
                            'Workforce availability, pending work, and company operations.',
                        )}
                    </p>
                </header>
                <HRCompanyScopeFilter
                    filter={data?.companyScope ?? null}
                    onScopeChange={onCompanyScopeChange}
                />
            </div>

            <HRDashboardMetricCards metrics={data?.metrics ?? null} />

            <section className="grid gap-4 xl:grid-cols-[minmax(0,7fr)_minmax(18rem,3fr)]">
                <HRActionCenterCard actionCenter={data?.actionCenter ?? null} />
                <div className="grid content-start gap-4">
                    <HRUpcomingLeaveCard
                        data={data?.upcomingLeaves ?? null}
                        locale={i18n.language}
                    />
                    <HRRecentQualificationsCard
                        data={data?.recentQualifications ?? null}
                        locale={i18n.language}
                    />
                </div>
            </section>

            <HRDashboardInsights
                companyComparison={data?.companyComparison ?? null}
                requestsBreakdown={data?.requestsBreakdown ?? null}
            />
        </main>
    );
}
