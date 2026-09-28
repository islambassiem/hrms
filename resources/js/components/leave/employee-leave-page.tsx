import { useRef, useState } from 'react';
import { LeaveApplyDrawer } from '@/components/leave/leave-apply-drawer';
import { LeaveDashboard } from '@/components/leave/leave-dashboard';
import { LeaveHistoryTable } from '@/components/leave/leave-history-table';
import type { LeavePageState } from '@/types/leave';

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

            {state.status === 'ready' && (
                <div ref={historyRef} className="scroll-mt-6">
                    <LeaveHistoryTable
                        requests={state.data.regularRequests}
                        leaveTypes={leaveTypes}
                    />
                </div>
            )}

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
