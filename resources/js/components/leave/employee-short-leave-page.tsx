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
        <div className="mx-auto flex w-full max-w-360 flex-col gap-6 p-4 sm:p-6">
            <ShortLeaveView
                state={state}
                onRequestShortLeave={onRequestShortLeave}
            />
        </div>
    );
}
