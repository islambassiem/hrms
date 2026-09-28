import { usePage } from '@inertiajs/react';
import { ChevronsUpDown, Moon, Sun } from 'lucide-react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { UserInfo } from '@/components/user-info';
import { UserMenuContent } from '@/components/user-menu-content';
import { useAppearance } from '@/hooks/use-appearance';
import { useDashboardWorkspace } from '@/hooks/use-dashboard-workspace';
import { useInitials } from '@/hooks/use-initials';
import { mockDashboardData } from '@/types/dashboard';
import { WorkspaceSelector } from '@/components/workspace-selector';
import type { BreadcrumbItem as BreadcrumbItemType, User } from '@/types';

export function AppSidebarHeader({
    breadcrumbs = [],
}: {
    breadcrumbs?: BreadcrumbItemType[];
}) {
    const page = usePage();
    const { auth } = page.props;
    const { resolvedAppearance, updateAppearance } = useAppearance();
    const [selectedWorkspace, setSelectedWorkspace] = useDashboardWorkspace();
    const workspaceData = mockDashboardData;

    return (
        <header className="border-sidebar-border/50 bg-background/95 sticky top-0 z-40 flex h-16 shrink-0 items-center justify-between gap-2 border-b px-4 backdrop-blur-xs transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:rounded-t-xl md:px-6">
            <div className="flex min-w-0 items-center gap-2">
                <SidebarTrigger className="-ml-1" />
                <div className="hidden min-w-0 sm:block">
                    <Breadcrumbs breadcrumbs={breadcrumbs} />
                </div>
            </div>
            <div className="flex min-w-0 items-center gap-2.5 sm:gap-3">
                <Button
                    variant="ghost"
                    size="icon"
                    className="text-muted-foreground hover:bg-muted/70 hover:text-foreground size-9 shrink-0 rounded-lg transition-colors"
                    onClick={() =>
                        updateAppearance(
                            resolvedAppearance === 'dark' ? 'light' : 'dark',
                        )
                    }
                    aria-label={
                        resolvedAppearance === 'dark'
                            ? 'Switch to light theme'
                            : 'Switch to dark theme'
                    }
                    title={
                        resolvedAppearance === 'dark'
                            ? 'Switch to light theme'
                            : 'Switch to dark theme'
                    }
                >
                    {resolvedAppearance === 'dark' ? (
                        <Sun className="size-4" />
                    ) : (
                        <Moon className="size-4" />
                    )}
                </Button>

                {auth.user && (
                    <>
                        <div className="bg-border/60 hidden h-6 w-px sm:block" />
                        <div className="flex shrink-0 items-center gap-1.5">
                            <span className="text-muted-foreground hidden text-xs sm:inline">
                                Workspace:
                            </span>
                            <WorkspaceSelector
                                availableWorkspaces={
                                    workspaceData.availableWorkspaces
                                }
                                selectedWorkspace={selectedWorkspace}
                                onWorkspaceChange={setSelectedWorkspace}
                                variant="compact"
                            />
                        </div>
                    </>
                )}

                {auth.user && workspaceData.employee ? (
                    <>
                        <div className="bg-border/60 hidden h-6 w-px sm:block" />
                        <DashboardHeaderUser
                            user={auth.user}
                            jobTitle={workspaceData.employee.job_title}
                        />
                    </>
                ) : auth.user ? (
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button
                                variant="ghost"
                                className="h-auto max-w-48 px-2 py-1.5 sm:max-w-64"
                                aria-label="Open user menu"
                            >
                                <UserInfo user={auth.user} />
                                <ChevronsUpDown className="text-muted-foreground size-4 shrink-0" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" className="w-64">
                            <UserMenuContent user={auth.user} />
                        </DropdownMenuContent>
                    </DropdownMenu>
                ) : null}
            </div>
        </header>
    );
}

function DashboardHeaderUser({
    user,
    jobTitle,
}: {
    user: User;
    jobTitle?: string;
}) {
    const getInitials = useInitials();
    const displayName = user.name.replace(/^Mr\.\s*/i, '');

    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button
                    variant="ghost"
                    className="h-auto min-w-0 gap-2 px-1 py-1 text-left sm:px-2"
                    aria-label="Open user menu"
                >
                    <Avatar className="border-border/80 size-8 shrink-0 border shadow-2xs">
                        <AvatarImage src={user.avatar} alt={displayName} />
                        <AvatarFallback className="bg-primary/10 text-primary text-xs font-bold">
                            {getInitials(displayName)}
                        </AvatarFallback>
                    </Avatar>
                    <span className="hidden min-w-0 text-left sm:grid">
                        <span className="text-foreground truncate text-sm leading-tight font-semibold">
                            {displayName}
                        </span>
                        {jobTitle && (
                            <span className="text-muted-foreground truncate text-[10px] leading-tight">
                                {jobTitle}
                            </span>
                        )}
                    </span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end" className="w-56">
                <UserMenuContent user={{ ...user, name: displayName }} />
            </DropdownMenuContent>
        </DropdownMenu>
    );
}
