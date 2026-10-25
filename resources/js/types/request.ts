export type LetterRequestStatus = 'pending' | 'done';

export type EmployeeLetterRequest = {
    id: number;
    title: string;
    description: string | null;
    notes: string | null;
    include_salary: boolean;
    attested: boolean;
    status: LetterRequestStatus;
};

export type PaginatedEmployeeLetterRequests = {
    data: EmployeeLetterRequest[];
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

export type EmployeeLetterIndexPageProps = {
    letters: PaginatedEmployeeLetterRequests;
};
