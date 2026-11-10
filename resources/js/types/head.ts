export type HeadRequestStatus =
    | 'pending'
    | 'approved'
    | 'rejected'
    | 'cancelled';

export type HeadDashboardData = {
    activeStaffCount: number;
    maleStaffCount: number;
    femaleStaffCount: number;
    pendingRegularLeaveCount: number;
    pendingShortLeaveCount: number;
    employeesOnLeaveTodayCount: number;
};

export type HeadEmployeeOption = {
    id: number;
    name: string;
    employeeCode: string;
};

export type HeadLeaveTypeOption = {
    id: number;
    label: string;
    description: string | null;
};

export type HeadShortLeaveTypeOption = {
    id: number;
    name: string;
};

export type HeadPageLinkSet = {
    first: string | null;
    last: string | null;
    next: string | null;
    prev: string | null;
};

export type HeadPageMeta = {
    current_page: number;
    last_page: number;
    total: number;
};

export type HeadPaginatedData<T> = {
    data: T[];
    links: HeadPageLinkSet;
    meta: HeadPageMeta;
};

export type HeadLeaveRequest = {
    id: number;
    employee: HeadEmployeeOption | null;
    leaveType: Pick<HeadLeaveTypeOption, 'id' | 'label'> | null;
    startDate: string;
    endDate: string;
    durationDays: number;
    status: HeadRequestStatus;
    submittedDate: string;
    reason: string | null;
};

export type HeadShortLeaveRequest = {
    id: number;
    employee: HeadEmployeeOption | null;
    shortLeaveType: HeadShortLeaveTypeOption | null;
    date: string;
    from: string;
    to: string;
    status: HeadRequestStatus;
    submittedDate: string;
};

export type HeadLeaveFilters = {
    employeeId: number | null;
    leaveTypeId: number | null;
    status: HeadRequestStatus | null;
    startDate: string | null;
    endDate: string | null;
};

export type HeadShortLeaveFilters = {
    employeeId: number | null;
    shortLeaveTypeId: number | null;
    status: HeadRequestStatus | null;
    fromDate: string | null;
    toDate: string | null;
};

export type HeadDashboardPageProps = {
    headDashboard: HeadDashboardData;
};

export type HeadLeaveIndexPageProps = {
    filters: HeadLeaveFilters;
    employees: HeadEmployeeOption[];
    leaveTypes: HeadLeaveTypeOption[];
    statuses: HeadRequestStatus[];
    leaveRequests: HeadPaginatedData<HeadLeaveRequest>;
};

export type HeadShortLeaveIndexPageProps = {
    filters: HeadShortLeaveFilters;
    employees: HeadEmployeeOption[];
    shortLeaveTypes: HeadShortLeaveTypeOption[];
    statuses: HeadRequestStatus[];
    shortLeaveRequests: HeadPaginatedData<HeadShortLeaveRequest>;
};
