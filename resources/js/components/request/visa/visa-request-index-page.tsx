import { Link, router } from '@inertiajs/react';
import {
    CalendarDays,
    FileText,
    MoreHorizontal,
    Pencil,
    Plus,
    Trash2,
} from 'lucide-react';
import { useState } from 'react';
import { useTranslation } from 'react-i18next';

import { VisaRequestFormSheet } from '@/components/request/visa/visa-request-form-sheet';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { destroy } from '@/routes/visas';
import type {
    EmployeeVisaRequest,
    PaginatedEmployeeVisaRequests,
} from '@/types';

type VisaRequestIndexPageProps = {
    initialForm: {
        mode: 'create' | 'edit' | null;
        visa: EmployeeVisaRequest | null;
    };
    visas: PaginatedEmployeeVisaRequests;
};

export function VisaRequestIndexPage({
    initialForm,
    visas,
}: VisaRequestIndexPageProps) {
    const { i18n, t } = useTranslation();
    const [isFormOpen, setIsFormOpen] = useState(initialForm.mode !== null);
    const [visaToEdit, setVisaToEdit] = useState<EmployeeVisaRequest | null>(
        initialForm.mode === 'edit' ? initialForm.visa : null,
    );
    const [visaToDelete, setVisaToDelete] =
        useState<EmployeeVisaRequest | null>(null);

    const openCreateForm = () => {
        setVisaToEdit(null);
        setIsFormOpen(true);
    };

    const openEditForm = (visa: EmployeeVisaRequest) => {
        setVisaToEdit(visa);
        setIsFormOpen(true);
    };

    const closeForm = (open: boolean) => {
        setIsFormOpen(open);

        if (!open) {
            setVisaToEdit(null);
        }
    };

    const deleteVisa = () => {
        if (!visaToDelete) {
            return;
        }

        router.delete(destroy(visaToDelete).url, {
            preserveScroll: true,
            onFinish: () => setVisaToDelete(null),
        });
    };

    return (
        <div
            dir={i18n.dir()}
            className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6"
        >
            <header className="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div className="space-y-1">
                    <h1 className="text-foreground text-xl font-semibold tracking-tight">
                        {t('Visa requests')}
                    </h1>
                    <p className="text-muted-foreground text-sm">
                        {t('Request and manage your exit re-entry visas.')}
                    </p>
                </div>
                <Button className="w-full sm:w-auto" onClick={openCreateForm}>
                    <Plus className="size-4" />
                    {t('New visa request')}
                </Button>
            </header>

            {visas.data.length === 0 ? (
                <EmptyVisaRequests onCreate={openCreateForm} />
            ) : (
                <Card className="border-border/80 bg-sidebar shadow-xs">
                    <CardHeader>
                        <CardTitle>{t('Your visa requests')}</CardTitle>
                        <CardDescription>
                            {t('Pending requests can be updated or deleted.')}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <ul className="divide-border overflow-hidden rounded-lg border">
                            {visas.data.map((visa) => (
                                <VisaRequestListItem
                                    key={visa.id}
                                    visa={visa}
                                    onDelete={setVisaToDelete}
                                    onEdit={openEditForm}
                                />
                            ))}
                        </ul>
                        <Pagination visas={visas} />
                    </CardContent>
                </Card>
            )}

            <VisaRequestFormSheet
                key={visaToEdit?.id ?? 'new'}
                visa={visaToEdit}
                open={isFormOpen}
                onOpenChange={closeForm}
            />
            <DeleteVisaRequestDialog
                visa={visaToDelete}
                onConfirm={deleteVisa}
                onOpenChange={(open) => {
                    if (!open) {
                        setVisaToDelete(null);
                    }
                }}
            />
        </div>
    );
}

function EmptyVisaRequests({ onCreate }: { onCreate: () => void }) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardContent className="flex flex-col items-center gap-3 py-12 text-center">
                <div className="bg-muted text-muted-foreground flex size-12 items-center justify-center rounded-lg">
                    <FileText className="size-6" />
                </div>
                <div className="space-y-1">
                    <p className="text-foreground font-medium">
                        {t('No visa requests yet')}
                    </p>
                    <p className="text-muted-foreground max-w-sm text-sm">
                        {t(
                            'Create a visa request when you need an exit re-entry visa.',
                        )}
                    </p>
                </div>
                <Button onClick={onCreate}>
                    <Plus className="size-4" />
                    {t('New visa request')}
                </Button>
            </CardContent>
        </Card>
    );
}

function VisaRequestListItem({
    onDelete,
    onEdit,
    visa,
}: {
    onDelete: (visa: EmployeeVisaRequest) => void;
    onEdit: (visa: EmployeeVisaRequest) => void;
    visa: EmployeeVisaRequest;
}) {
    const { i18n, t } = useTranslation();
    const isPending = visa.status === 'pending';

    return (
        <li className="flex flex-col gap-4 p-4 sm:flex-row sm:items-start sm:justify-between">
            <div className="min-w-0 space-y-2">
                <div className="flex flex-wrap items-center gap-2">
                    <p className="text-foreground font-medium">
                        {t('Visa request')}
                    </p>
                    <VisaStatusBadge status={visa.status} />
                </div>
                <div className="text-muted-foreground flex flex-wrap items-center gap-x-4 gap-y-1 text-sm">
                    <span className="inline-flex items-center gap-2">
                        <CalendarDays className="size-4" />
                        {formatVisaDateRange(
                            visa.start_date,
                            visa.end_date,
                            i18n.language,
                        )}
                    </span>
                    <span>
                        {t('Visa year: {{year}}', { year: visa.for_year })}
                    </span>
                </div>
                <div className="text-muted-foreground flex flex-wrap gap-x-4 gap-y-1 text-sm">
                    <span>
                        {t('Payment: {{payment}}', {
                            payment: visaPaymentLabel(visa.payment, t),
                        })}
                    </span>
                    <span>
                        {t('Payer: {{payer}}', {
                            payer: visaPayerLabel(visa.payer, t),
                        })}
                    </span>
                </div>
            </div>
            {isPending ? (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button
                            variant="ghost"
                            size="icon"
                            aria-label={t('Request actions')}
                        >
                            <MoreHorizontal className="size-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem onSelect={() => onEdit(visa)}>
                            <Pencil className="size-4" />
                            {t('Edit')}
                        </DropdownMenuItem>
                        <DropdownMenuItem
                            variant="destructive"
                            onSelect={() => onDelete(visa)}
                        >
                            <Trash2 className="size-4" />
                            {t('Delete')}
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            ) : null}
        </li>
    );
}

function VisaStatusBadge({
    status,
}: {
    status: EmployeeVisaRequest['status'];
}) {
    const { t } = useTranslation();
    const variant = status === 'pending' ? 'outline' : 'secondary';

    return <Badge variant={variant}>{visaStatusLabel(status, t)}</Badge>;
}

function Pagination({ visas }: { visas: PaginatedEmployeeVisaRequests }) {
    const { t } = useTranslation();

    if (visas.meta.last_page <= 1) {
        return null;
    }

    return (
        <nav
            aria-label={t('Visa request pagination')}
            className="flex items-center justify-between gap-4"
        >
            {visas.links.prev ? (
                <Button asChild variant="outline">
                    <Link href={visas.links.prev}>{t('Previous')}</Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Previous')}
                </Button>
            )}
            <p className="text-muted-foreground text-sm">
                {t('Page {{current}} of {{total}}', {
                    current: visas.meta.current_page,
                    total: visas.meta.last_page,
                })}
            </p>
            {visas.links.next ? (
                <Button asChild variant="outline">
                    <Link href={visas.links.next}>{t('Next')}</Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Next')}
                </Button>
            )}
        </nav>
    );
}

function DeleteVisaRequestDialog({
    onConfirm,
    onOpenChange,
    visa,
}: {
    onConfirm: () => void;
    onOpenChange: (open: boolean) => void;
    visa: EmployeeVisaRequest | null;
}) {
    const { t } = useTranslation();

    return (
        <Dialog open={visa !== null} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>{t('Delete visa request')}</DialogTitle>
                    <DialogDescription>
                        {t(
                            'This will permanently delete your pending visa request.',
                        )}
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button
                        variant="outline"
                        onClick={() => onOpenChange(false)}
                    >
                        {t('Cancel')}
                    </Button>
                    <Button variant="destructive" onClick={onConfirm}>
                        {t('Delete request')}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}

function formatVisaDateRange(
    startDate: string,
    endDate: string,
    language: string,
): string {
    const formatter = new Intl.DateTimeFormat(
        language === 'ar' ? 'ar-SA' : 'en-US',
        {
            dateStyle: 'medium',
            timeZone: 'UTC',
        },
    );

    return `${formatter.format(new Date(`${startDate}T00:00:00Z`))} – ${formatter.format(new Date(`${endDate}T00:00:00Z`))}`;
}

function visaStatusLabel(
    status: EmployeeVisaRequest['status'],
    t: (key: string) => string,
): string {
    const labels: Record<EmployeeVisaRequest['status'], string> = {
        issued: t('Issued'),
        pending: t('Pending'),
        processing: t('Processing'),
    };

    return labels[status];
}

function visaPaymentLabel(
    payment: EmployeeVisaRequest['payment'],
    t: (key: string) => string,
): string {
    const labels: Record<EmployeeVisaRequest['payment'], string> = {
        paid: t('Paid'),
        pending: t('Pending'),
        processing: t('Processing'),
    };

    return labels[payment];
}

function visaPayerLabel(
    payer: EmployeeVisaRequest['payer'],
    t: (key: string) => string,
): string {
    return payer === 'company' ? t('Company') : t('Employee');
}
