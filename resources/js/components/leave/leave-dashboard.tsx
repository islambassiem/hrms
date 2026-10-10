import { CircleAlert } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Skeleton } from '@/components/ui/skeleton';
import type { LeavePageState } from '@/types';

import { LeaveSummaryCards } from './leave-summary-cards';

type LeaveDashboardProps = {
    state: LeavePageState;
    onApplyForLeave?: () => void;
    onViewHistory?: () => void;
    onOpenShortLeave?: () => void;
};

function LeaveDashboardLoading() {
    const { t } = useTranslation();

    return (
        <div
            role="status"
            aria-label={t('Loading Leave information')}
            className="space-y-6"
        >
            <div className="space-y-2">
                <Skeleton className="h-8 w-28" />
                <Skeleton className="h-4 w-72" />
            </div>
            <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                {Array.from({ length: 4 }, (_, index) => (
                    <Skeleton key={index} className="h-48" />
                ))}
            </div>
            <Skeleton className="h-64" />
        </div>
    );
}

export function LeaveDashboard({
    state,
    onApplyForLeave,
    onViewHistory,
    onOpenShortLeave,
}: LeaveDashboardProps) {
    const { t, i18n } = useTranslation();

    if (state.status === 'loading') {
        return <LeaveDashboardLoading />;
    }

    if (state.status === 'error') {
        return (
            <Alert dir={i18n.dir()} variant="destructive">
                <CircleAlert aria-hidden="true" />
                <AlertTitle>{t('Leave information is unavailable')}</AlertTitle>
                <AlertDescription>{state.message}</AlertDescription>
            </Alert>
        );
    }

    return (
        <LeaveSummaryCards
            data={state.data}
            onApplyForLeave={onApplyForLeave}
            onViewHistory={onViewHistory}
            onOpenShortLeave={onOpenShortLeave}
        />
    );
}
