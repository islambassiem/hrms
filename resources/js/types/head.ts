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

export type HeadDirectoryGender = {
    id: number;
    name: string;
};

export type HeadDirectoryQualification = {
    scientificDegree: string | null;
    educationalSublevel: string | null;
    major: string | null;
    graduationDate: string | null;
};

export type HeadDirectoryEmployee = {
    id: number;
    employeeCode: string;
    name: string;
    image: string | null;
    gender: HeadDirectoryGender | null;
    officialEmail: string | null;
    latestQualification: HeadDirectoryQualification | null;
};

export type HeadEmployeeDirectoryFilters = {
    search: string | null;
    genderId: number | null;
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

export type HeadEmployeeDirectoryPageProps = {
    filters: HeadEmployeeDirectoryFilters;
    genders: HeadDirectoryGender[];
    employees: HeadPaginatedData<HeadDirectoryEmployee>;
};

export type HeadEmployeePosition = {
    title: string;
    startDate: string | null;
};

export type HeadEmployeeDetails = {
    id: number;
    employeeCode: string;
    name: string;
    image: string | null;
    gender: string | null;
    officialEmail: string | null;
    department: string | null;
    isActive: boolean;
    joiningDate: string | null;
    currentPosition: HeadEmployeePosition | null;
};

export type HeadEmployeeQualificationAttachment = {
    id: number;
    name: string;
    size_bytes: number;
    mime_type: string | null;
};

export type HeadEmployeeQualificationDetails = {
    id: number;
    major: string | null;
    minor: string | null;
    educationalSublevel: string | null;
    includedSpecialty: string | null;
    institutionName: string | null;
    collegeName: string | null;
    scientificDegree: string | null;
    graduationDate: string | null;
    graduationCountry: string | null;
    isLastQualification: boolean;
    rating: string | null;
    gpa: string | null;
    gpaType: string | null;
    studyType: string | null;
    city: string | null;
    isAuthenticated: boolean;
    attachments: HeadEmployeeQualificationAttachment[];
};

export type HeadEmployeeDetailsPageProps = {
    employee: HeadEmployeeDetails;
    qualifications: HeadEmployeeQualificationDetails[];
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
