import { useRef, useState } from 'react';

import type { LeavePageState } from '@/types';

import { LeaveApplyDrawer } from './leave-apply-drawer';
import { LeaveDashboard } from './leave-dashboard';
import { LeaveHistoryTable } from './leave-history-table';

type EmployeeLeavePageProps = {
    state: LeavePageState;
    onOpenShortLeave?: () => void;
};

export function EmployeeLeavePage({
    state,
    onOpenShortLeave,
}: EmployeeLeavePageProps) {
    const [isApplyDrawerOpen, setIsApplyDrawerOpen] = useState(false);
    const historyRef = useRef<HTMLDivElement | null>(null);

    const scrollToHistory = () => {
        historyRef.current?.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        });
    };

    const leaveTypes =
        state.status === 'ready' ? state.data.availableLeaveTypes : [];

    return (
        <div className="mx-auto w-full max-w-7xl space-y-8 p-4 sm:p-6 lg:p-8">
            <LeaveDashboard
                state={state}
                onApplyForLeave={() => setIsApplyDrawerOpen(true)}
                onViewHistory={scrollToHistory}
                onOpenShortLeave={onOpenShortLeave}
            />

            {state.status === 'ready' ? (
                <div ref={historyRef} className="scroll-mt-6">
                    <LeaveHistoryTable
                        requests={state.data.regularRequests}
                        leaveTypes={leaveTypes}
                    />
                </div>
            ) : null}

            <LeaveApplyDrawer
                open={isApplyDrawerOpen}
                onOpenChange={setIsApplyDrawerOpen}
                leaveTypes={leaveTypes}
                isLoading={state.status === 'loading'}
                errorMessage={
                    state.status === 'error' ? state.message : undefined
                }
            />
        </div>
    );
}
