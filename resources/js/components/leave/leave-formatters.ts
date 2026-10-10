export function formatLeaveDate(
    value: string | null | undefined,
    language: string,
): string | null {
    if (!value) {
        return null;
    }

    return new Intl.DateTimeFormat(language === 'ar' ? 'ar-SA' : 'en-US', {
        dateStyle: 'medium',
        timeZone: 'UTC',
    }).format(new Date(`${value}T00:00:00Z`));
}

export function formatLeaveNumber(value: number, language: string): string {
    return new Intl.NumberFormat(language === 'ar' ? 'ar-SA' : 'en-US', {
        maximumFractionDigits: 2,
    }).format(value);
}

export function formatLeaveTime(value: string, language: string): string {
    const timeParts = value.match(/^(\d{2}):(\d{2})(?::\d{2})?$/);

    if (!timeParts) {
        return value;
    }

    const [, hours, minutes] = timeParts;
    const time = new Date(Date.UTC(1970, 0, 1, Number(hours), Number(minutes)));

    return new Intl.DateTimeFormat(language === 'ar' ? 'ar-SA' : 'en-US', {
        hour: 'numeric',
        minute: '2-digit',
        timeZone: 'UTC',
    }).format(time);
}
