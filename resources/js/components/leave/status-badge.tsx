import type { ReactNode } from 'react';

import { Badge } from '@/components/ui/badge';
import { cn } from '@/lib/utils';
import type { StatusTone } from '@/types';

type StatusBadgeProps = {
    children: ReactNode;
    tone?: StatusTone;
    className?: string;
};

export function StatusBadge({
    children,
    tone = 'muted',
    className,
}: StatusBadgeProps) {
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
                'h-5 px-2 text-xs font-medium tracking-tight whitespace-nowrap',
                toneClassName[tone],
                className,
            )}
        >
            {children}
        </Badge>
    );
}
