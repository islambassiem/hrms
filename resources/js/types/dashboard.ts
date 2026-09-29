/**
 * Frontend-only contracts and fixtures for the employee landing dashboard.
 * Server data, permission-derived workspace access, persistence, and routes are deliberately deferred.
 */

export type WorkspaceId =
    | 'employee'
    | 'hr'
    | 'finance'
    | 'administration'
    | 'department-management';

export type WorkspaceOption = {
    id: WorkspaceId;
    label: string;
    description: string;
    isDefault?: boolean;
};

export type EmployeeProfileSummary = {
    avatar?: string;
    name_en: string;
    name_ar?: string;
    employee_code?: string;
    department?: string;
    job_title?: string;
    manager_name?: string;
    employment_status?: string;
    joining_date?: string;
    service_tenure?: string;
};

export type LeaveBalanceSummary = {
    available_days: number;
    annual_entitlement: number;
    used_days: number;
    pending_days: number;
    upcoming_approved_leave?: {
        leave_type: string;
        start_date: string;
        end_date: string;
        return_to_work_date: string;
    };
};

export type PendingRequestItem = {
    id: string;
    title: string;
    submitted_date: string;
    status_label: string;
};

export type AttentionDocumentItem = {
    id: string;
    title: string;
    expiry_date: string;
    severity: 'expired' | 'attention';
};

export type UpcomingMilestoneItem = {
    id: string;
    title: string;
    date: string;
    description: string;
};

export type QuickActionId =
    | 'request-leave'
    | 'attendance'
    | 'documents'
    | 'profile';

export type QuickActionItem = {
    id: QuickActionId;
    label: string;
    description: string;
};

export type EmployeeDashboardData = {
    employee: EmployeeProfileSummary | null;
    availableWorkspaces: WorkspaceOption[];
    initialWorkspace: WorkspaceId;
    leaveBalance: LeaveBalanceSummary;
    attendanceRate: number | null;
    pendingRequests: PendingRequestItem[];
    attentionDocuments: AttentionDocumentItem[];
    upcomingMilestones: UpcomingMilestoneItem[];
    quickActions: QuickActionItem[];
};

const employeeWorkspace: WorkspaceOption = {
    id: 'employee',
    label: 'Employee',
    description: 'Employee self-service workspace',
    isDefault: true,
};

const hrWorkspace: WorkspaceOption = {
    id: 'hr',
    label: 'HR',
    description: 'Human resources workspace',
};

const financeWorkspace: WorkspaceOption = {
    id: 'finance',
    label: 'Finance',
    description: 'Finance workspace',
};

const administrationWorkspace: WorkspaceOption = {
    id: 'administration',
    label: 'Administration',
    description: 'Administration workspace',
};

const departmentManagementWorkspace: WorkspaceOption = {
    id: 'department-management',
    label: 'Department Management',
    description: 'Department management workspace',
};

export const mockDashboardData: EmployeeDashboardData = {
    employee: {
        name_en: 'Abdullah Rashda',
        employee_code: '500001',
        department: 'Human Resources',
        job_title: 'HR Manager',
        manager_name: 'Prof. Abdullah M. Ablekairi (Dean)',
        employment_status: 'Active',
        joining_date: '01 Sep 2013',
        service_tenure: '13 Years Active',
    },
    availableWorkspaces: [
        employeeWorkspace,
        hrWorkspace,
        financeWorkspace,
        administrationWorkspace,
        departmentManagementWorkspace,
    ],
    initialWorkspace: 'employee',
    leaveBalance: {
        available_days: 24,
        annual_entitlement: 30,
        used_days: 6,
        pending_days: 2,
        upcoming_approved_leave: {
            leave_type: 'Annual leave',
            start_date: '12 Oct 2026',
            end_date: '16 Oct 2026',
            return_to_work_date: '18 Oct 2026',
        },
    },
    attendanceRate: 98.4,
    pendingRequests: [
        {
            id: 'request-1',
            title: 'Emergency short leave',
            submitted_date: 'Yesterday',
            status_label: 'Pending manager review',
        },
        {
            id: 'request-2',
            title: 'Annual leave request',
            submitted_date: '21 Sep 2026',
            status_label: 'Pending HR review',
        },
    ],
    attentionDocuments: [
        {
            id: 'document-1',
            title: 'National identity / Iqama',
            expiry_date: '28 Oct 2026',
            severity: 'attention',
        },
        {
            id: 'document-2',
            title: 'Professional licence',
            expiry_date: '15 Nov 2026',
            severity: 'attention',
        },
    ],
    upcomingMilestones: [
        {
            id: 'milestone-1',
            title: 'Approved annual leave begins',
            date: '12 Oct 2026',
            description: 'Return to work on 18 Oct 2026.',
        },
        {
            id: 'milestone-2',
            title: 'Work anniversary',
            date: '01 Nov 2026',
            description: 'Thirteen years of service.',
        },
    ],
    quickActions: [
        {
            id: 'request-leave',
            label: 'Request leave',
            description:
                'Start a leave request when the workflow is connected.',
        },
        {
            id: 'attendance',
            label: 'View attendance',
            description: 'Review attendance when the module is connected.',
        },
        {
            id: 'documents',
            label: 'My documents',
            description:
                'Review employee documents when the module is connected.',
        },
        {
            id: 'profile',
            label: 'View profile',
            description: 'Open the employee profile when it is available.',
        },
    ],
};
