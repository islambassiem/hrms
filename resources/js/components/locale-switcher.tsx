import { Button } from '@/components/ui/button';
import { persistLocale } from '@/components/locale-sync';
import saFlag from '../../../public/svg/sa.svg';
import usFlag from '../../../public/svg/us.svg';
import { router, usePage } from '@inertiajs/react';
import { update as updateLocale } from '@/routes/locale';
import type { SharedData } from '@/types';

const LanguageSwitcher = () => {
    const { locale } = usePage<SharedData>().props;

    const currentLocale = locale === 'ar' ? 'ar' : 'en';
    const nextLocale = currentLocale === 'en' ? 'ar' : 'en';

    const changeLocale = (lang: string) => {
        if (lang === currentLocale) {
            return;
        }

        persistLocale(lang);

        router.flushAll();

        router.post(
            updateLocale.url(lang),
            {},
            {
                preserveScroll: true,
                preserveState: false,
                onSuccess: () => {
                    router.flushAll();
                },
            },
        );
    };

    return (
        <Button
            onClick={() => changeLocale(nextLocale)}
            variant="ghost"
            size="icon"
            className="text-muted-foreground hover:bg-muted/70 hover:text-foreground size-9 shrink-0 rounded-lg transition-colors"
            aria-label={
                nextLocale === 'ar' ? 'Switch to Arabic' : 'Switch to English'
            }
        >
            <img
                src={nextLocale === 'ar' ? saFlag : usFlag}
                alt="Switch Language Flag"
                className="size-6"
            />
        </Button>
    );
};

export default LanguageSwitcher;
