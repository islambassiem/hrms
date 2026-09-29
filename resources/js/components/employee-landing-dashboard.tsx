import type { ReactNode } from 'react';
import type { LucideIcon } from 'lucide-react';
import {
    Calendar,
    CalendarDays,
    CheckCircle2,
    Clock,
    FileText,
    LayoutGrid,
    ShieldAlert,
    User,
    Users,
    Zap,
} from 'lucide-react';
import { toast } from 'sonner';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import { Skeleton } from '@/components/ui/skeleton';
import { useDashboardWorkspace } from '@/hooks/use-dashboard-workspace';
import {
    mockDashboardData,
    type AttentionDocumentItem,
    type EmployeeDashboardData,
    type QuickActionId,
    type WorkspaceId,
    type WorkspaceOption,
} from '@/types/dashboard';

const actionIcons: Record<QuickActionId, LucideIcon> = {
    'request-leave': CalendarDays,
    attendance: Clock,
    documents: FileText,
    profile: User,
};

export function EmployeeLandingDashboard() {
    const [selectedWorkspace] = useDashboardWorkspace();

    return (
        <div className="bg-background w-full">
            <div className="mx-auto flex w-full max-w-[1440px] flex-col gap-6 p-4 sm:p-6">
                <DashboardContent
                    data={mockDashboardData}
                    selectedWorkspace={selectedWorkspace}
                />
            </div>
        </div>
    );
}

function DashboardContent({
    data,
    selectedWorkspace,
}: {
    data: EmployeeDashboardData;
    selectedWorkspace: WorkspaceId;
}) {
    const activeWorkspace =
        data.availableWorkspaces.find(
            (workspace) => workspace.id === selectedWorkspace,
        ) ??
        data.availableWorkspaces.find((workspace) => workspace.isDefault) ??
        null;

    if (!activeWorkspace || activeWorkspace.id !== 'employee') {
        return <WorkspaceUnavailableState workspace={activeWorkspace} />;
    }

    if (!data.employee) {
        return <MissingProfileState />;
    }

    const employee = data.employee;
    const leaveUsage = percent(
        data.leaveBalance.used_days,
        data.leaveBalance.annual_entitlement,
    );
    const initials = employee.name_en
        .split(' ')
        .filter(Boolean)
        .map((name) => name[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();

    return (
        <div className="flex flex-col gap-6">
            <Card className="border-border/80 bg-sidebar gap-0 overflow-hidden py-0 shadow-xs">
                <CardContent className="flex flex-col gap-5 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between">
                    <div className="flex flex-col gap-4 sm:flex-row sm:items-start">
                        <Avatar className="border-border/80 size-16 shrink-0 rounded-xl border shadow-xs">
                            <AvatarImage
                                src={employee.avatar}
                                alt={employee.name_en}
                            />
                            <AvatarFallback className="bg-primary/10 text-primary text-xl font-bold">
                                {initials}
                            </AvatarFallback>
                        </Avatar>
                        <div className="min-w-0 space-y-1.5">
                            <div className="flex flex-wrap items-center gap-2">
                                <h1 className="text-foreground text-xl font-bold tracking-tight">
                                    {employee.name_en}
                                </h1>
                                {employee.employment_status && (
                                    <StatusBadge tone="success">
                                        {employee.employment_status}
                                    </StatusBadge>
                                )}
                            </div>
                            <div>
                                {employee.job_title && (
                                    <p className="text-muted-foreground text-sm font-medium">
                                        {employee.job_title}
                                    </p>
                                )}
                            </div>
                            <div className="flex flex-wrap items-center gap-2.5 pt-1">
                                {employee.employee_code && (
                                    <Badge
                                        variant="outline"
                                        className="font-mono"
                                    >
                                        #{employee.employee_code}
                                    </Badge>
                                )}
                                {employee.department && (
                                    <span className="text-muted-foreground text-xs font-medium">
                                        {employee.department}
                                    </span>
                                )}
                            </div>
                        </div>
                    </div>
                    <div className="flex shrink-0 items-center pt-1 sm:pt-0">
                        <Button
                            variant="outline"
                            size="sm"
                            className="shadow-xs"
                            onClick={() => unavailable('Employee profile')}
                        >
                            <User className="size-3.5" />
                            View profile
                        </Button>
                    </div>
                </CardContent>
                <Separator />
                <CardContent className="bg-muted/20 dark:bg-muted/10 grid grid-cols-2 gap-4 rounded-b-xl p-5 sm:grid-cols-2 lg:grid-cols-4">
                    <Detail
                        label="Direct supervisor"
                        value={employee.manager_name}
                    />
                    <Detail
                        label="Joining date"
                        value={employee.joining_date}
                    />
                    <Detail
                        label="Service tenure"
                        value={employee.service_tenure}
                    />
                    <Detail
                        label="Active workspace"
                        value={activeWorkspace.label}
                    />
                </CardContent>
            </Card>

            <section
                aria-label="Employee summary"
                className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
            >
                <MetricCard
                    icon={CalendarDays}
                    tone="primary"
                    label="Leave balance"
                    value={`${data.leaveBalance.available_days} days`}
                    detail={`${data.leaveBalance.used_days} used of ${data.leaveBalance.annual_entitlement}`}
                />
                <MetricCard
                    icon={Clock}
                    tone="muted"
                    label="Attendance rate"
                    value={
                        data.attendanceRate === null
                            ? 'Not available'
                            : `${data.attendanceRate}%`
                    }
                    detail="Daily average this month"
                />
                <MetricCard
                    icon={Users}
                    tone="warning"
                    label="Pending requests"
                    value={`${data.pendingRequests.length}`}
                    badge={
                        <StatusBadge tone="warning">
                            Requires action
                        </StatusBadge>
                    }
                    detail="Requests awaiting review"
                />
                <MetricCard
                    icon={ShieldAlert}
                    tone="destructive"
                    label="Attention needed"
                    value={`${data.attentionDocuments.length}`}
                    badge={<StatusBadge tone="destructive">Review</StatusBadge>}
                    detail="Documents to review"
                />
            </section>

            <Card className="border-border/80 bg-muted shadow-xs">
                <CardContent className="flex flex-col gap-4 p-5">
                    <div className="flex items-center gap-3">
                        <div className="border-warning/30 bg-warning/10 text-warning flex size-9 shrink-0 items-center justify-center rounded-xl border">
                            <Zap className="size-4" />
                        </div>
                        <div>
                            <h2 className="text-foreground text-sm font-semibold tracking-wide">
                                Quick actions
                            </h2>
                            <p className="text-muted-foreground text-xs">
                                Shortcuts to your leave, attendance, documents,
                                and profile.
                            </p>
                        </div>
                    </div>
                    <div className="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        {data.quickActions.map((action) => {
                            const Icon = actionIcons[action.id];

                            return (
                                <Button
                                    key={action.id}
                                    variant="outline"
                                    className="border-border/60 hover:bg-muted/50 hover:border-border group bg-card h-auto items-start justify-start gap-3 rounded-xl p-3.5 text-left whitespace-normal transition-all duration-200"
                                    onClick={() => unavailable(action.label)}
                                >
                                    <div className="bg-muted text-muted-foreground group-hover:text-foreground shrink-0 rounded-lg p-2 transition-colors">
                                        <Icon className="size-4" />
                                    </div>
                                    <div className="min-w-0">
                                        <span className="text-foreground block text-xs font-semibold">
                                            {action.label}
                                        </span>
                                        <span className="text-muted-foreground mt-0.5 block text-[11px] leading-relaxed">
                                            {action.description}
                                        </span>
                                    </div>
                                </Button>
                            );
                        })}
                    </div>
                </CardContent>
            </Card>

            <section className="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <Card className="border-border/80 bg-sidebar shadow-xs lg:col-span-2">
                    <CardHeader>
                        <CardTitle>Requests awaiting action</CardTitle>
                        <CardDescription>
                            Your latest leave and employee requests.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        {data.pendingRequests.length === 0 ? (
                            <EmptyState
                                icon={CheckCircle2}
                                title="No requests awaiting action"
                                description="You are up to date."
                            />
                        ) : (
                            <div className="divide-border divide-y">
                                {data.pendingRequests.map((request) => (
                                    <div
                                        key={request.id}
                                        className="flex flex-col gap-2 py-3.5 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between"
                                    >
                                        <div className="min-w-0">
                                            <p className="text-foreground text-sm font-medium">
                                                {request.title}
                                            </p>
                                            <p className="text-muted-foreground mt-0.5 text-xs">
                                                Submitted{' '}
                                                {request.submitted_date}
                                            </p>
                                        </div>
                                        <StatusBadge tone="warning">
                                            {request.status_label}
                                        </StatusBadge>
                                    </div>
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>

                <Card className="border-border/80 bg-sidebar shadow-xs lg:col-span-1">
                    <CardHeader>
                        <CardTitle>Annual leave</CardTitle>
                        <CardDescription>
                            Your current balance and usage.
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div className="flex items-baseline justify-between gap-4">
                            <span className="text-foreground text-2xl font-bold">
                                {data.leaveBalance.available_days}
                            </span>
                            <span className="text-muted-foreground text-xs font-medium">
                                of {data.leaveBalance.annual_entitlement} total
                                days
                            </span>
                        </div>
                        <div
                            className="flex h-2 gap-0.5"
                            role="progressbar"
                            aria-label="Annual leave used"
                            aria-valuemin={0}
                            aria-valuemax={data.leaveBalance.annual_entitlement}
                            aria-valuenow={data.leaveBalance.used_days}
                        >
                            {Array.from({ length: 10 }, (_, index) => (
                                <span
                                    key={index}
                                    className={`h-full flex-1 rounded-full ${
                                        index < Math.round(leaveUsage / 10)
                                            ? 'bg-success'
                                            : 'bg-muted'
                                    }`}
                                />
                            ))}
                        </div>
                        <p className="text-muted-foreground text-xs">
                            {data.leaveBalance.used_days} days used ·{' '}
                            {data.leaveBalance.pending_days} days pending
                        </p>
                        {data.leaveBalance.upcoming_approved_leave ? (
                            <Alert>
                                <Calendar className="size-4" />
                                <AlertTitle className="text-xs font-semibold">
                                    {
                                        data.leaveBalance
                                            .upcoming_approved_leave.leave_type
                                    }
                                </AlertTitle>
                                <AlertDescription className="mt-0.5 text-xs">
                                    {
                                        data.leaveBalance
                                            .upcoming_approved_leave.start_date
                                    }{' '}
                                    to{' '}
                                    {
                                        data.leaveBalance
                                            .upcoming_approved_leave.end_date
                                    }
                                    . Return:{' '}
                                    {
                                        data.leaveBalance
                                            .upcoming_approved_leave
                                            .return_to_work_date
                                    }
                                    .
                                </AlertDescription>
                            </Alert>
                        ) : (
                            <EmptyState
                                icon={CalendarDays}
                                title="No upcoming leave"
                                description="Approved leave will appear here."
                            />
                        )}
                    </CardContent>
                </Card>
            </section>

            <section className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <ListCard
                    title="Upcoming milestones"
                    description="Events and important employee dates."
                    items={data.upcomingMilestones}
                    emptyIcon={Calendar}
                    emptyTitle="No upcoming milestones"
                    emptyDescription="New events will appear here."
                    renderItem={(milestone) => (
                        <div className="flex items-start gap-3">
                            <div className="bg-muted text-muted-foreground mt-0.5 shrink-0 rounded-lg p-2">
                                <Calendar className="size-4" />
                            </div>
                            <div className="min-w-0">
                                <p className="text-foreground text-sm font-medium">
                                    {milestone.title}
                                </p>
                                <p className="text-muted-foreground mt-0.5 text-xs">
                                    {milestone.date} · {milestone.description}
                                </p>
                            </div>
                        </div>
                    )}
                />
                <ListCard
                    title="Documents requiring attention"
                    description="Document workflows will be connected later."
                    items={data.attentionDocuments}
                    emptyIcon={CheckCircle2}
                    emptyTitle="Documents are up to date"
                    emptyDescription="There are no document alerts to review."
                    renderItem={(document) => (
                        <DocumentItem document={document} />
                    )}
                />
            </section>
        </div>
    );
}

function Detail({ label, value }: { label: string; value?: string }) {
    return (
        <div>
            <p className="text-muted-foreground text-xs font-medium tracking-wider uppercase">
                {label}
            </p>
            <p className="text-foreground mt-0.5 text-sm font-semibold">
                {value ?? 'Not available'}
            </p>
        </div>
    );
}

function MetricCard({
    icon: Icon,
    tone,
    label,
    value,
    badge,
    detail,
}: {
    icon: LucideIcon;
    tone: 'primary' | 'muted' | 'warning' | 'destructive';
    label: string;
    value: string;
    badge?: ReactNode;
    detail: string;
}) {
    const iconClassNames = {
        primary: 'border-primary/20 bg-primary/10 text-primary',
        muted: 'border-border bg-muted text-muted-foreground',
        warning: 'border-warning/30 bg-warning/10 text-warning',
        destructive: 'border-destructive/30 bg-destructive/10 text-destructive',
    }[tone];

    return (
        <Card className="border-border/80 bg-sidebar py-5 shadow-xs transition-shadow hover:shadow-sm">
            <CardContent className="flex items-start justify-between gap-4">
                <div className="min-w-0">
                    <p className="text-muted-foreground text-xs font-medium tracking-wider uppercase">
                        {label}
                    </p>
                    <div className="mt-1 flex items-baseline gap-2">
                        <p className="text-foreground text-2xl font-bold">
                            {value}
                        </p>
                        {badge}
                    </div>
                    <p className="text-muted-foreground mt-1 text-xs">
                        {detail}
                    </p>
                </div>
                <div
                    className={`flex size-10 shrink-0 items-center justify-center rounded-lg ${iconClassNames}`}
                >
                    <Icon className="size-5" />
                </div>
            </CardContent>
        </Card>
    );
}

function ListCard<T extends { id: string }>({
    title,
    description,
    items,
    emptyIcon,
    emptyTitle,
    emptyDescription,
    renderItem,
}: {
    title: string;
    description: string;
    items: T[];
    emptyIcon: LucideIcon;
    emptyTitle: string;
    emptyDescription: string;
    renderItem: (item: T) => ReactNode;
}) {
    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <CardTitle>{title}</CardTitle>
                <CardDescription>{description}</CardDescription>
            </CardHeader>
            <CardContent>
                {items.length === 0 ? (
                    <EmptyState
                        icon={emptyIcon}
                        title={emptyTitle}
                        description={emptyDescription}
                    />
                ) : (
                    <div className="divide-border divide-y">
                        {items.map((item) => (
                            <div
                                key={item.id}
                                className="py-3.5 first:pt-0 last:pb-0"
                            >
                                {renderItem(item)}
                            </div>
                        ))}
                    </div>
                )}
            </CardContent>
        </Card>
    );
}

function DocumentItem({ document }: { document: AttentionDocumentItem }) {
    return (
        <div className="flex items-start justify-between gap-4">
            <div className="min-w-0">
                <p className="text-foreground text-sm font-medium">
                    {document.title}
                </p>
                <p className="text-muted-foreground mt-0.5 text-xs">
                    Expires {document.expiry_date}
                </p>
            </div>
            <StatusBadge
                tone={
                    document.severity === 'expired' ? 'destructive' : 'warning'
                }
            >
                {document.severity === 'expired' ? 'Expired' : 'Review'}
            </StatusBadge>
        </div>
    );
}

function StatusBadge({
    children,
    tone,
}: {
    children: ReactNode;
    tone: 'success' | 'warning' | 'destructive';
}) {
    const className = {
        success: 'border-success/30 bg-success/10 text-success',
        warning: 'border-warning/30 bg-warning/10 text-warning',
        destructive: 'border-destructive/30 bg-destructive/10 text-destructive',
    }[tone];

    return (
        <Badge variant="outline" className={className}>
            {children}
        </Badge>
    );
}

function EmptyState({
    icon: Icon,
    title,
    description,
}: {
    icon: LucideIcon;
    title: string;
    description: string;
}) {
    return (
        <div className="flex flex-col items-center gap-2 py-6 text-center">
            <div className="bg-muted text-muted-foreground flex size-10 items-center justify-center rounded-lg">
                <Icon className="size-5" />
            </div>
            <p className="text-foreground text-sm font-medium">{title}</p>
            <p className="text-muted-foreground max-w-sm text-xs">
                {description}
            </p>
        </div>
    );
}

function MissingProfileState() {
    return (
        <Alert>
            <User className="size-4" />
            <AlertTitle>Employee profile is not available</AlertTitle>
            <AlertDescription>
                Your employee information is not available yet. Contact HR if
                you need help.
            </AlertDescription>
        </Alert>
    );
}

function WorkspaceUnavailableState({
    workspace,
}: {
    workspace: WorkspaceOption | null;
}) {
    const workspaceLabel = workspace?.label ?? 'Selected';

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader>
                <CardTitle>{workspaceLabel} workspace</CardTitle>
                <CardDescription>
                    This workspace does not have a dashboard in the current
                    frontend implementation.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <Alert>
                    <LayoutGrid className="size-4" />
                    <AlertTitle>Workspace not available</AlertTitle>
                    <AlertDescription>
                        The Employee workspace is available for this dashboard.
                        Select Employee to return to your employee overview.
                    </AlertDescription>
                </Alert>
            </CardContent>
        </Card>
    );
}

export function DashboardSkeleton() {
    return (
        <div className="flex flex-col gap-6" aria-label="Loading dashboard">
            <Card className="border-border/80 bg-sidebar shadow-xs">
                <CardContent className="flex items-center gap-4 pt-6">
                    <Skeleton className="size-20 rounded-full" />
                    <div className="space-y-2">
                        <Skeleton className="h-6 w-48" />
                        <Skeleton className="h-4 w-32" />
                        <Skeleton className="h-4 w-56" />
                    </div>
                </CardContent>
            </Card>
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                {[0, 1, 2, 3].map((index) => (
                    <Skeleton key={index} className="h-32 rounded-xl" />
                ))}
            </div>
            <div className="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <Skeleton className="h-64 rounded-xl lg:col-span-2" />
                <Skeleton className="h-64 rounded-xl" />
            </div>
        </div>
    );
}

function percent(value: number, maximum: number): number {
    if (maximum <= 0) {
        return 0;
    }

    return Math.min(100, Math.max(0, (value / maximum) * 100));
}

function unavailable(label: string): void {
    toast.info(`${label} is not connected yet`, {
        description:
            'This is a frontend-only prototype. No workflow was started.',
    });
}
