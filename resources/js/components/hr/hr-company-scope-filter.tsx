import { Building2 } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import type {
    HRCompanyScope,
    HRCompanyScopeFilter,
    HRCompanyScopeOption,
} from '@/types/hr-dashboard';

function scopeKey(scope: HRCompanyScope): string {
    return scope.kind === 'group' ? 'group' : `entity:${scope.entityId}`;
}

function findScopeOption(
    options: HRCompanyScopeOption[],
    value: string,
): HRCompanyScopeOption | undefined {
    return options.find((option) => scopeKey(option) === value);
}

function ScopeLabel({ option }: { option: HRCompanyScopeOption }) {
    const { t } = useTranslation();

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader className="pb-3">
                <CardTitle className="text-muted-foreground text-sm font-medium">
                    {t('Company scope')}
                </CardTitle>
            </CardHeader>
            <CardContent className="flex items-center gap-3">
                <span className="bg-muted text-muted-foreground flex size-9 shrink-0 items-center justify-center rounded-lg">
                    <Building2 className="size-4" aria-hidden="true" />
                </span>
                <span className="text-foreground min-w-0 truncate font-medium">
                    {option.label}
                </span>
            </CardContent>
        </Card>
    );
}

export function HRCompanyScopeFilter({
    filter,
    onScopeChange,
}: {
    filter: HRCompanyScopeFilter | null;
    onScopeChange?: (option: HRCompanyScopeOption) => void;
}) {
    const { t } = useTranslation();

    if (filter === null || filter.options.length === 0) {
        return (
            <Card className="border-border/80 bg-sidebar shadow-xs">
                <CardHeader className="pb-3">
                    <CardTitle className="text-muted-foreground text-sm font-medium">
                        {t('Company scope')}
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p className="text-muted-foreground text-sm">
                        {t('Company scope is not available.')}
                    </p>
                </CardContent>
            </Card>
        );
    }

    const selectedKey = scopeKey(filter.selected);
    const selectedOption = findScopeOption(filter.options, selectedKey);

    if (selectedOption === undefined) {
        return (
            <Card className="border-border/80 bg-sidebar shadow-xs">
                <CardHeader className="pb-3">
                    <CardTitle className="text-muted-foreground text-sm font-medium">
                        {t('Company scope')}
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p className="text-muted-foreground text-sm">
                        {t('The selected company scope is unavailable.')}
                    </p>
                </CardContent>
            </Card>
        );
    }

    if (filter.options.length === 1) {
        return <ScopeLabel option={selectedOption} />;
    }

    return (
        <Card className="border-border/80 bg-sidebar shadow-xs">
            <CardHeader className="pb-3">
                <CardTitle className="text-muted-foreground text-sm font-medium">
                    {t('Company scope')}
                </CardTitle>
            </CardHeader>
            <CardContent>
                <Select
                    disabled={onScopeChange === undefined}
                    value={selectedKey}
                    onValueChange={(value) => {
                        const option = findScopeOption(filter.options, value);

                        if (
                            option !== undefined &&
                            onScopeChange !== undefined
                        ) {
                            onScopeChange(option);
                        }
                    }}
                >
                    <SelectTrigger
                        aria-label={t('Filter by company')}
                        className="w-full"
                    >
                        <SelectValue
                            placeholder={t('Select a company scope')}
                        />
                    </SelectTrigger>
                    <SelectContent>
                        {filter.options.map((option) => (
                            <SelectItem
                                key={scopeKey(option)}
                                value={scopeKey(option)}
                            >
                                {option.label}
                            </SelectItem>
                        ))}
                    </SelectContent>
                </Select>
                {onScopeChange === undefined ? (
                    <p className="text-muted-foreground text-xs">
                        {t('Company filtering is not available yet.')}
                    </p>
                ) : null}
            </CardContent>
        </Card>
    );
}
