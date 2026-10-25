import { Link, router } from '@inertiajs/react';
import { FileText, MoreHorizontal, Pencil, Plus, Trash2 } from 'lucide-react';
import { useState } from 'react';
import { useTranslation } from 'react-i18next';

import { LetterRequestFormSheet } from '@/components/request/letter/letter-request-form-sheet';
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
import { destroy } from '@/routes/letters';
import type {
    EmployeeLetterRequest,
    PaginatedEmployeeLetterRequests,
} from '@/types';

type LetterRequestIndexPageProps = {
    letters: PaginatedEmployeeLetterRequests;
};

export function LetterRequestIndexPage({
    letters,
}: LetterRequestIndexPageProps) {
    const { t, i18n } = useTranslation();
    const [isFormOpen, setIsFormOpen] = useState(false);
    const [letterToEdit, setLetterToEdit] =
        useState<EmployeeLetterRequest | null>(null);
    const [letterToDelete, setLetterToDelete] =
        useState<EmployeeLetterRequest | null>(null);

    const openCreateForm = () => {
        setLetterToEdit(null);
        setIsFormOpen(true);
    };

    const openEditForm = (letter: EmployeeLetterRequest) => {
        setLetterToEdit(letter);
        setIsFormOpen(true);
    };

    const closeForm = (open: boolean) => {
        setIsFormOpen(open);

        if (!open) {
            setLetterToEdit(null);
        }
    };

    const deleteLetter = () => {
        if (!letterToDelete) {
            return;
        }

        router.delete(destroy(letterToDelete).url, {
            preserveScroll: true,
            onFinish: () => setLetterToDelete(null),
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
                        {t('Letter requests')}
                    </h1>
                    <p className="text-muted-foreground text-sm">
                        {t('Request and manage your employment letters.')}
                    </p>
                </div>
                <Button className="w-full sm:w-auto" onClick={openCreateForm}>
                    <Plus className="size-4" />
                    {t('New letter request')}
                </Button>
            </header>

            {letters.data.length === 0 ? (
                <EmptyLetterRequests onCreate={openCreateForm} />
            ) : (
                <Card className="border-border/80 bg-sidebar shadow-xs">
                    <CardHeader>
                        <CardTitle>{t('Your letter requests')}</CardTitle>
                        <CardDescription>
                            {t('Pending requests can be updated or deleted.')}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <ul className="divide-border overflow-hidden rounded-lg border">
                            {letters.data.map((letter) => (
                                <LetterRequestListItem
                                    key={letter.id}
                                    letter={letter}
                                    onDelete={setLetterToDelete}
                                    onEdit={openEditForm}
                                />
                            ))}
                        </ul>
                        <Pagination letters={letters} />
                    </CardContent>
                </Card>
            )}

            <LetterRequestFormSheet
                key={letterToEdit?.id ?? 'new'}
                letter={letterToEdit}
                open={isFormOpen}
                onOpenChange={closeForm}
            />
            <DeleteLetterRequestDialog
                letter={letterToDelete}
                onConfirm={deleteLetter}
                onOpenChange={(open) => {
                    if (!open) {
                        setLetterToDelete(null);
                    }
                }}
            />
        </div>
    );
}

function EmptyLetterRequests({ onCreate }: { onCreate: () => void }) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardContent className="flex flex-col items-center gap-3 py-12 text-center">
                <div className="bg-muted text-muted-foreground flex size-12 items-center justify-center rounded-lg">
                    <FileText className="size-6" />
                </div>
                <div className="space-y-1">
                    <p className="text-foreground font-medium">
                        {t('No letter requests yet')}
                    </p>
                    <p className="text-muted-foreground max-w-sm text-sm">
                        {t(
                            'Create a letter request when you need an employment letter.',
                        )}
                    </p>
                </div>
                <Button onClick={onCreate}>
                    <Plus className="size-4" />
                    {t('New letter request')}
                </Button>
            </CardContent>
        </Card>
    );
}

function LetterRequestListItem({
    letter,
    onDelete,
    onEdit,
}: {
    letter: EmployeeLetterRequest;
    onDelete: (letter: EmployeeLetterRequest) => void;
    onEdit: (letter: EmployeeLetterRequest) => void;
}) {
    const { t } = useTranslation();
    const isPending = letter.status === 'pending';

    return (
        <li className="flex flex-col gap-4 p-4 sm:flex-row sm:items-start sm:justify-between">
            <div className="min-w-0 space-y-2">
                <div className="flex flex-wrap items-center gap-2">
                    <p className="text-foreground font-medium">
                        {letter.title}
                    </p>
                    <LetterStatusBadge status={letter.status} />
                </div>
                {letter.description ? (
                    <p className="text-muted-foreground text-sm">
                        {letter.description}
                    </p>
                ) : null}
                <div className="text-muted-foreground flex flex-wrap gap-x-4 gap-y-1 text-sm">
                    <span>
                        {letter.include_salary
                            ? t('Salary information included')
                            : t('Salary information not included')}
                    </span>
                    <span>
                        {letter.attested
                            ? t('Attested copy requested')
                            : t('Standard copy requested')}
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
                        <DropdownMenuItem onSelect={() => onEdit(letter)}>
                            <Pencil className="size-4" />
                            {t('Edit')}
                        </DropdownMenuItem>
                        <DropdownMenuItem
                            variant="destructive"
                            onSelect={() => onDelete(letter)}
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

function LetterStatusBadge({
    status,
}: {
    status: EmployeeLetterRequest['status'];
}) {
    const { t } = useTranslation();

    return (
        <Badge variant={status === 'pending' ? 'outline' : 'secondary'}>
            {status === 'pending' ? t('Pending') : t('Done')}
        </Badge>
    );
}

function Pagination({ letters }: { letters: PaginatedEmployeeLetterRequests }) {
    const { t } = useTranslation();

    if (letters.meta.last_page <= 1) {
        return null;
    }

    return (
        <nav
            aria-label={t('Letter request pagination')}
            className="flex items-center justify-between gap-4"
        >
            {letters.links.prev ? (
                <Button asChild variant="outline">
                    <Link href={letters.links.prev}>{t('Previous')}</Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Previous')}
                </Button>
            )}
            <p className="text-muted-foreground text-sm">
                {t('Page {{current}} of {{total}}', {
                    current: letters.meta.current_page,
                    total: letters.meta.last_page,
                })}
            </p>
            {letters.links.next ? (
                <Button asChild variant="outline">
                    <Link href={letters.links.next}>{t('Next')}</Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Next')}
                </Button>
            )}
        </nav>
    );
}

function DeleteLetterRequestDialog({
    letter,
    onConfirm,
    onOpenChange,
}: {
    letter: EmployeeLetterRequest | null;
    onConfirm: () => void;
    onOpenChange: (open: boolean) => void;
}) {
    const { t } = useTranslation();

    return (
        <Dialog open={letter !== null} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>{t('Delete letter request')}</DialogTitle>
                    <DialogDescription>
                        {t(
                            'This will permanently delete your pending letter request.',
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
