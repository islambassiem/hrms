import { EmployeeLeavePage } from '@/components/leave/employee-leave-page';
import { mockLeavePageState } from './data';

const Leave = () => {
    return (
        <div>
            <EmployeeLeavePage
                state={mockLeavePageState}
                onOpenShortLeave={() => {
                    console.log('Open short leave page');
                }}
            />
        </div>
    );
};

export default Leave;
