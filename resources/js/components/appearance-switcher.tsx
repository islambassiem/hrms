import { Button } from '@/components/ui/button';
import { Moon, Sun } from 'lucide-react';
import { useAppearance } from '@/hooks/use-appearance';

const AppearanceSwitcher = () => {
    const { resolvedAppearance, updateAppearance } = useAppearance();
    return (
        <>
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
                    <Sun className="size-6" />
                ) : (
                    <Moon className="size-6" />
                )}
            </Button>
        </>
    );
};

export default AppearanceSwitcher;
