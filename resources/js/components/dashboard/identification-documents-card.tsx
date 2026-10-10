import { FileText } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type { EmployeeDashboardIdentification } from '@/types';

import { formatDashboardDate } from './formatters';

type IdentificationDocumentsCardProps = {
    identifications: EmployeeDashboardIdentification[];
};

export function IdentificationDocumentsCard({
    identifications,
}: IdentificationDocumentsCardProps) {
    const { t, i18n } = useTranslation();

    return (
        <Card
            dir={i18n.dir()}
            className="border-border/80 bg-sidebar shadow-xs"
        >
            <CardHeader>
                <CardTitle>{t('Identification documents')}</CardTitle>
                <CardDescription>
                    {t('Personal identification and expiry dates')}
                </CardDescription>
            </CardHeader>
            <CardContent>
                {identifications.length === 0 ? (
                    <EmptyDocumentsState />
                ) : (
                    <dl className="divide-border divide-y">
                        {identifications.map((identification) => (
                            <div
                                key={identification.id}
                                className="flex items-center justify-between gap-4 py-3.5 first:pt-0 last:pb-0"
                            >
                                <div className="min-w-0">
                                    <dt className="text-foreground text-sm font-medium">
                                        {identification.type ??
                                            t('Identification document')}
                                    </dt>
                                </div>
                                <dd className="text-muted-foreground shrink-0 text-end text-xs font-medium">
                                    <span className="block">
                                        {t('Expires')}
                                    </span>
                                    <span className="text-foreground mt-0.5 block">
                                        {formatDashboardDate(
                                            identification.expiryDate,
                                            i18n.language,
                                        ) ?? t('No expiry date')}
                                    </span>
                                </dd>
                            </div>
                        ))}
                    </dl>
                )}
            </CardContent>
        </Card>
    );
}

function EmptyDocumentsState() {
    const { t } = useTranslation();

    return (
        <div className="flex flex-col items-center gap-2 py-6 text-center">
            <div className="bg-muted text-muted-foreground flex size-10 items-center justify-center rounded-lg">
                <FileText className="size-5" />
            </div>
            <p className="text-foreground text-sm font-medium">
                {t('No identification documents')}
            </p>
            <p className="text-muted-foreground max-w-sm text-xs">
                {t(
                    'There are no identification documents recorded for your profile.',
                )}
            </p>
        </div>
    );
}
