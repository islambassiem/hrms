export function formatQualificationDate(
    value: string | null,
    locale: string,
    unavailableLabel: string,
): string {
    if (value === null) {
        return unavailableLabel;
    }

    return new Intl.DateTimeFormat(locale, {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(new Date(`${value}T00:00:00`));
}
