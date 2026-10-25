export type FamilyVisitRequestStatus = 'pending' | 'attested';

export type EmployeeFamilyVisitRequest = {
    id: number;
    number: string;
    status: FamilyVisitRequestStatus;
};

export type PaginatedEmployeeFamilyVisitRequests = {
    data: EmployeeFamilyVisitRequest[];
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

export type EmployeeFamilyVisitIndexPageProps = {
    visits: PaginatedEmployeeFamilyVisitRequests;
};
