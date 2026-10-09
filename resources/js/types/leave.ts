/**
 * Server-owned contracts for future authenticated Regular Leave and Short
 * Leave Inertia pages. Page entries must receive these values as typed props
 * and must not supply fixture or fallback employee data.
 */
export type StatusTone = 'success' | 'warning' | 'destructive' | 'muted';

export type LeaveRequestStatus =
    | 'pending'
    | 'approved'
    | 'rejected'
    | 'cancelled';

export type LeaveTypeEligibility =
    | {
          kind: 'annual-balance';
          availableDays: number;
          entitlementDays: number;
          usedDays: number;
          pendingDays: number;
      }
    | {
          kind: 'sick-tier';
          usedDays: number;
          currentTierLabel: string;
          nextTierNote?: string;
      }
    | {
          kind: 'policy-unavailable';
          message?: string;
      };

export type LeaveTypeOption = {
    id: number;
    label: string;
    description?: string;
    eligibility: LeaveTypeEligibility;
    attachmentLabel?: string;
};

export type EmployeeLeaveProfile = {
    name: string;
    employeeCode?: string;
    department?: string;
    jobTitle?: string;
};

export type AnnualLeaveSummary = {
    availableDays: number;
    entitlementDays: number;
    usedDays: number;
    pendingDays: number;
    expiringDays?: number;
    expiryDate?: string;
};

export type SickLeaveUsageSummary = {
    usedDays: number;
    currentTierLabel: string;
    nextTierNote?: string;
};

export type PendingLeaveCounts = {
    regularCount: number;
    shortCount: number;
    totalCount: number;
};

export type UpcomingApprovedLeave = {
    id: number;
    leaveTypeName: string;
    startDate: string;
    endDate: string;
    durationLabel: string;
    returnToWorkDate?: string;
};

export type RecentStatusUpdate = {
    id: number;
    requestId: number;
    title: string;
    occurredAt: string;
    statusLabel: string;
    statusTone: StatusTone;
    description?: string;
};

export type ApprovalTimelineStep = {
    id: number;
    stageName: string;
    approverName?: string;
    approverRole?: string;
    status: 'completed' | 'in_progress' | 'pending' | 'rejected';
    occurredAt?: string;
    comment?: string;
};

export type LeaveAttachment = {
    id: number;
    name: string;
    sizeLabel?: string;
    downloadAvailable: boolean;
};

export type RegularLeaveRequest = {
    id: number;
    leaveTypeId: number;
    leaveTypeName: string;
    startDate: string;
    endDate: string;
    durationLabel: string;
    appliedAt: string;
    status: LeaveRequestStatus;
    statusLabel: string;
    statusTone: StatusTone;
    currentStage?: string;
    reason?: string;
    attachments: LeaveAttachment[];
    approvalTimeline: ApprovalTimelineStep[];
    canCancel: boolean;
};

export type ShortLeaveItem = {
    id: number;
    date: string;
    startTime: string;
    endTime: string;
    durationLabel: string;
    reason?: string;
    status: LeaveRequestStatus;
    statusLabel: string;
    statusTone: StatusTone;
    currentStage?: string;
    canCancel: boolean;
};

export type ShortLeaveSummary = {
    monthlyUsageLabel?: string;
    pendingCount: number;
    policyMessage?: string;
};

export type EmployeeLeavePageData = {
    employee: EmployeeLeaveProfile;
    annualLeave: AnnualLeaveSummary | null;
    sickLeave: SickLeaveUsageSummary | null;
    pendingCounts: PendingLeaveCounts;
    upcomingApprovedLeave: UpcomingApprovedLeave | null;
    recentUpdates: RecentStatusUpdate[];
    regularRequests: RegularLeaveRequest[];
    availableLeaveTypes: LeaveTypeOption[];
};

export type ShortLeavePageData = {
    summary: ShortLeaveSummary;
    requests: ShortLeaveItem[];
};

export type LeavePageState =
    | { status: 'loading' }
    | { status: 'error'; message: string }
    | { status: 'ready'; data: EmployeeLeavePageData };

export type ShortLeavePageState =
    | { status: 'loading' }
    | { status: 'error'; message: string }
    | { status: 'ready'; data: ShortLeavePageData };
