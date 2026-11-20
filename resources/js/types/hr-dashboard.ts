export type HRCompanyScope =
    | { kind: 'group' }
    | { kind: 'entity'; entityId: number };

export type HRCompanyScopeOption =
    | { kind: 'group'; label: string }
    | { kind: 'entity'; entityId: number; label: string };

export type HRCompanyScopeFilter = {
    options: HRCompanyScopeOption[];
    selected: HRCompanyScope;
};

export type HRDashboardRequestType =
    | 'leave'
    | 'shortLeave'
    | 'letter'
    | 'familyVisit'
    | 'visa';

export type HRDashboardMetrics = {
    pendingRequests: number | null;
    employeesAwayToday: number | null;
    newRequests: number | null;
    totalActiveEmployees: {
        total: number | null;
        male: number | null;
        female: number | null;
    } | null;
};

export type HRDashboardActionRequest = {
    id: string;
    requestType: HRDashboardRequestType;
    employeeName: string;
    companyName: string;
    submittedAt: string;
    statusLabel: string;
    isOlderThan48Hours: boolean;
};

export type HRDashboardActionCenter =
    | { status: 'available'; requests: HRDashboardActionRequest[] }
    | { status: 'unavailable' };

export type HRUpcomingLeave = {
    id: number;
    employeeName: string;
    companyName: string;
    leaveType: string;
    startDate: string;
    endDate: string;
};

export type HRRecentQualification = {
    id: number;
    employeeName: string;
    companyName: string;
    qualification: string;
    updatedAt: string;
};

export type HRRequestsBreakdownItem = {
    requestType: HRDashboardRequestType;
    pendingCount: number;
    completedCount: number;
};

export type HRCompanyComparisonItem = {
    companyId: number;
    companyName: string;
    activeEmployees: number;
    pendingRequests: number;
    employeesAwayToday: number;
};

export type HRDashboardList<T> =
    | { status: 'available'; items: T[] }
    | { status: 'unavailable' };

export type HRDashboardData = {
    companyScope: HRCompanyScopeFilter;
    metrics: HRDashboardMetrics;
    actionCenter: HRDashboardActionCenter;
    upcomingLeaves: HRDashboardList<HRUpcomingLeave>;
    recentQualifications: HRDashboardList<HRRecentQualification>;
    requestsBreakdown: HRDashboardList<HRRequestsBreakdownItem>;
    companyComparison: HRDashboardList<HRCompanyComparisonItem>;
};

export type HRDashboardPageProps = {
    hrDashboard?: HRDashboardData | null;
};
