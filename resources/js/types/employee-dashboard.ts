/**
 * Server-owned Employee dashboard contract. `DashboardResource` is the only
 * source for these fields; UI components must not supply employee fallbacks.
 */
export type EmployeeDashboard = {
    id: number;
    name: string;
    joiningDate: string;
    jobTitle: EmployeeDashboardJobTitle | null;
    department: string | null;
    head: string | null;
    annualLeaveBalance: EmployeeDashboardAnnualLeaveBalance | null;
    contractEndDate: string | null;
    identifications: EmployeeDashboardIdentification[];
    pendingRegularLeaveRequests: EmployeeDashboardLeaveRequest[];
    upcomingApprovedRegularLeave: EmployeeDashboardLeaveRequest | null;
};

export type EmployeeDashboardJobTitle = {
    id: number;
    name: string;
};

export type EmployeeDashboardAnnualLeaveBalance = {
    availableDays: number;
    accruedDays: number;
    usedDays: number;
    pendingDays: number;
    expiringDays: number;
    nextExpiryDate: string | null;
};

export type EmployeeDashboardIdentification = {
    id: number;
    type: string | null;
    number: string;
    expiryDate: string | null;
};

export type EmployeeDashboardLeaveRequest = {
    id: number;
    leaveType: EmployeeDashboardLeaveType | null;
    startDate: string;
    endDate: string;
    durationDays: number;
    status: EmployeeDashboardLeaveRequestStatus;
    submittedDate: string;
};

export type EmployeeDashboardLeaveType = {
    id: number;
    name: string;
};

export type EmployeeDashboardLeaveRequestStatus =
    | 'pending'
    | 'approved'
    | 'rejected'
    | 'cancelled';

export type EmployeeDashboardPageProps = {
    employeeDashboard: EmployeeDashboard | null;
};
