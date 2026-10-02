import { useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import { usePage } from '@inertiajs/react';
import type { SharedData } from '@/types';

export function persistLocale(locale: string): void {
    if (typeof document !== 'undefined') {
        document.documentElement.lang = locale;
        document.documentElement.dir = locale === 'ar' ? 'rtl' : 'ltr';
    }

    if (typeof localStorage !== 'undefined') {
        localStorage.setItem('lang', locale);
    }
}

export default function LocaleSync() {
    const { locale } = usePage<SharedData>().props;
    const { i18n } = useTranslation();

    useEffect(() => {
        if (locale !== i18n.language) {
            void i18n.changeLanguage(locale);
        }

        persistLocale(locale);
    }, [locale, i18n]);

    return null;
}
