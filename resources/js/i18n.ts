import ar from '../../lang/ar.json';
import en from '../../lang/en.json';
import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

function resolveInitialLanguage(): string {
    if (typeof document !== 'undefined') {
        const htmlLang = document.documentElement.lang.slice(0, 2);

        if (htmlLang === 'ar' || htmlLang === 'en') {
            return htmlLang;
        }
    }

    if (typeof localStorage !== 'undefined') {
        const stored = localStorage.getItem('lang');

        if (stored === 'ar' || stored === 'en') {
            return stored;
        }
    }

    return 'en';
}

await i18n.use(initReactI18next).init({
    resources: {
        en: { translation: en },
        ar: { translation: ar },
    },
    lng: resolveInitialLanguage(),
    fallbackLng: 'en',
    interpolation: {
        escapeValue: false,
    },
});

export default i18n;
