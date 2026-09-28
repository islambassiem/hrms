import { ChevronDown, LayoutGrid } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuRadioGroup,
    DropdownMenuRadioItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { cn } from '@/lib/utils';
import type { WorkspaceId, WorkspaceOption } from '@/types/dashboard';

type Props = {
    availableWorkspaces: WorkspaceOption[];
    selectedWorkspace: WorkspaceId;
    onWorkspaceChange: (workspace: WorkspaceId) => void;
    variant?: 'default' | 'compact';
    className?: string;
};

export function WorkspaceSelector({
    availableWorkspaces,
    selectedWorkspace,
    onWorkspaceChange,
    variant = 'default',
    className,
}: Props) {
    const activeWorkspace =
        availableWorkspaces.find(
            (workspace) => workspace.id === selectedWorkspace,
        ) ??
        availableWorkspaces.find((workspace) => workspace.isDefault) ??
        availableWorkspaces[0];

    if (!activeWorkspace) {
        return null;
    }

    if (availableWorkspaces.length === 1) {
        if (variant === 'compact') {
            return (
                <Badge
                    variant="secondary"
                    className={cn(
                        'h-5 gap-1 px-1.5 text-[11px] font-medium',
                        className,
                    )}
                >
                    <LayoutGrid className="size-3" />
                    {activeWorkspace.label}
                </Badge>
            );
        }

        return (
            <div className={cn('flex items-center gap-1.5 text-xs', className)}>
                <span className="text-muted-foreground font-medium">
                    Workspace:
                </span>
                <Badge variant="secondary" className="gap-1 font-medium">
                    <LayoutGrid className="size-3" />
                    {activeWorkspace.label}
                </Badge>
            </div>
        );
    }

    if (variant === 'compact') {
        return (
            <DropdownMenu>
                <DropdownMenuTrigger asChild>
                    <Button
                        variant="outline"
                        size="sm"
                        className={cn(
                            'h-8 gap-1.5 px-2 text-xs font-medium',
                            className,
                        )}
                        aria-label="Change active workspace"
                    >
                        <span className="flex min-w-0 items-center gap-1">
                            <LayoutGrid className="text-muted-foreground size-3.5" />
                            <span className="truncate">
                                {activeWorkspace.label}
                            </span>
                        </span>
                        <ChevronDown className="size-2.5 shrink-0 opacity-60" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" className="w-56">
                    <DropdownMenuLabel className="text-xs">
                        Switch workspace
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup
                        value={activeWorkspace.id}
                        onValueChange={(value) =>
                            onWorkspaceChange(value as WorkspaceId)
                        }
                    >
                        {availableWorkspaces.map((workspace) => (
                            <DropdownMenuRadioItem
                                key={workspace.id}
                                value={workspace.id}
                                className="flex cursor-pointer flex-col items-start gap-0.5 py-2"
                            >
                                <span className="flex items-center gap-2 text-sm font-medium">
                                    <LayoutGrid className="text-muted-foreground size-3.5" />
                                    {workspace.label}
                                </span>
                                <span className="text-muted-foreground pl-5.5 text-xs">
                                    {workspace.description}
                                </span>
                            </DropdownMenuRadioItem>
                        ))}
                    </DropdownMenuRadioGroup>
                </DropdownMenuContent>
            </DropdownMenu>
        );
    }

    return (
        <div className="flex items-center gap-1.5 text-xs">
            <span className="text-muted-foreground font-medium">
                Workspace:
            </span>
            <DropdownMenu>
                <DropdownMenuTrigger asChild>
                    <Button
                        variant="outline"
                        size="sm"
                        className="h-7 gap-1.5 px-2.5 text-xs font-medium shadow-xs"
                        aria-label="Change workspace"
                    >
                        <LayoutGrid className="text-muted-foreground size-3.5" />
                        <span>{activeWorkspace.label}</span>
                        <ChevronDown className="size-3 opacity-60" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="start" className="w-56">
                    <DropdownMenuLabel className="text-xs">
                        Switch workspace
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup
                        value={activeWorkspace.id}
                        onValueChange={(value) =>
                            onWorkspaceChange(value as WorkspaceId)
                        }
                    >
                        {availableWorkspaces.map((workspace) => (
                            <DropdownMenuRadioItem
                                key={workspace.id}
                                value={workspace.id}
                                className="flex cursor-pointer flex-col items-start gap-0.5 py-2"
                            >
                                <span className="flex items-center gap-2 text-sm font-medium">
                                    <LayoutGrid className="text-muted-foreground size-3.5" />
                                    {workspace.label}
                                </span>
                                <span className="text-muted-foreground pl-5.5 text-xs">
                                    {workspace.description}
                                </span>
                            </DropdownMenuRadioItem>
                        ))}
                    </DropdownMenuRadioGroup>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    );
}
