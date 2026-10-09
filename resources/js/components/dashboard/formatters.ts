export function formatDashboardDate(
    value: string | null,
    language: string,
): string | null {
    if (value === null) {
        return null;
    }

    return new Intl.DateTimeFormat(language === 'ar' ? 'ar-SA' : 'en-US', {
        dateStyle: 'medium',
        timeZone: 'UTC',
    }).format(new Date(`${value}T00:00:00Z`));
}

export function formatDashboardNumber(value: number, language: string): string {
    return new Intl.NumberFormat(language === 'ar' ? 'ar-SA' : 'en-US', {
        maximumFractionDigits: 2,
    }).format(value);
}
