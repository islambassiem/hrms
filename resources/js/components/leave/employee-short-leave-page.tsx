import type { ShortLeavePageState } from '@/types';

import { ShortLeaveView } from './short-leave-view';

type EmployeeShortLeavePageProps = {
    state: ShortLeavePageState;
    onRequestShortLeave?: () => void;
};

export function EmployeeShortLeavePage({
    state,
    onRequestShortLeave,
}: EmployeeShortLeavePageProps) {
    return (
        <div className="mx-auto w-full max-w-7xl p-4 sm:p-6 lg:p-8">
            <ShortLeaveView
                state={state}
                onRequestShortLeave={onRequestShortLeave}
            />
        </div>
    );
}
