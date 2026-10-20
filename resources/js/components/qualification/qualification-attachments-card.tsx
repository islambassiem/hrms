import { FileText, Paperclip, Trash2, X } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { QualificationAttachment } from '@/types';

type QualificationAttachmentsCardProps = {
    attachments: File[];
    attachmentError?: string;
    existingAttachments?: QualificationAttachment[];
    inputKey: number;
    disabled?: boolean;
    removingAttachmentId?: number | null;
    getAttachmentError: (index: number) => string | undefined;
    onAttachmentsChange: (attachments: File[]) => void;
    onRemoveSelectedAttachment: (index: number) => void;
    onRemoveExistingAttachment?: (attachment: QualificationAttachment) => void;
};

export function QualificationAttachmentsCard({
    attachments,
    attachmentError,
    existingAttachments,
    inputKey,
    disabled = false,
    removingAttachmentId = null,
    getAttachmentError,
    onAttachmentsChange,
    onRemoveSelectedAttachment,
    onRemoveExistingAttachment,
}: QualificationAttachmentsCardProps) {
    const { t } = useTranslation();
    const hasExistingAttachments = existingAttachments !== undefined;

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
                            {t(
                                'Add documents that support this qualification.',
                            )}
                        </CardDescription>
                    </div>
                </div>
            </CardHeader>
            <CardContent className="space-y-5">
                {hasExistingAttachments ? (
                    <section
                        aria-labelledby="qualification-existing-attachments"
                        className="space-y-3"
                    >
                        <div className="space-y-1">
                            <h2
                                id="qualification-existing-attachments"
                                className="font-medium"
                            >
                                {t('Existing attachments')}
                            </h2>
                            <p className="text-muted-foreground text-sm">
                                {t(
                                    'Remove a document only when it no longer belongs to this qualification.',
                                )}
                            </p>
                        </div>

                        {existingAttachments.length === 0 ? (
                            <p className="text-muted-foreground rounded-md border border-dashed p-3 text-sm">
                                {t('No attachments have been added.')}
                            </p>
                        ) : (
                            <ul className="space-y-2">
                                {existingAttachments.map((attachment) => (
                                    <li
                                        key={attachment.id}
                                        className="border-border/60 flex flex-col gap-3 rounded-md border p-3 sm:flex-row sm:items-center sm:justify-between"
                                    >
                                        <AttachmentMetadata
                                            name={attachment.name}
                                            mimeType={attachment.mime_type}
                                            sizeBytes={attachment.size_bytes}
                                        />
                                        {onRemoveExistingAttachment ? (
                                            <Button
                                                type="button"
                                                variant="outline"
                                                size="sm"
                                                disabled={
                                                    disabled ||
                                                    removingAttachmentId !==
                                                        null
                                                }
                                                onClick={() =>
                                                    onRemoveExistingAttachment(
                                                        attachment,
                                                    )
                                                }
                                            >
                                                <Trash2
                                                    className="size-4"
                                                    aria-hidden="true"
                                                />
                                                {removingAttachmentId ===
                                                attachment.id
                                                    ? t('Removing attachment')
                                                    : t('Remove attachment')}
                                            </Button>
                                        ) : null}
                                    </li>
                                ))}
                            </ul>
                        )}
                    </section>
                ) : null}

                <section
                    aria-labelledby="qualification-new-attachments"
                    className="space-y-3"
                >
                    <div className="space-y-1">
                        <h2
                            id="qualification-new-attachments"
                            className="font-medium"
                        >
                            {t('Add attachments')}
                        </h2>
                        <p className="text-muted-foreground text-sm">
                            {t(
                                'Accepted files: PDF, PNG, JPEG, or JPG up to 3 MB.',
                            )}
                        </p>
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="qualification-attachments">
                            {t('Select attachments')}
                        </Label>
                        <Input
                            key={inputKey}
                            id="qualification-attachments"
                            type="file"
                            accept=".pdf,.png,.jpeg,.jpg"
                            multiple
                            disabled={disabled}
                            aria-invalid={Boolean(
                                attachmentError ||
                                attachments.some((_, index) =>
                                    Boolean(getAttachmentError(index)),
                                ),
                            )}
                            aria-describedby="qualification-attachments-help"
                            onChange={(event) =>
                                onAttachmentsChange(
                                    Array.from(event.target.files ?? []),
                                )
                            }
                        />
                        <p
                            id="qualification-attachments-help"
                            className="text-muted-foreground text-sm"
                        >
                            {t('You can add up to five files.')}
                        </p>
                        <InputError message={attachmentError} />
                    </div>

                    {attachments.length > 0 ? (
                        <ul
                            aria-label={t('Selected attachments')}
                            className="space-y-2"
                        >
                            {attachments.map((attachment, index) => (
                                <li
                                    key={`${attachment.name}-${attachment.lastModified}-${index}`}
                                    className="border-border/60 flex flex-col gap-3 rounded-md border p-3 sm:flex-row sm:items-center sm:justify-between"
                                >
                                    <AttachmentMetadata
                                        name={attachment.name}
                                        sizeBytes={attachment.size}
                                    />
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        disabled={disabled}
                                        onClick={() =>
                                            onRemoveSelectedAttachment(index)
                                        }
                                    >
                                        <X
                                            className="size-4"
                                            aria-hidden="true"
                                        />
                                        {t('Remove')}
                                    </Button>
                                    <InputError
                                        message={getAttachmentError(index)}
                                    />
                                </li>
                            ))}
                        </ul>
                    ) : null}
                </section>
            </CardContent>
        </Card>
    );
}

function AttachmentMetadata({
    name,
    sizeBytes,
    mimeType,
}: {
    name: string;
    sizeBytes: number;
    mimeType?: string | null;
}) {
    const { t, i18n } = useTranslation();
    const size = new Intl.NumberFormat(i18n.language, {
        style: 'unit',
        unit: 'kilobyte',
        maximumFractionDigits: 1,
    }).format(sizeBytes / 1024);

    return (
        <div className="flex min-w-0 items-start gap-3">
            <FileText
                className="text-muted-foreground mt-0.5 size-4 shrink-0"
                aria-hidden="true"
            />
            <div className="min-w-0 space-y-1">
                <p className="text-foreground truncate text-sm font-medium">
                    {name}
                </p>
                <p className="text-muted-foreground text-sm">
                    {mimeType
                        ? t('{{size}} · {{type}}', {
                              size,
                              type: mimeType,
                          })
                        : size}
                </p>
            </div>
        </div>
    );
}
