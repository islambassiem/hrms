import type { ReactNode } from 'react';
import { Badge } from '@/components/ui/badge';
import { cn } from '@/lib/utils';
import type { StatusTone } from '@/types/leave';

export function StatusBadge({
    children,
    tone = 'muted',
    className,
}: {
    children: ReactNode;
    tone?: StatusTone;
    className?: string;
}) {
    const toneClassName: Record<StatusTone, string> = {
        success: 'border-success/30 bg-success/10 text-success',
        warning: 'border-warning/30 bg-warning/10 text-warning',
        destructive: 'border-destructive/30 bg-destructive/10 text-destructive',
        muted: 'border-border bg-muted text-muted-foreground',
    };

    return (
        <Badge
            variant="outline"
            className={cn(
                'h-5 px-2 text-[11px] font-medium tracking-tight whitespace-nowrap',
                toneClassName[tone],
                className,
            )}
        >
            {children}
        </Badge>
    );
}
