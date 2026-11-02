import { Link, router } from '@inertiajs/react';
import {
    CalendarClock,
    ChevronLeft,
    ChevronRight,
    Clock3,
    MoreHorizontal,
    Pencil,
    Plus,
    Search,
    Trash2,
} from 'lucide-react';
import { useState } from 'react';
import { useTranslation } from 'react-i18next';

import { ShortLeaveRequestFormSheet } from '@/components/short-leave/short-leave-request-form-sheet';
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
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { destroy, index } from '@/routes/short-leaves';
import type {
    EmployeeShortLeaveIndexPageProps,
    EmployeeShortLeaveRequest,
    PaginatedEmployeeShortLeaveRequests,
    ShortLeaveFilters,
    ShortLeaveRequestStatus,
    ShortLeaveTypeOption,
} from '@/types';

type ShortLeaveRequestIndexPageProps = EmployeeShortLeaveIndexPageProps;

type FilterFormData = {
    fromDate: string;
    shortLeaveTypeId: string;
    toDate: string;
};

export function ShortLeaveRequestIndexPage({
    filters,
    initialForm,
    shortLeaveRequests,
    shortLeaveTypes,
}: ShortLeaveRequestIndexPageProps) {
    const { i18n, t } = useTranslation();
    const canCreateShortLeave = shortLeaveTypes.length > 0;
    const [isFormOpen, setIsFormOpen] = useState(initialForm.mode !== null);
    const [shortLeaveToEdit, setShortLeaveToEdit] =
        useState<EmployeeShortLeaveRequest | null>(
            initialForm.mode === 'edit' ? initialForm.shortLeave : null,
        );
    const [shortLeaveToDelete, setShortLeaveToDelete] =
        useState<EmployeeShortLeaveRequest | null>(null);
    const [filterForm, setFilterForm] = useState<FilterFormData>(
        filterFormData(filters),
    );

    const openCreateForm = () => {
        if (!canCreateShortLeave) {
            return;
        }

        setShortLeaveToEdit(null);
        setIsFormOpen(true);
    };

    const openEditForm = (shortLeave: EmployeeShortLeaveRequest) => {
        setShortLeaveToEdit(shortLeave);
        setIsFormOpen(true);
    };

    const closeForm = (open: boolean) => {
        setIsFormOpen(open);

        if (!open) {
            setShortLeaveToEdit(null);
        }
    };

    const applyFilters = () => {
        router.get(
            index().url,
            {
                from_date: filterForm.fromDate || undefined,
                short_leave_type_id: filterForm.shortLeaveTypeId || undefined,
                to_date: filterForm.toDate || undefined,
            },
            {
                preserveScroll: true,
                replace: true,
            },
        );
    };

    const clearFilters = () => {
        setFilterForm(emptyFilterFormData());
        router.get(index().url, {}, { preserveScroll: true, replace: true });
    };

    const deleteShortLeave = () => {
        if (!shortLeaveToDelete) {
            return;
        }

        router.delete(destroy(shortLeaveToDelete).url, {
            preserveScroll: true,
            onFinish: () => setShortLeaveToDelete(null),
        });
    };

    return (
        <div
            dir={i18n.dir()}
            className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6"
        >
            <header className="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div className="space-y-1 text-start">
                    <h1 className="text-foreground text-xl font-semibold tracking-tight">
                        {t('Short Leave')}
                    </h1>
                    <p className="text-muted-foreground text-sm">
                        {t('Review and manage your Short Leave requests.')}
                    </p>
                </div>
                <Button
                    className="w-full sm:w-auto"
                    disabled={!canCreateShortLeave}
                    onClick={openCreateForm}
                >
                    <Plus className="size-4" aria-hidden="true" />
                    {t('New Short Leave request')}
                </Button>
            </header>

            <ShortLeaveFiltersForm
                filterForm={filterForm}
                onApply={applyFilters}
                onChange={setFilterForm}
                onClear={clearFilters}
                shortLeaveTypes={shortLeaveTypes}
            />

            {shortLeaveRequests.data.length === 0 ? (
                <EmptyShortLeaveRequests
                    canCreateShortLeave={canCreateShortLeave}
                    onCreate={openCreateForm}
                />
            ) : (
                <Card className="border-border/80 bg-sidebar shadow-xs">
                    <CardHeader>
                        <CardTitle>{t('Short Leave history')}</CardTitle>
                        <CardDescription>
                            {t(
                                'Your Short Leave requests are shown separately from Regular Leave.',
                            )}
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <ul className="divide-border overflow-hidden rounded-lg border">
                            {shortLeaveRequests.data.map((shortLeave) => (
                                <ShortLeaveRequestListItem
                                    key={shortLeave.id}
                                    shortLeave={shortLeave}
                                    onDelete={setShortLeaveToDelete}
                                    onEdit={openEditForm}
                                />
                            ))}
                        </ul>
                        <ShortLeavePagination
                            shortLeaveRequests={shortLeaveRequests}
                        />
                    </CardContent>
                </Card>
            )}

            <ShortLeaveRequestFormSheet
                key={shortLeaveToEdit?.id ?? 'new'}
                shortLeave={shortLeaveToEdit}
                shortLeaveTypes={shortLeaveTypes}
                open={isFormOpen}
                onOpenChange={closeForm}
            />
            <DeleteShortLeaveRequestDialog
                shortLeave={shortLeaveToDelete}
                onConfirm={deleteShortLeave}
                onOpenChange={(open) => {
                    if (!open) {
                        setShortLeaveToDelete(null);
                    }
                }}
            />
        </div>
    );
}

function ShortLeaveFiltersForm({
    filterForm,
    onApply,
    onChange,
    onClear,
    shortLeaveTypes,
}: {
    filterForm: FilterFormData;
    onApply: () => void;
    onChange: (filters: FilterFormData) => void;
    onClear: () => void;
    shortLeaveTypes: ShortLeaveTypeOption[];
}) {
    const { i18n, t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <CardTitle className="text-base">
                    {t('Filter requests')}
                </CardTitle>
                <CardDescription>
                    {t('Filter your Short Leave history by date and type.')}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div className="space-y-2">
                        <Label htmlFor="short-leave-filter-type">
                            {t('Short Leave type')}
                        </Label>
                        <Select
                            value={filterForm.shortLeaveTypeId || 'all'}
                            onValueChange={(value) =>
                                onChange({
                                    ...filterForm,
                                    shortLeaveTypeId:
                                        value === 'all' ? '' : value,
                                })
                            }
                        >
                            <SelectTrigger id="short-leave-filter-type">
                                <SelectValue
                                    placeholder={t('All Short Leave types')}
                                />
                            </SelectTrigger>
                            <SelectContent dir={i18n.dir()}>
                                <SelectItem value="all">
                                    {t('All Short Leave types')}
                                </SelectItem>
                                {shortLeaveTypes.map((shortLeaveType) => (
                                    <SelectItem
                                        key={shortLeaveType.id}
                                        value={String(shortLeaveType.id)}
                                    >
                                        {shortLeaveType.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="short-leave-filter-from">
                            {t('From date')}
                        </Label>
                        <Input
                            id="short-leave-filter-from"
                            type="date"
                            dir={i18n.dir()}
                            lang={i18n.language === 'ar' ? 'ar-SA' : 'en'}
                            value={filterForm.fromDate}
                            onChange={(event) =>
                                onChange({
                                    ...filterForm,
                                    fromDate: event.target.value,
                                })
                            }
                        />
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="short-leave-filter-to">
                            {t('To date')}
                        </Label>
                        <Input
                            id="short-leave-filter-to"
                            type="date"
                            dir={i18n.dir()}
                            lang={i18n.language === 'ar' ? 'ar-SA' : 'en'}
                            value={filterForm.toDate}
                            onChange={(event) =>
                                onChange({
                                    ...filterForm,
                                    toDate: event.target.value,
                                })
                            }
                        />
                    </div>
                    <div className="flex items-end gap-2">
                        <Button type="button" onClick={onApply}>
                            <Search className="size-4" aria-hidden="true" />
                            {t('Apply filters')}
                        </Button>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={onClear}
                        >
                            {t('Clear')}
                        </Button>
                    </div>
                </div>
            </CardContent>
        </Card>
    );
}

function EmptyShortLeaveRequests({
    canCreateShortLeave,
    onCreate,
}: {
    canCreateShortLeave: boolean;
    onCreate: () => void;
}) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardContent className="flex flex-col items-center gap-3 py-12 text-center">
                <div className="bg-muted text-muted-foreground flex size-12 items-center justify-center rounded-lg">
                    <CalendarClock className="size-6" aria-hidden="true" />
                </div>
                <div className="space-y-1">
                    <p className="text-foreground font-medium">
                        {t('No Short Leave requests yet')}
                    </p>
                    <p className="text-muted-foreground max-w-sm text-sm">
                        {t(
                            'Create a Short Leave request when you need time away during a workday.',
                        )}
                    </p>
                </div>
                {canCreateShortLeave ? (
                    <Button onClick={onCreate}>
                        <Plus className="size-4" aria-hidden="true" />
                        {t('New Short Leave request')}
                    </Button>
                ) : (
                    <p className="text-muted-foreground text-sm" role="status">
                        {t(
                            'Short Leave requests are unavailable until a Short Leave type is available.',
                        )}
                    </p>
                )}
            </CardContent>
        </Card>
    );
}

function ShortLeaveRequestListItem({
    onDelete,
    onEdit,
    shortLeave,
}: {
    onDelete: (shortLeave: EmployeeShortLeaveRequest) => void;
    onEdit: (shortLeave: EmployeeShortLeaveRequest) => void;
    shortLeave: EmployeeShortLeaveRequest;
}) {
    const { i18n, t } = useTranslation();

    return (
        <li className="flex flex-col gap-4 p-4 sm:flex-row sm:items-start sm:justify-between">
            <div className="min-w-0 space-y-2">
                <div className="flex flex-wrap items-center gap-2">
                    <p className="text-foreground font-medium">
                        {shortLeave.shortLeaveType.name}
                    </p>
                    <ShortLeaveStatusBadge status={shortLeave.status} />
                </div>
                <div className="text-muted-foreground flex flex-wrap items-center gap-x-4 gap-y-1 text-sm">
                    <span className="inline-flex items-center gap-2">
                        <CalendarClock className="size-4" aria-hidden="true" />
                        {formatShortLeaveDate(
                            shortLeave.shortLeaveDate,
                            i18n.language,
                        )}
                    </span>
                    <span className="inline-flex items-center gap-2">
                        <Clock3 className="size-4" aria-hidden="true" />
                        {formatShortLeaveTimeRange(
                            shortLeave.shortLeaveFrom,
                            shortLeave.shortLeaveTo,
                            i18n.language,
                        )}
                    </span>
                    <span>
                        {t('Duration: {{duration}}', {
                            duration: formatShortLeaveDuration(
                                shortLeave.shortLeaveFrom,
                                shortLeave.shortLeaveTo,
                                i18n.language,
                            ),
                        })}
                    </span>
                </div>
                {shortLeave.submittedDate ? (
                    <p className="text-muted-foreground text-sm">
                        {t('Submitted {{date}}', {
                            date: formatShortLeaveDate(
                                shortLeave.submittedDate,
                                i18n.language,
                            ),
                        })}
                    </p>
                ) : null}
            </div>
            {shortLeave.canEdit || shortLeave.canDelete ? (
                <DropdownMenu dir={i18n.dir()}>
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
                        {shortLeave.canEdit ? (
                            <DropdownMenuItem
                                onSelect={() => onEdit(shortLeave)}
                            >
                                <Pencil className="size-4" />
                                {t('Edit')}
                            </DropdownMenuItem>
                        ) : null}
                        {shortLeave.canDelete ? (
                            <DropdownMenuItem
                                variant="destructive"
                                onSelect={() => onDelete(shortLeave)}
                            >
                                <Trash2 className="size-4" />
                                {t('Delete')}
                            </DropdownMenuItem>
                        ) : null}
                    </DropdownMenuContent>
                </DropdownMenu>
            ) : null}
        </li>
    );
}

function ShortLeaveStatusBadge({
    status,
}: {
    status: ShortLeaveRequestStatus;
}) {
    const { t } = useTranslation();

    const variant = status === 'approved' ? 'default' : 'outline';

    return <Badge variant={variant}>{shortLeaveStatusLabel(status, t)}</Badge>;
}

function ShortLeavePagination({
    shortLeaveRequests,
}: {
    shortLeaveRequests: PaginatedEmployeeShortLeaveRequests;
}) {
    const { t } = useTranslation();

    if (shortLeaveRequests.meta.last_page <= 1) {
        return null;
    }

    return (
        <nav
            aria-label={t('Short Leave request pagination')}
            className="flex items-center justify-between gap-4"
        >
            {shortLeaveRequests.links.prev ? (
                <Button asChild variant="outline">
                    <Link href={shortLeaveRequests.links.prev}>
                        <ChevronLeft className="size-4 rtl:rotate-180" />
                        {t('Previous')}
                    </Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    <ChevronLeft className="size-4 rtl:rotate-180" />
                    {t('Previous')}
                </Button>
            )}
            <p className="text-muted-foreground text-sm">
                {t('Leave history page', {
                    current: shortLeaveRequests.meta.current_page,
                    total: shortLeaveRequests.meta.last_page,
                })}
            </p>
            {shortLeaveRequests.links.next ? (
                <Button asChild variant="outline">
                    <Link href={shortLeaveRequests.links.next}>
                        {t('Next')}
                        <ChevronRight className="size-4 rtl:rotate-180" />
                    </Link>
                </Button>
            ) : (
                <Button variant="outline" disabled>
                    {t('Next')}
                    <ChevronRight className="size-4 rtl:rotate-180" />
                </Button>
            )}
        </nav>
    );
}

function DeleteShortLeaveRequestDialog({
    onConfirm,
    onOpenChange,
    shortLeave,
}: {
    onConfirm: () => void;
    onOpenChange: (open: boolean) => void;
    shortLeave: EmployeeShortLeaveRequest | null;
}) {
    const { i18n, t } = useTranslation();

    return (
        <Dialog open={shortLeave !== null} onOpenChange={onOpenChange}>
            <DialogContent dir={i18n.dir()}>
                <DialogHeader>
                    <DialogTitle>{t('Delete Short Leave request')}</DialogTitle>
                    <DialogDescription>
                        {t(
                            'This will permanently delete your Short Leave request.',
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

function filterFormData(filters: ShortLeaveFilters): FilterFormData {
    return {
        fromDate: filters.fromDate ?? '',
        shortLeaveTypeId: filters.shortLeaveTypeId
            ? String(filters.shortLeaveTypeId)
            : '',
        toDate: filters.toDate ?? '',
    };
}

function emptyFilterFormData(): FilterFormData {
    return {
        fromDate: '',
        shortLeaveTypeId: '',
        toDate: '',
    };
}

function formatShortLeaveDate(date: string, language: string): string {
    return new Intl.DateTimeFormat(language === 'ar' ? 'ar-SA' : 'en-US', {
        dateStyle: 'medium',
        timeZone: 'UTC',
    }).format(new Date(`${date}T00:00:00Z`));
}

function formatShortLeaveTime(time: string, language: string): string {
    return new Intl.DateTimeFormat(language === 'ar' ? 'ar-SA' : 'en-US', {
        timeStyle: 'short',
        timeZone: 'UTC',
    }).format(new Date(`1970-01-01T${time}:00Z`));
}

function formatShortLeaveTimeRange(
    startTime: string,
    endTime: string,
    language: string,
): string {
    return `${formatShortLeaveTime(startTime, language)} – ${formatShortLeaveTime(endTime, language)}`;
}

function formatShortLeaveDuration(
    startTime: string,
    endTime: string,
    language: string,
): string {
    const startMinutes = minutesSinceMidnight(startTime);
    const endMinutes = minutesSinceMidnight(endTime);

    if (
        startMinutes === null ||
        endMinutes === null ||
        endMinutes < startMinutes
    ) {
        return '–';
    }

    const durationMinutes = endMinutes - startMinutes;
    const numberFormat = new Intl.NumberFormat(
        language === 'ar' ? 'ar-SA' : 'en-US',
        { useGrouping: false },
    );
    const minuteFormat = new Intl.NumberFormat(
        language === 'ar' ? 'ar-SA' : 'en-US',
        {
            minimumIntegerDigits: 2,
            useGrouping: false,
        },
    );

    return `${numberFormat.format(Math.floor(durationMinutes / 60))}:${minuteFormat.format(durationMinutes % 60)}`;
}

function minutesSinceMidnight(time: string): number | null {
    const [hours, minutes] = time.split(':').map(Number);

    if (
        !Number.isInteger(hours) ||
        !Number.isInteger(minutes) ||
        hours < 0 ||
        hours > 23 ||
        minutes < 0 ||
        minutes > 59
    ) {
        return null;
    }

    return hours * 60 + minutes;
}

function shortLeaveStatusLabel(
    status: ShortLeaveRequestStatus,
    t: (key: string) => string,
): string {
    const labels: Record<ShortLeaveRequestStatus, string> = {
        approved: t('Leave status approved'),
        cancelled: t('Leave status cancelled'),
        pending: t('Leave status pending'),
        rejected: t('Leave status rejected'),
    };

    return labels[status];
}
