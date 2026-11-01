export type ShortLeaveRequestStatus =
    | 'pending'
    | 'approved'
    | 'rejected'
    | 'cancelled';

export type ShortLeaveTypeOption = {
    id: number;
    name: string;
};

export type EmployeeShortLeaveRequest = {
    id: number;
    shortLeaveType: ShortLeaveTypeOption;
    shortLeaveDate: string;
    shortLeaveFrom: string;
    shortLeaveTo: string;
    status: ShortLeaveRequestStatus;
    submittedDate: string | null;
    canEdit: boolean;
    canDelete: boolean;
};

export type PaginatedEmployeeShortLeaveRequests = {
    data: EmployeeShortLeaveRequest[];
    links: {
        first: string | null;
        last: string | null;
        next: string | null;
        prev: string | null;
    };
    meta: {
        current_page: number;
        last_page: number;
        total: number;
    };
};

export type ShortLeaveFilters = {
    fromDate: string | null;
    shortLeaveTypeId: number | null;
    toDate: string | null;
};

export type EmployeeShortLeaveIndexPageProps = {
    initialForm: {
        mode: 'create' | 'edit' | null;
        shortLeave: EmployeeShortLeaveRequest | null;
    };
    filters: ShortLeaveFilters;
    shortLeaveRequests: PaginatedEmployeeShortLeaveRequests;
    shortLeaveTypes: ShortLeaveTypeOption[];
};
