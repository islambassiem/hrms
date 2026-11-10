import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';

import { Button } from '@/components/ui/button';
import type { HeadPageLinkSet, HeadPageMeta } from '@/types/head';

export function HeadRequestPagination({
    links,
    meta,
}: {
    links: HeadPageLinkSet;
    meta: HeadPageMeta;
}) {
    const { t } = useTranslation();

    if (meta.last_page <= 1) {
        return null;
    }

    return (
        <nav
            aria-label={t('Department request pagination')}
            className="flex flex-wrap items-center justify-between gap-3"
        >
            {links.prev ? (
                <Button asChild variant="outline">
                    <Link href={links.prev} preserveScroll>
                        {t('Previous')}
                    </Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Previous')}
                </Button>
            )}
            <p className="text-muted-foreground text-sm">
                {t('Page {{current}} of {{total}}', {
                    current: meta.current_page,
                    total: meta.last_page,
                })}
            </p>
            {links.next ? (
                <Button asChild variant="outline">
                    <Link href={links.next} preserveScroll>
                        {t('Next')}
                    </Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Next')}
                </Button>
            )}
        </nav>
    );
}
