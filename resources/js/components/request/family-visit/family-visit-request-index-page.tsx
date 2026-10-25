import { Link, router } from '@inertiajs/react';
import { FileText, MoreHorizontal, Pencil, Plus, Trash2 } from 'lucide-react';
import { useState } from 'react';
import { useTranslation } from 'react-i18next';

import { FamilyVisitRequestFormSheet } from '@/components/request/family-visit/family-visit-request-form-sheet';
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
import { destroy } from '@/routes/family-visits';
import type {
    EmployeeFamilyVisitRequest,
    PaginatedEmployeeFamilyVisitRequests,
} from '@/types';

type FamilyVisitRequestIndexPageProps = {
    visits: PaginatedEmployeeFamilyVisitRequests;
};

export function FamilyVisitRequestIndexPage({
    visits,
}: FamilyVisitRequestIndexPageProps) {
    const { t, i18n } = useTranslation();
    const [isFormOpen, setIsFormOpen] = useState(false);
    const [visitToEdit, setVisitToEdit] =
        useState<EmployeeFamilyVisitRequest | null>(null);
    const [visitToDelete, setVisitToDelete] =
        useState<EmployeeFamilyVisitRequest | null>(null);

    const openCreateForm = () => {
        setVisitToEdit(null);
        setIsFormOpen(true);
    };

    const openEditForm = (visit: EmployeeFamilyVisitRequest) => {
        setVisitToEdit(visit);
        setIsFormOpen(true);
    };

    const closeForm = (open: boolean) => {
        setIsFormOpen(open);

        if (!open) {
            setVisitToEdit(null);
        }
    };

    const deleteVisit = () => {
        if (!visitToDelete) {
            return;
        }

        router.delete(destroy(visitToDelete).url, {
            preserveScroll: true,
            onFinish: () => setVisitToDelete(null),
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
                        {t('Family visit requests')}
                    </h1>
                    <p className="text-muted-foreground text-sm">
                        {t('Request and manage your family visit requests.')}
                    </p>
                </div>
                <Button className="w-full sm:w-auto" onClick={openCreateForm}>
                    <Plus className="size-4" />
                    {t('New family visit request')}
                </Button>
            </header>

            {visits.data.length === 0 ? (
                <EmptyFamilyVisitRequests onCreate={openCreateForm} />
            ) : (
                <Card className="border-border/80 bg-sidebar shadow-xs">
                    <CardHeader>
                        <CardTitle>{t('Your family visit requests')}</CardTitle>
                        <CardDescription>
                            {t('Pending requests can be updated or deleted.')}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <ul className="divide-border overflow-hidden rounded-lg border">
                            {visits.data.map((visit) => (
                                <FamilyVisitRequestListItem
                                    key={visit.id}
                                    visit={visit}
                                    onDelete={setVisitToDelete}
                                    onEdit={openEditForm}
                                />
                            ))}
                        </ul>
                        <Pagination visits={visits} />
                    </CardContent>
                </Card>
            )}

            <FamilyVisitRequestFormSheet
                key={visitToEdit?.id ?? 'new'}
                visit={visitToEdit}
                open={isFormOpen}
                onOpenChange={closeForm}
            />
            <DeleteFamilyVisitRequestDialog
                visit={visitToDelete}
                onConfirm={deleteVisit}
                onOpenChange={(open) => {
                    if (!open) {
                        setVisitToDelete(null);
                    }
                }}
            />
        </div>
    );
}

function EmptyFamilyVisitRequests({ onCreate }: { onCreate: () => void }) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardContent className="flex flex-col items-center gap-3 py-12 text-center">
                <div className="bg-muted text-muted-foreground flex size-12 items-center justify-center rounded-lg">
                    <FileText className="size-6" />
                </div>
                <div className="space-y-1">
                    <p className="text-foreground font-medium">
                        {t('No family visit requests yet')}
                    </p>
                    <p className="text-muted-foreground max-w-sm text-sm">
                        {t('Create a family visit request when you need one.')}
                    </p>
                </div>
                <Button onClick={onCreate}>
                    <Plus className="size-4" />
                    {t('New family visit request')}
                </Button>
            </CardContent>
        </Card>
    );
}

function FamilyVisitRequestListItem({
    onDelete,
    onEdit,
    visit,
}: {
    onDelete: (visit: EmployeeFamilyVisitRequest) => void;
    onEdit: (visit: EmployeeFamilyVisitRequest) => void;
    visit: EmployeeFamilyVisitRequest;
}) {
    const { t } = useTranslation();
    const isPending = visit.status === 'pending';

    return (
        <li className="flex flex-col gap-4 p-4 sm:flex-row sm:items-start sm:justify-between">
            <div className="min-w-0 space-y-2">
                <div className="flex flex-wrap items-center gap-2">
                    <p className="text-foreground font-medium">
                        {t('Family visit request')}
                    </p>
                    <FamilyVisitStatusBadge status={visit.status} />
                </div>
                <p className="text-muted-foreground text-sm">
                    {t('Request number: {{number}}', { number: visit.number })}
                </p>
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
                        <DropdownMenuItem onSelect={() => onEdit(visit)}>
                            <Pencil className="size-4" />
                            {t('Edit')}
                        </DropdownMenuItem>
                        <DropdownMenuItem
                            variant="destructive"
                            onSelect={() => onDelete(visit)}
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

function FamilyVisitStatusBadge({
    status,
}: {
    status: EmployeeFamilyVisitRequest['status'];
}) {
    const { t } = useTranslation();

    return (
        <Badge variant={status === 'pending' ? 'outline' : 'secondary'}>
            {status === 'pending' ? t('Pending') : t('Attested')}
        </Badge>
    );
}

function Pagination({
    visits,
}: {
    visits: PaginatedEmployeeFamilyVisitRequests;
}) {
    const { t } = useTranslation();

    if (visits.meta.last_page <= 1) {
        return null;
    }

    return (
        <nav
            aria-label={t('Family visit request pagination')}
            className="flex items-center justify-between gap-4"
        >
            {visits.links.prev ? (
                <Button asChild variant="outline">
                    <Link href={visits.links.prev}>{t('Previous')}</Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Previous')}
                </Button>
            )}
            <p className="text-muted-foreground text-sm">
                {t('Page {{current}} of {{total}}', {
                    current: visits.meta.current_page,
                    total: visits.meta.last_page,
                })}
            </p>
            {visits.links.next ? (
                <Button asChild variant="outline">
                    <Link href={visits.links.next}>{t('Next')}</Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Next')}
                </Button>
            )}
        </nav>
    );
}

function DeleteFamilyVisitRequestDialog({
    onConfirm,
    onOpenChange,
    visit,
}: {
    onConfirm: () => void;
    onOpenChange: (open: boolean) => void;
    visit: EmployeeFamilyVisitRequest | null;
}) {
    const { t } = useTranslation();

    return (
        <Dialog open={visit !== null} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>
                        {t('Delete family visit request')}
                    </DialogTitle>
                    <DialogDescription>
                        {t(
                            'This will permanently delete your pending family visit request.',
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
