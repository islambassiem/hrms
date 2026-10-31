export type VisaRequestStatus = 'pending' | 'processing' | 'issued';

export type VisaRequestPayment = 'pending' | 'processing' | 'paid';

export type VisaRequestPayer = 'company' | 'employee';

export type EmployeeVisaRequest = {
    id: number;
    start_date: string;
    end_date: string;
    for_year: number;
    status: VisaRequestStatus;
    payment: VisaRequestPayment;
    payer: VisaRequestPayer;
};

export type PaginatedEmployeeVisaRequests = {
    data: EmployeeVisaRequest[];
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

export type EmployeeVisaIndexPageProps = {
    initialForm: {
        mode: 'create' | 'edit' | null;
        visa: EmployeeVisaRequest | null;
    };
    visas: PaginatedEmployeeVisaRequests;
};
