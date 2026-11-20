import { useState } from 'react';
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
import type {
    HRDashboardActionCenter,
    HRDashboardActionRequest,
    HRDashboardRequestType,
} from '@/types/hr-dashboard';

type RequestTab = 'all' | HRDashboardRequestType;

const requestTypes: HRDashboardRequestType[] = [
    'leave',
    'shortLeave',
    'letter',
    'familyVisit',
    'visa',
];

function requestTypeLabel(type: HRDashboardRequestType): string {
    const labels: Record<HRDashboardRequestType, string> = {
        leave: 'Leaves',
        shortLeave: 'Short Leaves',
        letter: 'Letters',
        familyVisit: 'Family Visits',
        visa: 'Visas',
    };

    return labels[type];
}

function formattedDate(value: string, locale: string): string {
    const timestamp = Date.parse(value);

    if (Number.isNaN(timestamp)) {
        return value;
    }

    return new Intl.DateTimeFormat(locale, {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(timestamp);
}

function RequestActions({ request }: { request: HRDashboardActionRequest }) {
    const { t } = useTranslation();

    return (
        <div className="flex flex-wrap gap-2">
            <Button
                aria-label={t('Approve request from {{name}}', {
                    name: request.employeeName,
                })}
                disabled
                size="sm"
                variant="outline"
            >
                {t('Approve')}
            </Button>
            <Button
                aria-label={t('Reject request from {{name}}', {
                    name: request.employeeName,
                })}
                disabled
                size="sm"
                variant="outline"
            >
                {t('Reject')}
            </Button>
            <Button
                aria-label={t('View request from {{name}}', {
                    name: request.employeeName,
                })}
                disabled
                size="sm"
                variant="ghost"
            >
                {t('View details')}
            </Button>
        </div>
    );
}

function AgingBadge({ olderThan48Hours }: { olderThan48Hours: boolean }) {
    const { t } = useTranslation();

    if (!olderThan48Hours) {
        return null;
    }

    return (
        <Badge className="border-warning/40 bg-warning/10 text-warning">
            {t('Pending over 48 hours')}
        </Badge>
    );
}

function RequestRow({
    request,
    locale,
}: {
    request: HRDashboardActionRequest;
    locale: string;
}) {
    const { t } = useTranslation();

    return (
        <tr className="border-border border-b last:border-0">
            <td className="px-4 py-3 align-top">
                <div className="text-foreground font-medium">
                    {request.employeeName}
                </div>
                <div className="text-muted-foreground text-sm">
                    {request.companyName}
                </div>
            </td>
            <td className="px-4 py-3 align-top">
                {t(requestTypeLabel(request.requestType))}
            </td>
            <td className="px-4 py-3 align-top">
                {formattedDate(request.submittedAt, locale)}
            </td>
            <td className="px-4 py-3 align-top">
                <div className="flex flex-col items-start gap-2">
                    <Badge variant="outline">{request.statusLabel}</Badge>
                    <AgingBadge olderThan48Hours={request.isOlderThan48Hours} />
                </div>
            </td>
            <td className="px-4 py-3 align-top">
                <RequestActions request={request} />
            </td>
        </tr>
    );
}

function RequestCard({
    request,
    locale,
}: {
    request: HRDashboardActionRequest;
    locale: string;
}) {
    const { t } = useTranslation();

    return (
        <article className="border-border bg-card rounded-lg border p-4">
            <div className="flex flex-wrap items-start justify-between gap-3">
                <div className="min-w-0">
                    <h3 className="text-foreground truncate font-medium">
                        {request.employeeName}
                    </h3>
                    <p className="text-muted-foreground text-sm">
                        {request.companyName}
                    </p>
                </div>
                <Badge variant="outline">
                    {t(requestTypeLabel(request.requestType))}
                </Badge>
            </div>
            <dl className="mt-4 grid grid-cols-2 gap-3 text-sm">
                <div>
                    <dt className="text-muted-foreground">{t('Submitted')}</dt>
                    <dd className="text-foreground mt-1">
                        {formattedDate(request.submittedAt, locale)}
                    </dd>
                </div>
                <div>
                    <dt className="text-muted-foreground">{t('Status')}</dt>
                    <dd className="mt-1">
                        <Badge variant="outline">{request.statusLabel}</Badge>
                    </dd>
                </div>
            </dl>
            {request.isOlderThan48Hours ? (
                <div className="mt-3">
                    <AgingBadge olderThan48Hours />
                </div>
            ) : null}
            <div className="border-border mt-4 border-t pt-4">
                <RequestActions request={request} />
            </div>
        </article>
    );
}

export function HRActionCenterCard({
    actionCenter,
}: {
    actionCenter: HRDashboardActionCenter | null;
}) {
    const { i18n, t } = useTranslation();
    const [activeTab, setActiveTab] = useState<RequestTab>('all');
    const available = actionCenter?.status === 'available';
    const requests = available ? actionCenter.requests : [];
    const filteredRequests =
        activeTab === 'all'
            ? requests
            : requests.filter((request) => request.requestType === activeTab);

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <CardTitle>{t('Action Center')}</CardTitle>
                <CardDescription>
                    {t('Review pending requests across employee services.')}
                </CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
                <div
                    aria-label={t('Filter requests by type')}
                    className="flex flex-wrap gap-2"
                    role="group"
                >
                    {(['all', ...requestTypes] as const).map((tab) => (
                        <Button
                            key={tab}
                            aria-pressed={activeTab === tab}
                            onClick={() => setActiveTab(tab)}
                            size="sm"
                            type="button"
                            variant={
                                activeTab === tab ? 'secondary' : 'outline'
                            }
                        >
                            {t(tab === 'all' ? 'All' : requestTypeLabel(tab))}
                        </Button>
                    ))}
                </div>

                {!available ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-6 text-center text-sm">
                        {t('Pending request data is not available yet.')}
                    </p>
                ) : filteredRequests.length === 0 ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-6 text-center text-sm">
                        {t('No pending requests in this category.')}
                    </p>
                ) : (
                    <>
                        <div className="hidden overflow-x-auto lg:block">
                            <table className="w-full min-w-[48rem] text-start text-sm">
                                <caption className="sr-only">
                                    {t('Pending employee requests')}
                                </caption>
                                <thead className="text-muted-foreground border-border border-b text-xs uppercase">
                                    <tr>
                                        <th
                                            className="px-4 py-3 font-medium"
                                            scope="col"
                                        >
                                            {t('Employee and company')}
                                        </th>
                                        <th
                                            className="px-4 py-3 font-medium"
                                            scope="col"
                                        >
                                            {t('Request type')}
                                        </th>
                                        <th
                                            className="px-4 py-3 font-medium"
                                            scope="col"
                                        >
                                            {t('Date submitted')}
                                        </th>
                                        <th
                                            className="px-4 py-3 font-medium"
                                            scope="col"
                                        >
                                            {t('Status')}
                                        </th>
                                        <th
                                            className="px-4 py-3 font-medium"
                                            scope="col"
                                        >
                                            {t('Quick actions')}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {filteredRequests.map((request) => (
                                        <RequestRow
                                            key={`${request.requestType}:${request.id}`}
                                            locale={i18n.language}
                                            request={request}
                                        />
                                    ))}
                                </tbody>
                            </table>
                        </div>
                        <div className="space-y-3 lg:hidden">
                            {filteredRequests.map((request) => (
                                <RequestCard
                                    key={`${request.requestType}:${request.id}`}
                                    locale={i18n.language}
                                    request={request}
                                />
                            ))}
                        </div>
                        <p className="text-muted-foreground text-xs">
                            {t(
                                'Request actions and details are not available on this dashboard yet.',
                            )}
                        </p>
                    </>
                )}
            </CardContent>
        </Card>
    );
}
