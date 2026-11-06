import { useTranslation } from 'react-i18next';

import { StatusBadge } from '@/components/leave/status-badge';
import { headRequestStatusTone } from './head-page-formatters';
import type { HeadRequestStatus } from '@/types/head';

export function HeadRequestStatusBadge({
    status,
}: {
    status: HeadRequestStatus;
}) {
    const { t } = useTranslation();

    return (
        <StatusBadge tone={headRequestStatusTone(status)}>
            {t(`Leave status ${status}`)}
        </StatusBadge>
    );
}
