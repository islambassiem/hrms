import type { HeadRequestStatus } from '@/types/head';

export function formatHeadDate(value: string, locale: string): string {
    const date = new Date(`${value}T00:00:00Z`);

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return new Intl.DateTimeFormat(locale, { dateStyle: 'medium' }).format(
        date,
    );
}

export function headRequestStatusTone(
    status: HeadRequestStatus,
): 'success' | 'warning' | 'destructive' | 'muted' {
    switch (status) {
        case 'approved':
            return 'success';
        case 'pending':
            return 'warning';
        case 'rejected':
            return 'destructive';
        case 'cancelled':
            return 'muted';
    }
}
