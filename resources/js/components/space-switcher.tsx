import { Link, usePage } from '@inertiajs/react';
import {
    Building2,
    Check,
    ChevronsUpDown,
    User,
    UserCog,
    type LucideIcon,
} from 'lucide-react';

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import type { SharedData, Space } from '@/types';

const icons: Record<Space['key'], LucideIcon> = {
    employee: User,
    hr: Building2,
    head: UserCog,
};

function SpaceIcon({ space }: { space: Space }) {
    const Icon = icons[space.key];
    return (
        <div className="bg-primary text-primary-foreground flex aspect-square size-8 items-center justify-center rounded-md">
            <Icon className="size-4" />
        </div>
    );
}

export function SpaceSwitcher() {
    const { spaces, currentSpace } = usePage<SharedData>().props;
    const { isMobile, state } = useSidebar();

    const active = spaces.find((s) => s.key === currentSpace) ?? spaces[0];
    if (!active) return null;

    const content = (
        <>
            <SpaceIcon space={active} />
            <div className="grid flex-1 text-left text-sm leading-tight">
                <span className="truncate font-semibold">{active.name}</span>
                <span className="text-muted-foreground truncate text-xs">
                    {active.description}
                </span>
            </div>
        </>
    );

    // Only the employee space available: no dropdown needed.
    if (spaces.length === 1) {
        return (
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="sm" asChild>
                        <Link href={active.href} prefetch>
                            {content}
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        );
    }

    return (
        <SidebarMenu>
            <SidebarMenuItem>
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <SidebarMenuButton
                            size="sm"
                            className="data-[state=open]:bg-sidebar-accent"
                        >
                            {content}
                            <ChevronsUpDown className="ml-auto size-4" />
                        </SidebarMenuButton>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent
                        className="w-(--radix-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                        align="end"
                        side={
                            isMobile
                                ? 'bottom'
                                : state === 'collapsed'
                                  ? 'right'
                                  : 'bottom'
                        }
                        sideOffset={4}
                    >
                        <DropdownMenuLabel className="text-muted-foreground text-xs">
                            Switch space
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        {spaces.map((space) => (
                            <DropdownMenuItem
                                key={space.key}
                                asChild
                                className="gap-2 p-2"
                            >
                                <Link href={space.href} prefetch>
                                    <SpaceIcon space={space} />
                                    <div className="grid flex-1 leading-tight">
                                        <span className="text-sm font-medium">
                                            {space.name}
                                        </span>
                                        <span className="text-muted-foreground text-xs">
                                            {space.description}
                                        </span>
                                    </div>
                                    {space.key === active.key && (
                                        <Check className="size-4" />
                                    )}
                                </Link>
                            </DropdownMenuItem>
                        ))}
                    </DropdownMenuContent>
                </DropdownMenu>
            </SidebarMenuItem>
        </SidebarMenu>
    );
}
