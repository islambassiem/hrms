import { FileText, Paperclip } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type { QualificationAttachment } from '@/types';

type QualificationAttachmentListCardProps = {
    attachments: QualificationAttachment[];
};

export function QualificationAttachmentListCard({
    attachments,
}: QualificationAttachmentListCardProps) {
    const { t, i18n } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <div className="flex items-start gap-3">
                    <div className="bg-muted text-muted-foreground flex size-9 shrink-0 items-center justify-center rounded-md">
                        <Paperclip className="size-4" aria-hidden="true" />
                    </div>
                    <div className="space-y-1">
                        <CardTitle>{t('Attachments')}</CardTitle>
                        <CardDescription>
                            {t('Documents attached to this qualification.')}
                        </CardDescription>
                    </div>
                </div>
            </CardHeader>
            <CardContent>
                {attachments.length === 0 ? (
                    <p className="text-muted-foreground rounded-md border border-dashed p-3 text-sm">
                        {t('No attachments have been added.')}
                    </p>
                ) : (
                    <ul className="space-y-2" aria-label={t('Attachments')}>
                        {attachments.map((attachment) => (
                            <li
                                key={attachment.id}
                                className="border-border/60 flex min-w-0 items-start gap-3 rounded-md border p-3"
                            >
                                <FileText
                                    className="text-muted-foreground mt-0.5 size-4 shrink-0"
                                    aria-hidden="true"
                                />
                                <div className="min-w-0 space-y-1">
                                    <p className="text-foreground truncate text-sm font-medium">
                                        {attachment.name}
                                    </p>
                                    <p className="text-muted-foreground text-sm">
                                        {attachment.mime_type
                                            ? t('{{size}} · {{type}}', {
                                                  size: formatAttachmentSize(
                                                      attachment.size_bytes,
                                                      i18n.language,
                                                  ),
                                                  type: attachment.mime_type,
                                              })
                                            : formatAttachmentSize(
                                                  attachment.size_bytes,
                                                  i18n.language,
                                              )}
                                    </p>
                                </div>
                            </li>
                        ))}
                    </ul>
                )}
            </CardContent>
        </Card>
    );
}

function formatAttachmentSize(sizeBytes: number, locale: string): string {
    return new Intl.NumberFormat(locale, {
        style: 'unit',
        unit: 'kilobyte',
        maximumFractionDigits: 1,
    }).format(sizeBytes / 1024);
}
